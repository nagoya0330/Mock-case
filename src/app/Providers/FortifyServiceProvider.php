<?php

namespace App\Providers;

use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Fortify の設定
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        // ログインビュー
        Fortify::loginView(function () {
            return view('auth.login');
        });

        // 会員登録ビュー（※処理自体は RegisterController で行う）
        Fortify::registerView(function () {
            return view('auth.register');
        });

        // ログインレート制限
        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(
                Str::lower($request->input(Fortify::username())) . '|' . $request->ip()
            );
            return Limit::perMinute(5)->by($throttleKey);
        });

        // 2段階認証レート制限（未使用ならそのままでもOK）
        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        // ログイン時のバリデーションを LoginRequest に委ねる
        Fortify::authenticateUsing(function (LoginRequest $request) {
            $request->validated();
            return Auth::attempt($request->only('email', 'password')) ? Auth::user() : null;
        });

        Fortify::verifyEmailView(function () {
            return view('auth.verify-email');
        });
    }
}
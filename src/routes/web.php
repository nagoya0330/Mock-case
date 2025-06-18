<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\VerifyEmailController;
use App\Http\Controllers\ProfileSettingController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Fortify オーバーライド：ログイン時に LoginRequest を使う
|--------------------------------------------------------------------------
*/
Route::post('/login', function (LoginRequest $request) {
    if (Auth::attempt($request->only('email', 'password'))) {
        $request->session()->regenerate();
        return redirect()->intended('/');
    }

    return back()->withErrors([
        'email' => 'ログイン情報が登録されていません。',
    ])->withInput();
})->middleware(['guest'])->name('login');

/*
|--------------------------------------------------------------------------
| 認証関連ルート
|--------------------------------------------------------------------------
*/
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

/*
|--------------------------------------------------------------------------
| 🔓 未ログインでもアクセス可能なルート
|--------------------------------------------------------------------------
*/
// トップページ（商品一覧）
Route::get('/', [ItemController::class, 'index'])->name('home');

// 商品詳細
Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('item.detail');


// Stripe仮処理
Route::get('/purchase/stripe/{item_id}', fn() => 'ここでStripe決済処理を行います（仮）')->name('stripe.checkout');

/*
|--------------------------------------------------------------------------
| 🔐 ログイン + 認証済みが必要なルート
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    // プロフィール設定
    Route::get('/mypage/profile', [ProfileSettingController::class, 'edit'])->name('profile.setting');
    Route::post('/mypage/profile', [ProfileSettingController::class, 'store'])->name('profile.setting.store');

    // マイページ
    Route::get('/mypage', [ProfileController::class, 'show'])->name('profile.show');
});

/*
|--------------------------------------------------------------------------
| 🔐 ログインのみ必要なルート（認証済みは不要）
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::post('/items/{item_id}/comment', [CommentController::class, 'store'])->name('comment.store');
    Route::post('/favorite/{item}', [FavoriteController::class, 'toggle'])->name('favorite.toggle');

    // 購入関連
    Route::get('/purchase/{item_id}', [PurchaseController::class, 'confirm'])->name('purchase.confirm');
    Route::post('/purchase/{item_id}', [PurchaseController::class, 'confirmPost'])->name('purchase.confirm.post');
    Route::post('/purchase/{item_id}/store', [PurchaseController::class, 'store'])->name('purchase.store');

    // 住所変更
    Route::get('/purchase/address/{item_id}', [AddressController::class, 'edit'])->name('purchase.address.edit');
    Route::post('/address/update/{item_id}', [AddressController::class, 'update'])->name('address.update');

    // 商品出品
    Route::get('/sell', [ItemController::class, 'create'])->name('products.create');
    Route::post('/sell', [ItemController::class, 'store'])->name('products.store');

    // Stripe 決済処理
    Route::get('/purchase/stripe/{item_id}', function ($item_id) {
        return 'ここでStripe決済処理を行います（仮）';
    })->name('stripe.checkout');
});

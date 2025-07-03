@extends('layouts.auth')

@section('content')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">

<div class="login-container">
    <div class="login-form-wrapper">

        <h1 class="login-title">ログイン</h1>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">メールアドレス</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                >
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">パスワード</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                >
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="button-wrapper">
                <button type="submit" class="login-button">ログインする</button>
            </div>

            <div class="link-wrapper">
                <a href="{{ route('register') }}" class="register-link">会員登録はこちら</a>
            </div>
        </form>

    </div>
</div>
@endsection
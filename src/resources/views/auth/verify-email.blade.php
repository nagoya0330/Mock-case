@extends('layouts.auth')

@section('content')
<link rel="stylesheet" href="{{ asset('css/verify.css') }}">

<div class="verify-container">
    <div class="verify-box">
        <p class="verify-message">
            登録していただいたメールアドレスに認証メールを送付しました。<br>
            メール認証を完了してください。
        </p>

        <form method="POST" action="{{ route('verification.send') }}" class="button-wrapper">
            @csrf
            <button type="submit" class="verify-button">認証はこちらから</button>
        </form>

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="resend-link">認証メールを再送する</button>
        </form>
    </div>
</div>
@endsection
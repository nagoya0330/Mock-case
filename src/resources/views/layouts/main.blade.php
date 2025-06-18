<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'アプリケーション')</title>
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    @yield('styles') <!-- ページごとのCSSがここで差し込まれる -->
</head>
<body>
    <header class="site-header">
        <div class="header-inner">
            <!-- ロゴ -->
            <div class="logo">
                <a href="/">
                    <img src="{{ asset('images/logo.svg') }}" alt="ロゴ" height="40">
                </a>
            </div>

            <!-- 検索バー -->
            <form action="{{ route('home') }}" method="GET" class="search-form">
                <input type="text" name="search" placeholder="何をお探しですか？" value="{{ request('search') }}">
            </form>

            <!-- メニュー -->
            <nav class="nav-menu">
                <a href="{{ route('profile.show') }}">マイページ</a>

                <form method="POST" action="{{ route('logout') }}" class="logout-form">
                    @csrf
                    <button type="submit">ログアウト</button>
                </form>

                <a href="{{ route('products.create') }}">出品</a>
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>
</body>
</html>
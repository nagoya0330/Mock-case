<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>flea market</title>
  <link rel="stylesheet" href="{{ asset('css/auth.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
  @yield('css')
</head>

<body>
  <header class="header">
    <div class="top-header__logo">
        <img src="{{ asset('images/logo.svg') }}" alt="ロゴ画像">
    </div>
  </header>

  <main>
    @yield('content')
  </main>
</body>

</html>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css')}}">
    <link rel="stylesheet" href="{{ asset('css/app-2.css')}}">
    @yield('css')
</head>
<body>
    <header class="header">
        <div class="header__inner">
            <h1 class="header__logo">Atte</h1>
            <div class="header__nav">
                <ul class="header__nav-inner">
                    <li class="header_nav-item">
                        <a href="/">ホーム</a>
                    </li>
                    <li class="header_nav-item">
                        <a href="/attendance">日付一覧</a>
                    </li>
                    <li class="header_nav-item">
                        <a href="/logout">ログアウト</a>
                        <!-- <form method="post" action="/logout"> -->
  <!-- <input type="hidden" name="Return_URL" value="/login"> -->
  <!-- <input type="submit" value="ログアウト" /> -->
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <main>
        <div class="main">
        @yield('content')
        </div>
    </main>
    <footer class="footer">
        <p class="footer-small"><small>Atte,inc.</small></p>
    </footer>
</body>
</html>
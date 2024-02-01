<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css')}}">
    <link rel="stylesheet" href="{{ asset('css/app.css')}}">
    @yield('css')
</head>
<body>
    <header class="header">
        <div class="header__inner">
            <h1 class="header__logo">Atte</h1>
        </div>
    </header>
    <main>
        @yield('content')
    </main>
    <footer class="footer">
        <p><small>Atte,inc.</small></p>
    </footer>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>@yield('title') - Shop Laravel</title>
    <script src="/assets/js/jquery-2.2.4.min.js" defer></script>
    <script src="/assets/js/bootstrap.min.js" defer></script>
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/font-awesome.min.css">
</head>
<body>
    <header>
        <ul class="nav">
            @if(session()->has('user_id'))
            <li><a href="/user/auth/sign-out">登出</a></li>
            @else
            <li><a href="/user/auth/sign-in">登入</a></li>
            <li><a href="/user/auth/sign-up">註冊</a></li>
            @endif
        </ul>

    </header>
    <div class="container">
        @yield('content')
    </div>
    <footer>
        <a href="#">聯絡我們</a>
    </footer>
</body>
</html>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Atte</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('css')
</head>

<body>
    <header>
        <div class="header__left">
            <span class="header__logo">
                Atte
            </span>
        </div>
        @if (Auth::check())
            <div class="header__right">
                <div class="header__right-list">
                    <form class="header__right-item" action="/" method="GET">
                    @csrf
                        <button class="header__item-link" type="submit">ホーム</button>
                    </form>
                    <form class="header__right-item" action="{{ route('attendance/date') }}" method="GET">
                    @csrf
                        <button class="header__item-link" type="submit">日付一覧</button>
                    </form>
                    <form class="header__right-item" action="{{ route('attendance/user') }}" method="GET">
                    @csrf
                        <button class="header__item-link" type="submit">勤怠表</button>
                    </form>
                    <form class="header__right-item" action="{{ route('user') }}" method="GET">
                    @csrf
                        <button class="header__item-link" type="submit">ユーザー一覧</button>
                    </form>
                    <form class="header__right-item" action="{{ route('logout') }}" method="POST">
                    @csrf
                        <button class="header__item-link" type="submit">ログアウト</button>
                    </form>
                </div>
            </div>
        @endif
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <div class="footer__item">
            <small class="footer__text">
                Atte,inc.
            </small>
        </div>
    </footer>
</body>

</html>
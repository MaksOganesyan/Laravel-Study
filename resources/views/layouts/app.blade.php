<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Новостной сайт')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <div class="container">
                <a class="navbar-brand" href="/">Новости</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item"><a class="nav-link" href="/">Главная</a></li>
                        <li class="nav-item"><a class="nav-link" href="/about">О нас</a></li>
                        <li class="nav-item"><a class="nav-link" href="/contacts">Контакты</a></li>
                        <li class="nav-item"><a class="nav-link" href="/articles">Все новости</a></li>
                    </ul>

                    <ul class="navbar-nav ms-auto">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Вход</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Регистрация</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <span class="nav-link text-white">Привет, {{ Auth::user()->name }}!</span>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.comments.index') }}">Модерация комментариев</a>
                            </li>
                            <li class="nav-item">
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="nav-link btn btn-link text-white p-0 m-0 border-0 bg-transparent">
                                        Выход
                                    </button>
                                </form>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container flex-grow-1 mt-5 pt-5">
        @yield('content')
    </main>

    <footer class="bg-light py-4 mt-auto">
        <div class="container text-center">
            <p class="mb-0">Максим Оганесян, группа 241-321</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

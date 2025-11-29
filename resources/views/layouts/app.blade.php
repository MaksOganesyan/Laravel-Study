<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Новостной сайт</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="/">Новости</a>
                <div class="navbar-nav ms-auto">
                    <a class="nav-link" href="/">Главная</a>
                    <a class="nav-link" href="/about">О нас</a>
                    <a class="nav-link" href="/contacts">Контакты</a>
                    <a class="nav-link" href="{{ route('signin') }}">Регистрация</a>
                    <a class="nav-link" href="/articles">Все новости </a>
                </div>
            </div>
        </nav>
    </header>

    <main class="container my-5">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-light py-4 mt-auto">
        <div class="container text-center">
            <p class="mb-0">Максим Оганесян, группа 241-321</p>
        </div>
    </footer>
</body>
</html>

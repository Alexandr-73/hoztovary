<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name='robots' content='noindex, nofollow'>
    <title>Админ-панель - @yield('title')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Собственные стили -->
    <link href="{{ asset('resources/css/app.css') }}" rel="stylesheet">
    @stack('styles')
    <style>
        /* Стили для адаптивного бокового меню */
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 48px 0 0;
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
            transition: transform 0.3s ease;
        }
        @media (max-width: 767.98px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .sidebar-toggle {
                position: fixed;
                top: 10px;
                left: 10px;
                z-index: 101;
                background-color: #fff;
                border-radius: 4px;
                padding: 6px 12px;
                border: 1px solid #dee2e6;
            }
            main {
                margin-left: 0 !important;
            }
        }
        @media (min-width: 768px) {
            .sidebar-toggle {
                display: none;
            }
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,.8);
        }
        .sidebar .nav-link:hover {
            color: #fff;
            background-color: rgba(255,255,255,.1);
        }
        .sidebar .nav-link i {
            margin-right: 8px;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Кнопка для открытия меню на мобильных -->
            <button class="btn btn-light sidebar-toggle d-md-none" type="button" id="sidebarToggle">
                <i class="bi bi-list"></i> Меню
            </button>

            <!-- Боковое меню -->
            <nav class="col-md-2 bg-dark sidebar min-vh-100" id="sidebar">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.products.index') }}">
                                <i class="bi bi-box"></i> Товары
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.categories.index') }}">
                                <i class="bi bi-tags"></i> Категории
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.orders.index') }}">
                                <i class="bi bi-cart"></i> Заказы
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.users.index') }}">
                                <i class="bi bi-people"></i> Пользователи
                            </a>
                        </li>
                        <li class="nav-item mt-4">
                            <a class="nav-link" href="{{ route('home') }}" target="_blank">
                                <i class="bi bi-house"></i> На сайт
                            </a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="nav-link text-white btn btn-link">
                                    <i class="bi bi-box-arrow-right"></i> Выйти
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Основное содержимое -->
            <main class="col-md-10 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">@yield('title')</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <span class="text-muted">Привет, {{ auth()->user()->name }}</span>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Переключение бокового меню на мобильных
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('sidebarToggle');
        if (toggleBtn && sidebar) {
            toggleBtn.addEventListener('click', function() {
                sidebar.classList.toggle('show');
            });
            // Закрывать меню при клике на ссылку (опционально)
            sidebar.querySelectorAll('.nav-link').forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth < 768) {
                        sidebar.classList.remove('show');
                    }
                });
            });
        }
    </script>
    @stack('scripts')
</body>

</html>
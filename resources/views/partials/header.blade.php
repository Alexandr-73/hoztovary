<header class="bg-white border-bottom shadow-sm">
    <div class="container">
        <div class="row align-items-center py-2">
            <div class="col-lg-3 col-md-4 col-6">
                <a href="{{ route('home') }}" class="d-flex align-items-center text-decoration-none">
                    <img src="/images/avater_Shkirkin.jpg" alt="Хозтовары" height="50">
                    <span class="fs-4 fw-bold ms-2 text-dark">Хозтовары</span>
                </a>
            </div>
            <div class="col-lg-6 col-md-8 col-12">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarNav">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav ms-auto">
                                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Главная</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('catalog') }}">Каталог</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">О нас</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('reviews') }}">Отзывы</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('photos') }}">Фото</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('contacts') }}">Контакты</a>
                                </li>
                            </ul>
                        </div>
                        <!-- Корзина -->
                        @php
                            $cart = session()->get('cart', []);
                            $cartCount = array_sum(array_column($cart, 'quantity'));
                        @endphp
                        <a href="{{ route('cart.index') }}"
                            class="text-primary text-decoration-none position-relative ms-2">
                            <i class="bi bi-cart fs-4"></i>
                            @if ($cartCount > 0)
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>
                    </div>
                </nav>
            </div>
            <div class="col-lg-3 col-md-12 text-md-end mt-2 mt-md-0">
                <div class="contacts">
                    <a href="tel:+79163285273" class="text-decoration-none text-dark fw-bold">+7 (916) 328-52-73</a>
                    <p class="small text-muted mb-0">Режим работы 09:00 - 20:00</p>
                    <p class="small text-muted">МО, Наро-Фоминск, ул. Жукова, 15</p>
                    <div class="social mt-1">
                        <a href="#" class="me-2 text-dark"><i class="bi bi-vk"></i></a>
                        <a href="#" class="me-2 text-dark"><i class="bi bi-telegram"></i></a>
                        <a href="#" class="text-dark"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

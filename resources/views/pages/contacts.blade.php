@extends('layouts.app')

@section('title', 'Контакты')

@section('content')
    <div class="container py-4">
        <h1 class="mb-4">Контакты</h1>

        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-geo-alt-fill text-primary"></i> Адрес</h5>
                        <p class="card-text">Московская область, Наро-Фоминск, ул. Маршала Г.К. Жукова, 15</p>

                        <h5 class="card-title"><i class="bi bi-telephone-fill text-primary"></i> Телефон</h5>
                        <p class="card-text"><a href="tel:+79163285273" class="text-decoration-none">+7 (916) 328-52-73</a>
                        </p>

                        <h5 class="card-title"><i class="bi bi-envelope-fill text-primary"></i> Email</h5>
                        <p class="card-text"><a href="mailto:info@hoztovary.ru"
                                class="text-decoration-none">info@hoztovary.ru</a></p>

                        <h5 class="card-title"><i class="bi bi-clock-fill text-primary"></i> Часы работы</h5>
                        <p class="card-text">Пн–Пт: 9:00–20:00<br>Сб–Вс: 10:00–18:00</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body p-0">
                        <!-- Карта (замените src на свой код с Яндекс.Карт) -->
                        <iframe
                            src="https://yandex.ru/map-widget/v1/?ll=36.733068%2C55.386277&z=17&l=map&text=Московская%20область%2C%20Наро-Фоминск%2C%20улица%20Маршала%20Г.К.%20Жукова%2C%2015"
                            width="100%" height="400" style="border:0; border-radius: 0 0 0.375rem 0.375rem;"
                            allowfullscreen>
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

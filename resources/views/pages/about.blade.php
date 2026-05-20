@extends('layouts.app')

@section('title', 'О нас')

@section('content')
    <div class="container py-4">
        <h1>О нас</h1>
        <div class="row">
            <div class="col-lg-8">
                <p class="lead">Мы рады приветствовать вас в нашем магазине
                    <strong>«Хозтовары»</strong>! Мы работаем для вас уже много лет,
                    помогая делать дом уютным, чистоту – безупречной, а хозяйственные
                    заботы – лёгкими и приятными.
                </p>
                <p>Наш магазин расположен в удобном месте:
                    <strong>Московская область, Наро-Фоминск,
                        улица Маршала Г.К. Жукова, 15</strong>.
                    Здесь вы всегда найдёте широкий ассортимент бытовой химии,
                    товаров для уборки, кухни, ванной и дачи. Мы стараемся,
                    чтобы каждый покупатель чувствовал себя комфортно,
                    поэтому на нашей территории организована удобная парковка,
                    в том числе для людей с инвалидностью – для нас важно,
                    чтобы доступ к необходимым товарам был у всех.
                </p>
            </div>
            <div class="col-lg-4">
                <div class="card bg-light">
                    <div class="card-body">
                        <h5 class="card-title">Наши преимущества</h5>
                        <ul class="list-unstyled">
                            <li><i class="bi bi-check-circle-fill text-success"></i> Широкий ассортимент</li>
                            <li><i class="bi bi-check-circle-fill text-success"></i> Доступные цены</li>
                            <li><i class="bi bi-check-circle-fill text-success"></i> Удобная парковка</li>
                            <li><i class="bi bi-check-circle-fill text-success"></i> Быстрая доставка</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="mt-5">В нашем ассортименте вы найдёте:</h2>
        <div class="row">
            <div class="col-md-6">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><i class="bi bi-droplet"></i> средства для стирки и чистки;</li>
                    <li class="list-group-item"><i class="bi bi-brush"></i> моющую и чистящую химию для дома;</li>
                    <li class="list-group-item"><i class="bi bi-bucket"></i> хозяйственные принадлежности (вёдра, швабры,
                        перчатки);</li>
                    <li class="list-group-item"><i class="bi bi-cup-straw"></i> товары для кухни и хранения продуктов;</li>
                    <li class="list-group-item"><i class="bi bi-tree"></i> и ещё тысячи полезных мелочей для дома и дачи.
                    </li>
                </ul>
            </div>
        </div>

        <p class="mt-4">Мы ценим каждого покупателя и всегда готовы помочь с выбором,
            подсказать оптимальное средство для ваших задач. Заходите к нам в гости
            или оформляйте заказ на сайте – мы доставим всё необходимое прямо к двери.</p>
    </div>
@endsection

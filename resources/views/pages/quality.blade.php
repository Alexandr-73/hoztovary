@extends('layouts.app')

@section('title', 'Качество товаров')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h1 class="display-4 fw-bold">Качество товаров</h1>
                <p class="lead">Только проверенные бренды</p>
                <hr class="w-25 mx-auto">
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center bg-light">
                    <div class="card-body">
                        <i class="bi bi-shield-check display-3 text-primary"></i>
                        <h4 class="mt-3">Сертифицированная продукция</h4>
                        <p class="text-muted">Все товары имеют необходимые сертификаты качества и проходят строгий контроль.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center bg-light">
                    <div class="card-body">
                        <i class="bi bi-trophy display-3 text-warning"></i>
                        <h4 class="mt-3">Ведущие производители</h4>
                        <p class="text-muted">Сотрудничаем напрямую с брендами, зарекомендовавшими себя на рынке.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center bg-light">
                    <div class="card-body">
                        <i class="bi bi-clock-history display-3 text-success"></i>
                        <h4 class="mt-3">Долговечность и надёжность</h4>
                        <p class="text-muted">Товары, которые служат долго, экономят ваши деньги и время.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <div class="bg-white p-4 rounded shadow-sm">
                    <h3 class="mb-3">Почему мы гарантируем качество?</h3>
                    <p>Мы лично тестируем товары и выбираем только лучшие экземпляры. Наши поставщики – лидеры в своих
                        сегментах, от мелкой хозяйственной утвари до садовой техники. Каждый товар перед отправкой проходит
                        проверку на соответствие стандартам. Мы уверены в продукции, которую продаём, и предлагаем гарантию
                        на большинство позиций.</p>
                    <p class="mb-0"><strong>Ваша уверенность в покупке – наша главная цель.</strong></p>
                </div>
            </div>
        </div>
    </div>
@endsection

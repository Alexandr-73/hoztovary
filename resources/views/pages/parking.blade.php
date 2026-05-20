@extends('layouts.app')

@section('title', 'Удобная парковка')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h1 class="display-4 fw-bold">Удобная парковка</h1>
                <p class="lead">Для всех, включая людей с инвалидностью</p>
                <hr class="w-25 mx-auto">
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center bg-light">
                    <div class="card-body">
                        <i class="bi bi-car-front display-3 text-primary"></i>
                        <h4 class="mt-3">Бесплатная парковка</h4>
                        <p class="text-muted">Для наших клиентов предусмотрена бесплатная парковка у входа в магазин.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center bg-light">
                    <div class="card-body">
                        <i class="bi bi-person-wheelchair display-3 text-secondary"></i>
                        <h4 class="mt-3">Места для инвалидов</h4>
                        <p class="text-muted">Специально отведённые места с удобным доступом к входной группе.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center bg-light">
                    <div class="card-body">
                        <i class="bi bi-camera display-3 text-info"></i>
                        <h4 class="mt-3">Видеонаблюдение</h4>
                        <p class="text-muted">Территория парковки под круглосуточным видеонаблюдением.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <div class="bg-white p-4 rounded shadow-sm">
                    <h3 class="mb-3">Комфортная и безопасная парковка</h3>
                    <p>Наш магазин расположен по адресу: МО, Наро-Фоминск, ул. Жукова, 15. Парковка рассчитана на 20
                        машиномест, включая 2 места для людей с инвалидностью. Доступ к пандусам и широким входам
                        обеспечивает комфортное посещение людьми с ограниченными возможностями.</p>
                    <p class="mb-0"><strong>Приезжайте к нам – ваш комфорт наша забота.</strong></p>
                </div>
            </div>
        </div>
    </div>
@endsection

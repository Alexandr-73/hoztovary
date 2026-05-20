@extends('layouts.app')

@section('title', 'Разработка сайтов | Александр Шкиркин')

@section('content')
    <div class="container py-5">
        <!-- Шапка -->
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto text-center">
                <span class="badge bg-primary mb-3">Веб‑разработчик (Laravel/Vue.js)</span>
                <h1 class="display-4 fw-bold mb-4">Разработка сайтов и веб-систем под ключ</h1>
                <p class="lead mb-4">Создаю интернет-магазины, CRM, личные кабинеты и автоматизацию для бизнеса. Реальный
                    кейс – интернет-магазин «Хозтовары» с расчётом доставки на карте.</p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="#contact" class="btn btn-primary btn-lg">Обсудить проект</a>
                    <a href="https://hoztovary.ru.tuna.am" target="_blank" class="btn btn-outline-secondary btn-lg">Портфолио
                        →</a>
                </div>
            </div>
        </div>

        <!-- QR-код на портфолио -->
        <div class="row mb-5 justify-content-center">
            <div class="col-md-4 text-center">
                <div class="bg-white p-3 rounded shadow-sm d-inline-block">
                    {!! QrCode::size(150)->generate('https://hoztovary.ru.tuna.am') !!}
                    <p class="mt-2 small text-muted">Наведите камеру → мой магазин</p>
                </div>
            </div>
        </div>

        <!-- Услуги (6 блоков) -->
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <i class="bi bi-cart4 display-3 text-primary"></i>
                        <h4 class="mt-3">Интернет-магазины</h4>
                        <p class="text-muted">Под ключ: каталог, корзина, заказы, скидки, онлайн‑касса, доставка с расчётом
                            по карте (как в «Хозтоварах»).</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <i class="bi bi-person-badge display-3 text-primary"></i>
                        <h4 class="mt-3">Личные кабинеты</h4>
                        <p class="text-muted">Для клиентов, партнёров, сотрудников – роли, доступы, история заказов,
                            документы.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <i class="bi bi-bar-chart-steps display-3 text-primary"></i>
                        <h4 class="mt-3">Автоматизация продаж</h4>
                        <p class="text-muted">Обработка заявок, статусы заказов, уведомления, интеграция с CRM (Bitrix24,
                            AmoCRM).</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <i class="bi bi-plug display-3 text-primary"></i>
                        <h4 class="mt-3">Интеграции</h4>
                        <p class="text-muted">Платежные системы (СБП, карты), онлайн-кассы (Эвотор, Комтет), API, 1С,
                            телефония, мессенджеры.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <i class="bi bi-robot display-3 text-primary"></i>
                        <h4 class="mt-3">AI‑решения</h4>
                        <p class="text-muted">AI‑чат, автоматическая обработка типовых обращений, квалификация заявок.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <i class="bi bi-palette display-3 text-primary"></i>
                        <h4 class="mt-3">UX/UI‑дизайн</h4>
                        <p class="text-muted">Прототипы, адаптивный дизайн, пользовательский путь для высокой конверсии.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Стек технологий -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="bg-light p-4 rounded">
                    <h3 class="mb-3 text-center">Технологии, с которыми работаю</h3>
                    <div class="d-flex flex-wrap justify-content-center gap-3">
                        <span class="badge bg-dark fs-6">PHP 8.4</span>
                        <span class="badge bg-dark fs-6">Laravel 12.x</span>
                        <span class="badge bg-dark fs-6">Vue.js</span>
                        <span class="badge bg-dark fs-6">JavaScript / ES6</span>
                        <span class="badge bg-dark fs-6">MySQL / PostgreSQL</span>
                        <span class="badge bg-dark fs-6">Bootstrap 5</span>
                        <span class="badge bg-dark fs-6">REST API / Webhooks</span>
                        <span class="badge bg-dark fs-6">Git</span>
                        <span class="badge bg-dark fs-6">Linux / OpenServer</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Кейс: интернет-магазин «Хозтовары» (центр внимания) -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card border-primary shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h3 class="h5 mb-0">📦 Реальный кейс: интернет-магазин «Хозтовары»</h3>
                    </div>
                    <div class="card-body">
                        <p>Вот что я разработал с нуля на Laravel:</p>
                        <ul>
                            <li>✅ Каталог товаров с фильтрами и корзиной.</li>
                            <li>✅ Автоматический расчёт доставки по карте (Яндекс.Карты) – клиент вводит адрес, видит
                                расстояние, время и стоимость доставки (50 ₽/км).</li>
                            <li>✅ Скидки и купоны, корректный расчёт НДС.</li>
                            <li>✅ Онлайн‑оплата (СБП, карты) и интеграция с кассами (Комтет, Эвотор).</li>
                            <li>✅ Админ‑панель для управления товарами, заказами, купонами.</li>
                            <li>✅ Вебхуки для автоматического обновления статусов заказов.</li>
                        </ul>
                        <p><strong>Результат:</strong> бизнес сэкономил на аренде, привлёк клиентов из удалённых районов,
                            упростил логистику и повысил доверие покупателей.</p>
                        <a href="https://hoztovary.ru.tuna.am" target="_blank" class="btn btn-outline-primary">Посмотреть
                            магазин →</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- О разработчике -->
        <div class="row mb-5">
            <div class="col-md-8 mx-auto">
                <div class="text-center">
                    <img src="{{ asset('images\avater_Shkirkin.jpg') }}" alt="Александр Шкиркин" class="rounded-circle mb-3"
                        width="120">
                    <h2>Александр Шкиркин</h2>
                    <p class="lead">Веб-разработчик, самозанятый</p>
                    <p>Специализируюсь на Laravel и Vue.js. Имею опыт создания интернет-магазина «Хозтовары» и доработки
                        существующих проектов. Работаю удалённо, заключаю договор, предоставляю чек. Помогаю бизнесу
                        автоматизировать продажи и расширять географию клиентов.</p>
                    <p><i class="bi bi-telephone"></i> 8 (916) 328-52-73 &nbsp;|&nbsp; <i class="bi bi-envelope"></i>
                        sckirkin@yandex.ru</p>
                    <div class="mt-3">
                        <a href="https://wa.me/79163285273" class="btn btn-success me-2"><i class="bi bi-whatsapp"></i>
                            WhatsApp</a>
                        <a href="https://t.me/sc_skirkin" class="btn btn-info text-white"><i class="bi bi-telegram"></i>
                            Telegram</a>
                        <a href="https://max.ru/sc_skirkin" class="btn btn-primary d-inline-flex align-items-center gap-2"
                            target="_blank" rel="noopener noreferrer">
                            <img src="{{ asset('images/max-png.png') }}" alt="MAX" height="20">
                            <span>MAX</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Форма обратной связи (структурированное ТЗ) -->
        <div id="contact" class="row">
            <div class="col-md-8 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h3 class="text-center mb-4">Обсудить проект</h3>
                        <p class="text-muted text-center mb-4">Заполните форму, и я подготовлю предварительную оценку в
                            течение дня</p>

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <form action="{{ route('developer.contact') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-bold">Ваше имя *</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Email *</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">1. Тип сайта *</label>
                                <select name="project_type" class="form-control" required>
                                    <option value="">-- Выберите --</option>
                                    <option value="Интернет-магазин">Интернет-магазин</option>
                                    <option value="Корпоративный сайт">Корпоративный сайт</option>
                                    <option value="Лендинг (посадочная страница)">Лендинг</option>
                                    <option value="Сайт-каталог">Сайт-каталог</option>
                                    <option value="CRM / Личный кабинет">CRM / Личный кабинет</option>
                                    <option value="Другое">Другое</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">2. Основные функции *</label>
                                <textarea name="features" rows="3" class="form-control"
                                    placeholder="Например: корзина, онлайн-оплата, личный кабинет, интеграция с кассой, расчёт доставки" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">3. Есть ли готовый дизайн или примеры?</label>
                                <input type="text" name="design_reference" class="form-control"
                                    placeholder="Ссылки или описание (необязательно)">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">4. Бюджет (примерно)</label>
                                <input type="text" name="budget" class="form-control"
                                    placeholder="Например: 50 000 – 100 000 ₽">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">5. Желаемые сроки</label>
                                <input type="text" name="deadline" class="form-control"
                                    placeholder="Например: через 2–3 недели">
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Отправить →</button>
                        </form>
                        <div class="mb-3">
                            <hr class="my-4">

                            <div class="text-center">
                                <h5>Или свяжитесь напрямую</h5>
                                <p class="mb-2">
                                    <i class="bi bi-telephone"></i> <strong>8 (916) 328-52-73</strong><br>
                                    <i class="bi bi-envelope"></i> sckirkin@yandex.ru
                                </p>
                                <div class="mt-3">
                                    <a href="https://wa.me/79163285273" class="btn btn-success me-2"><i
                                            class="bi bi-whatsapp"></i> WhatsApp</a>
                                    <a href="https://t.me/sc_skirkin" class="btn btn-info text-white me-2"><i
                                            class="bi bi-telegram"></i> Telegram</a>
                                    <a href="https://max.ru/sc_skirkin"
                                        class="btn btn-primary d-inline-flex align-items-center gap-2" target="_blank"
                                        rel="noopener noreferrer">
                                        <img src="{{ asset('images/max-png.png') }}" alt="MAX" height="20">
                                        <span>MAX</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

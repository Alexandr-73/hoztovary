<footer class="bg-light py-5 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <a href="{{ route('home') }}" class="d-flex align-items-center text-decoration-none mb-3">
                    <img src="/images/logo_1000.png" alt="Хозтовары" height="50">
                    <span class="fs-5 fw-bold ms-2 text-dark">Хозтовары</span>
                </a>
                <p class="small text-muted">Всё для дома и дачи с 2020 года.</p>
            </div>
            <div class="col-md-4">
                <h5>Контакты</h5>
                <p><i class="bi bi-geo-alt"></i> МО, Наро-Фоминск, ул. Маршала Жукова, 15</p>
                <p><i class="bi bi-telephone"></i> <a href="tel:+79163285273" class="text-decoration-none">+7 (916)
                        328-52-73</a></p>
                <p><i class="bi bi-envelope"></i> <a href="mailto:sckirkin@yandex.ru"
                        class="text-decoration-none">sckirkin@yandex.ru</a></p>
            </div>
            <div class="col-md-4">
                <h5>Мы в соцсетях</h5>
                <div class="social">
                    <a href="#" class="me-2 text-dark fs-4"><i class="bi bi-vk"></i></a>
                    <a href="#" class="me-2 text-dark fs-4"><i class="bi bi-telegram"></i></a>
                    <a href="#" class="text-dark fs-4"><i class="bi bi-whatsapp"></i></a>
                </div>
            </div>
        </div>
        <hr class="my-4">
        <div class="row">
            <div class="col-md-6 text-muted small">
                &copy; {{ date('Y') }} Хозтовары. Все права защищены.
            </div>
            <div class="col-md-6 text-end small">
                Разработка сайта: <a href="{{ route('developer') }}" class="text-decoration-none">Шкиркин Александр
                    Сергеевич</a>
            </div>
        </div>
    </div>
</footer>

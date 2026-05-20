@extends('admin.layouts.app')

@section('title', 'Редактирование товара')

@section('content')
    <div class="container-fluid">
        <h1>Редактирование товара: {{ $product->name }}</h1>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary mb-3">Назад</a>

        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-8">
                    <!-- Основные поля товара -->
                    <div class="card mb-3">
                        <div class="card-header">Основная информация</div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Название</label>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $product->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="slug" class="form-label">URL-код (оставьте пустым для автогенерации)</label>
                                <input type="text" name="slug" id="slug"
                                    class="form-control @error('slug') is-invalid @enderror"
                                    value="{{ old('slug', $product->slug) }}">
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="category_id" class="form-label">Категория</label>
                                <select name="category_id" id="category_id"
                                    class="form-control @error('category_id') is-invalid @enderror" required>
                                    <option value="">Выберите категорию</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Цена (₽)</label>
                                        <input type="number" step="0.01" name="price" id="price"
                                            class="form-control @error('price') is-invalid @enderror"
                                            value="{{ old('price', $product->price) }}" required>
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="stock" class="form-label">Остаток на складе</label>
                                        <input type="number" name="stock" id="stock"
                                            class="form-control @error('stock') is-invalid @enderror"
                                            value="{{ old('stock', $product->stock) }}" required>
                                        @error('stock')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Описание</label>
                                <textarea name="description" id="description" rows="5"
                                    class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-check mb-3">
                                <input type="checkbox" name="is_active" id="is_active" class="form-check-input"
                                    value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Активен (отображать на сайте)</label>
                            </div>

                            <div class="form-check mb-3">
                                <input type="checkbox" name="is_featured" id="is_featured" class="form-check-input"
                                    value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">Рекомендуемый (на главной)</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <!-- Блок для множественных изображений -->
                    <div class="card mb-3">
                        <div class="card-header">Галерея изображений (карусель)</div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="images" class="form-label">Загрузить новые изображения</label>
                                <input type="file" name="images[]" id="images" class="form-control" multiple
                                    accept="image/*">
                                <small class="text-muted">Вы можете выбрать несколько файлов одновременно (jpg, png,
                                    webp)</small>
                            </div>

                            <hr>

                            <label>Текущие изображения:</label>
                            <div id="sortable-images" class="row mt-2">
                                @foreach ($product->images as $image)
                                    <div class="col-md-4 mb-3" data-id="{{ $image->id }}">
                                        <div class="card">
                                            <img src="{{ asset('storage/' . $image->path) }}" class="card-img-top"
                                                alt="Image" style="height: 100px; object-fit: cover;">
                                            <div class="card-body p-2 text-center">
                                                <button type="button" class="btn btn-danger btn-sm delete-image"
                                                    data-id="{{ $image->id }}">Удалить</button>
                                                <input type="hidden" name="existing_images[]"
                                                    value="{{ $image->id }}">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <p class="small text-muted mt-2">Перетаскивайте изображения для изменения порядка</p>
                        </div>
                    </div>

                    <!-- Главное изображение (для обратной совместимости) -->
                    <div class="card mb-3">
                        <div class="card-header">Главное изображение (старое поле)</div>
                        <div class="card-body">
                            @if ($product->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $product->image) }}" width="100"
                                        alt="Текущее фото">
                                    <p class="small">Путь в БД: {{ $product->image }}</p>
                                </div>
                            @else
                                <p>Изображение не загружено</p>
                            @endif
                            <input type="file" name="single_image" id="single_image" class="form-control">
                            <small class="text-muted">Это поле для одного изображения (оставлено для совместимости)</small>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Обновить товар</button>
        </form>
    </div>

    <!-- Подключаем jQuery UI для сортировки (или SortableJS) -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script>
        $(function() {
            // Сортировка изображений
            $("#sortable-images").sortable({
                update: function(event, ui) {
                    var order = [];
                    $('#sortable-images .col-md-4').each(function(index) {
                        order.push($(this).data('id'));
                    });
                    // Сохраняем порядок через AJAX
                    $.ajax({
                        url: "{{ route('admin.products.images.sort', $product) }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            order: order
                        },
                        success: function(response) {
                            console.log('Порядок обновлён');
                        },
                        error: function(xhr) {
                            console.log('Ошибка при обновлении порядка');
                        }
                    });
                }
            });

            // Удаление изображения через AJAX
            $('.delete-image').on('click', function() {
                var imageId = $(this).data('id');
                var block = $(this).closest('.col-md-4');
                if (confirm('Удалить изображение?')) {
                    $.ajax({
                        url: '/admin/products/{{ $product->id }}/images/' + imageId,
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            block.remove();
                            alert('Изображение удалено');
                        },
                        error: function(xhr) {
                            alert('Ошибка при удалении');
                        }
                    });

                }
            });
        });
    </script>
@endsection

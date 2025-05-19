@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa bài viết')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Chỉnh sửa bài viết</h1>
            <a href="#" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="title" class="form-label">Tiêu đề bài viết</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                            name="title" value="{{ old('title', $post->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="address" class="form-label">Địa chỉ</label>
                        <div class="input-group">
                            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address"
                                name="address" value="{{ old('address', $post->address) }}" required>
                            <button type="button" class="btn btn-outline-secondary" id="find-address-btn">
                                <i class="fas fa-search"></i> Tìm
                            </button>
                        </div>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Chọn vị trí trên bản đồ (miễn phí với OpenStreetMap)</label>
                        <div id="map" style="height: 300px; border-radius: 10px;"></div>
                        <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $post->latitude) }}">
                        <input type="hidden" name="longitude" id="longitude"
                            value="{{ old('longitude', $post->longitude) }}">
                        <div class="form-text">Nhấn vào bản đồ để chọn vị trí quán/món ăn.</div>
                        @error('latitude')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        @error('longitude')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="type" class="form-label">Loại bài viết</label>
                        <select class="form-select @error('type') is-invalid @enderror" id="post-type" name="type"
                            required>
                            <option value="1" {{ old('type', $post->type) == 1 ? 'selected' : '' }}>Du lịch</option>
                            <option value="2" {{ old('type', $post->type) == 2 ? 'selected' : '' }}>Ẩm thực</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 food-only" id="cuisine-section" style="{{ old('type', $post->type) == 1 ? 'display: none;' : '' }}">
                        <label class="form-label">Loại món ăn</label>
                        <div>
                            @php
                                $cuisineOptions = ['Phở', 'Bún', 'Cơm', 'Street Food', 'Other'];
                                $oldCuisines = old('cuisine', json_decode($post->cuisine, true) ?? []);
                            @endphp
                            @foreach ($cuisineOptions as $option)
                                <label class="me-3">
                                    <input type="checkbox" name="cuisine[]" value="{{ $option }}"
                                        {{ in_array($option, $oldCuisines) ? 'checked' : '' }}>
                                    {{ $option }}
                                </label>
                            @endforeach
                        </div>
                        <div class="mt-2" id="cuisine-other-input"
                            style="display: {{ in_array('Other', $oldCuisines) ? 'block' : 'none' }};">
                            <input type="text" class="form-control" name="cuisine_other"
                                placeholder="Nhập loại món ăn khác (nếu có)"
                                value="{{ old('cuisine_other', collect($oldCuisines)->filter(fn($c) => !in_array($c, $cuisineOptions))->first()) }}">
                        </div>
                    </div>

                    <div class="mb-4 food-only" id="food-style-section" style="{{ old('type', $post->type) == 1 ? 'display: none;' : '' }}">
                        <label class="form-label">Phong cách</label>
                        <div>
                            @php
                                $styleOptions = ['Có Tâm', 'Family-Friendly', 'Ăn vặt', 'View đẹp'];
                                $oldStyles = old('styles', json_decode($post->styles ?? '[]', true) ?? []);
                            @endphp
                            @foreach ($styleOptions as $option)
                                <label class="me-3">
                                    <input type="checkbox" name="styles[]" value="{{ $option }}"
                                        {{ in_array($option, $oldStyles) ? 'checked' : '' }}>
                                    {{ $option }}
                                </label>
                            @endforeach
                        </div>
                        @error('styles')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 travel-only" id="travel-style-section" style="{{ old('type', $post->type) == 2 ? 'display: none;' : '' }}">
                        <label class="form-label">Phong cách du lịch</label>
                        <div>
                            @php
                                $travelStyleOptions = ['Thiên nhiên', 'Văn hóa', 'Giải trí', 'Nghỉ dưỡng', 'Phiêu lưu'];
                                $oldStyles = old('styles', json_decode($post->styles ?? '[]', true) ?? []);
                            @endphp
                            @foreach ($travelStyleOptions as $option)
                                <label class="me-3">
                                    <input type="checkbox" name="styles[]" value="{{ $option }}"
                                        {{ in_array($option, $oldStyles) ? 'checked' : '' }}>
                                    {{ $option }}
                                </label>
                            @endforeach
                        </div>
                        @error('styles')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label">Mô tả</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                            rows="10">{{ old('description', $post->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 food-only" id="min-price-section" style="{{ old('type', $post->type) == 1 ? 'display: none;' : '' }}">
                        <label for="min_price" class="form-label">Giá thấp nhất (VNĐ)</label>
                        <input type="number" class="form-control @error('min_price') is-invalid @enderror" id="min_price"
                            name="min_price" value="{{ old('min_price', $post->min_price) }}" min="0">
                        @error('min_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 food-only" id="max-price-section" style="{{ old('type', $post->type) == 1 ? 'display: none;' : '' }}">
                        <label for="max_price" class="form-label">Giá cao nhất (VNĐ)</label>
                        <input type="number" class="form-control @error('max_price') is-invalid @enderror" id="max_price"
                            name="max_price" value="{{ old('max_price', $post->max_price) }}" min="0">
                        @error('max_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Ảnh hiện tại</label>
                        <div class="row">
                            @foreach ($post->images as $image)
                                <div class="col-md-3 mb-3">
                                    <div class="position-relative">
                                        <img src="{{ asset($image->image_path) }}" class="img-fluid rounded"
                                            alt="Post image">
                                        <button type="button"
                                            class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2 delete-image"
                                            data-image-id="{{ $image->id }}">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="images" class="form-label">Thêm ảnh mới</label>
                        <input type="file" class="form-control @error('images') is-invalid @enderror" id="images"
                            name="images[]" multiple accept="image/*">
                        <div class="form-text">Bạn có thể chọn nhiều ảnh cùng lúc</div>
                        @error('images')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <div class="row" id="image-preview"></div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Các section hiện tại</label>
                        <div id="current-sections">
                            @foreach ($post->sections as $index => $section)
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <input type="hidden" name="sections[{{ $index }}][id]"
                                            value="{{ $section->id }}">
                                        <div class="mb-3">
                                            <label for="section_title" class="form-label">Tiêu đề section</label>
                                            <input type="text" class="form-control"
                                                name="sections[{{ $index }}][title]"
                                                value="{{ $section->title }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="section_content" class="form-label">Nội dung section</label>
                                            <textarea class="form-control" name="sections[{{ $index }}][content]" rows="3">{{ $section->content }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Nhúng nội dung</label>
                                            <select class="form-select embed-type"
                                                name="sections[{{ $index }}][embed_type]"
                                                data-index="{{ $index }}">
                                                <option value="">Không nhúng</option>
                                                <option value="tiktok"
                                                    {{ $section->embed_type == 'tiktok' ? 'selected' : '' }}>TikTok
                                                </option>
                                                <option value="youtube"
                                                    {{ $section->embed_type == 'youtube' ? 'selected' : '' }}>YouTube
                                                </option>
                                                <option value="map"
                                                    {{ $section->embed_type == 'map' ? 'selected' : '' }}>Google Maps
                                                </option>
                                            </select>
                                        </div>
                                        <div class="mb-3 embed-url-container" id="embed-url-{{ $index }}"
                                            style="display: {{ $section->embed_type ? 'block' : 'none' }};">
                                            <label class="form-label">URL nhúng</label>
                                            <input type="text" class="form-control"
                                                name="sections[{{ $index }}][embed_url]"
                                                value="{{ $section->embed_url }}"
                                                placeholder="Nhập URL TikTok, YouTube hoặc Google Maps">
                                        </div>
                                        @if ($section->images->count() > 0)
                                            <div class="row">
                                                @foreach ($section->images as $image)
                                                    <div class="col-md-3 mb-2">
                                                        <img src="{{ asset($image->image_path) }}"
                                                            class="img-fluid rounded" alt="Section image">
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm delete-section-image"
                                                            data-image-id="{{ $image->id }}">Xóa ảnh</button>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                        <div class="mb-3">
                                            <label for="section_images" class="form-label">Thêm ảnh section</label>
                                            <input type="file" class="form-control"
                                                name="sections[{{ $index }}][images][]" multiple accept="image/*">
                                        </div>
                                        <button type="button" class="btn btn-danger btn-sm delete-section"
                                            data-section-id="{{ $section->id }}">Xóa section</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label"><b>Thêm section mới</b></label>
                        <div id="new-sections">

                        </div>
                        <button type="button" class="btn btn-secondary" id="add-section">Thêm section</button>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Lưu thay đổi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        $(document).ready(function() {
            // Toggle form fields based on post type
            $('#post-type').on('change', function() {
                const postType = $(this).val();
                
                if (postType === '1') { // Du lịch
                    $('.food-only').hide();
                    $('.travel-only').show();
                    
                    // Clear food-specific data
                    $('input[name="cuisine[]"]').prop('checked', false);
                    $('input[name="cuisine_other"]').val('');
                    $('#food-style-section input[name="styles[]"]').prop('checked', false);
                    $('#min_price').val('');
                    $('#max_price').val('');
                } else { // Ẩm thực
                    $('.food-only').show();
                    $('.travel-only').hide();
                    
                    // Clear travel-specific data
                    $('#travel-style-section input[name="styles[]"]').prop('checked', false);
                }
            });

            // Xử lý preview ảnh mới
            $("#images").on("change", function() {
                const files = this.files;
                const preview = $("#image-preview");
                preview.empty();

                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    if (file.type.startsWith("image/")) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            preview.append(`
                            <div class="col-md-3 image-preview-item">
                                <img src="${e.target.result}" alt="Preview">
                                <div class="remove-image" data-index="${i}">
                                    <i class="fas fa-times"></i>
                                </div>
                            </div>
                            `);
                        };
                        reader.readAsDataURL(file);
                    }
                }
            });

            // Xử lý xóa ảnh preview
            $(document).on('click', '.remove-image', function() {
                const index = $(this).data('index');
                const dt = new DataTransfer();
                const input = document.getElementById('images');
                const {
                    files
                } = input;

                for (let i = 0; i < files.length; i++) {
                    if (i !== index) {
                        dt.items.add(files[i]);
                    }
                }

                input.files = dt.files;
                $(this).closest('.image-preview-item').remove();
            });

            // Xử lý xóa ảnh hiện có
            $('.delete-image').on('click', function() {
                if (confirm('Bạn có chắc chắn muốn xóa ảnh này?')) {
                    const imageId = $(this).data('image-id');
                    const imageContainer = $(this).closest('.col-md-3');

                    $.ajax({
                        url: '{{ url('/posts/images') }}/' + imageId,
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function() {
                            imageContainer.remove();
                        },
                        error: function() {
                            alert('Có lỗi xảy ra khi xóa ảnh');
                        }
                    });
                }
            });

            // Hiện/ẩn input loại món ăn khác
            $(document).on('change', 'input[name="cuisine[]"]', function() {
                if ($('input[name="cuisine[]"][value="Other"]:checked').length > 0) {
                    $('#cuisine-other-input').show();
                } else {
                    $('#cuisine-other-input').hide();
                    $('input[name="cuisine_other"]').val('');
                }
            });

            // Leaflet map
            var defaultLat = parseFloat($('#latitude').val()) || 10.762622;
            var defaultLng = parseFloat($('#longitude').val()) || 106.660172;
            var map = L.map('map').setView([defaultLat, defaultLng], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(map);
            var marker = null;
            if ($('#latitude').val() && $('#longitude').val()) {
                marker = L.marker([defaultLat, defaultLng]).addTo(map);
            }
            map.on('click', function(e) {
                var lat = e.latlng.lat;
                var lng = e.latlng.lng;
                $('#latitude').val(lat);
                $('#longitude').val(lng);
                if (marker) {
                    marker.setLatLng([lat, lng]);
                } else {
                    marker = L.marker([lat, lng]).addTo(map);
                }
            });

            // Tìm địa chỉ
            $('#find-address-btn').on('click', function() {
                var address = $('#address').val();
                if (!address) return;
                $.get('https://nominatim.openstreetmap.org/search', {
                    q: address,
                    format: 'json',
                    addressdetails: 1,
                    limit: 1
                }, function(data) {
                    if (data && data.length > 0) {
                        var lat = parseFloat(data[0].lat);
                        var lon = parseFloat(data[0].lon);
                        map.setView([lat, lon], 16);
                        $('#latitude').val(lat);
                        $('#longitude').val(lon);
                        if (marker) {
                            marker.setLatLng([lat, lon]);
                        } else {
                            marker = L.marker([lat, lon]).addTo(map);
                        }
                    } else {
                        alert('Không tìm thấy địa chỉ!');
                    }
                });
            });

            // Xử lý hiển thị/ẩn input URL nhúng
            $(document).on('change', '.embed-type', function() {
                var index = $(this).data('index');
                var embedType = $(this).val();
                if (embedType) {
                    $('#embed-url-' + index).show();
                } else {
                    $('#embed-url-' + index).hide();
                }
            });

            // Biến đếm section toàn cục
            var sectionIndex = {{ count($post->sections) }};

            // Thêm section mới
            $('#add-section').on('click', function() {
                var newSection = `
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="section_title" class="form-label">Tiêu đề section</label>
                                <input type="text" class="form-control" name="sections[${sectionIndex}][title]" required>
                            </div>
                            <div class="mb-3">
                                <label for="section_content" class="form-label">Nội dung section</label>
                                <textarea class="form-control" name="sections[${sectionIndex}][content]" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nhúng nội dung</label>
                                <select class="form-select embed-type" name="sections[${sectionIndex}][embed_type]" data-index="${sectionIndex}">
                                    <option value="">Không nhúng</option>
                                    <option value="tiktok">TikTok</option>
                                    <option value="youtube">YouTube</option>
                                    <option value="map">Google Maps</option>
                                </select>
                            </div>
                            <div class="mb-3 embed-url-container" id="embed-url-${sectionIndex}" style="display: none;">
                                <label class="form-label">URL nhúng</label>
                                <input type="text" class="form-control" name="sections[${sectionIndex}][embed_url]" placeholder="Nhập URL TikTok, YouTube hoặc Google Maps">
                            </div>
                            <div class="mb-3">
                                <label for="section_images" class="form-label">Ảnh section</label>
                                <input type="file" class="form-control" name="sections[${sectionIndex}][images][]" multiple accept="image/*">
                            </div>
                            <button type="button" class="btn btn-danger btn-sm remove-section">Xóa section</button>
                        </div>
                    </div>
                `;
                $('#new-sections').append(newSection);
                // Trigger lại sự kiện change cho select embed-type mới thêm
                $(`select[name='sections[${sectionIndex}][embed_type]']`).trigger('change');
                sectionIndex++;
            });

            // Xóa section hiện tại
            $(document).on('click', '.delete-section', function() {
                if (confirm('Bạn có chắc chắn muốn xóa section này?')) {
                    var sectionId = $(this).data('section-id');
                    var sectionContainer = $(this).closest('.card');
                    $.ajax({
                        url: '{{ url('/posts/sections') }}/' + sectionId,
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function() {
                            sectionContainer.remove();
                        },
                        error: function() {
                            alert('Có lỗi xảy ra khi xóa section');
                        }
                    });
                }
            });

            // Xóa section mới
            $(document).on('click', '.remove-section', function() {
                $(this).closest('.card').remove();
            });

            // Xử lý xóa ảnh section
            $(document).on('click', '.delete-section-image', function() {
                if (confirm('Bạn có chắc chắn muốn xóa ảnh này?')) {
                    var imageId = $(this).data('image-id');
                    var imageContainer = $(this).closest('.col-md-3');
                    $.ajax({
                        url: '{{ url('/posts/section-images') }}/' + imageId,
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function() {
                            imageContainer.remove();
                        },
                        error: function() {
                            alert('Có lỗi xảy ra khi xóa ảnh');
                        }
                    });
                }
            });

            // Trigger change event for post type
            $('#post-type').trigger('change');
        });
    </script>
@endpush

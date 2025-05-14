@extends('admin.layouts.app')

@section('title', 'Tạo bài viết mới')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tạo bài viết mới</h1>
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

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label for="title" class="form-label">Tiêu đề bài viết</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                            name="title" value="{{ old('title') }}" required autocomplete="off">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="address" class="form-label">Địa chỉ</label>
                        <div class="input-group">
                            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address"
                                name="address" value="{{ old('address') }}" required autocomplete="off">
                            <button type="button" class="btn btn-outline-secondary" id="find-address-btn">Tìm</button>
                        </div>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Chọn vị trí trên bản đồ (miễn phí với OpenStreetMap)</label>
                        <div id="map" style="height: 450px; border-radius: 10px;"></div>
                        <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                        <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
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
                        <select name="type" class="form-control @error('type') is-invalid @enderror" id="post-type">
                            <option value="1" {{ old('type') == '1' ? 'selected' : '' }}>Du lịch</option>
                            <option value="2" {{ old('type') == '2' ? 'selected' : '' }}>Ẩm thực</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 food-only" id="cuisine-section" style="{{ old('type') == '1' ? 'display: none;' : '' }}">
                        <label class="form-label">Loại món ăn</label>
                        <div>
                            @php
                                $cuisineOptions = ['Phở', 'Bún', 'Cơm', 'Street Food', 'Other'];
                                $oldCuisines = old('cuisine', []);
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
                                placeholder="Nhập loại món ăn khác (nếu có)" value="{{ old('cuisine_other') }}">
                        </div>
                        @error('cuisine')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 food-only" id="food-style-section" style="{{ old('type') == '1' ? 'display: none;' : '' }}">
                        <label class="form-label">Phong cách</label>
                        <div>
                            @php
                                $styleOptions = ['Có Tâm', 'Family-Friendly', 'Ăn vặt', 'View đẹp'];
                                $oldStyles = old('styles', []);
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

                    <div class="mb-4 travel-only" id="travel-style-section" style="{{ old('type') == '2' ? 'display: none;' : '' }}">
                        <label class="form-label">Phong cách du lịch</label>
                        <div>
                            @php
                                $travelStyleOptions = ['Thiên nhiên', 'Văn hóa', 'Giải trí', 'Nghỉ dưỡng', 'Phiêu lưu'];
                                $oldStyles = old('styles', []);
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
                            rows="10">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 food-only" id="min-price-section" style="{{ old('type') == '1' ? 'display: none;' : '' }}">
                        <label for="min_price" class="form-label">Giá thấp nhất (VNĐ)</label>
                        <input type="number" class="form-control @error('min_price') is-invalid @enderror" id="min_price"
                            name="min_price" value="{{ old('min_price') }}" min="0">
                        @error('min_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 food-only" id="max-price-section" style="{{ old('type') == '1' ? 'display: none;' : '' }}">
                        <label for="max_price" class="form-label">Giá cao nhất (VNĐ)</label>
                        <input type="number" class="form-control @error('max_price') is-invalid @enderror" id="max_price"
                            name="max_price" value="{{ old('max_price') }}" min="0">
                        @error('max_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Ảnh đại diện/Gallery lớn</label>
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

                    <hr>
                    <h5 class="mb-3">Các phần nội dung (Section)</h5>
                    <div id="sections-container">
                        @if (old('sections'))
                            @foreach (old('sections') as $index => $section)
                                <div class="card mb-3 section-item" data-index="{{ $index }}">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6>Phần nội dung <span class="section-number">{{ $index + 1 }}</span></h6>
                                            <button type="button" class="btn btn-sm btn-danger remove-section-btn"><i
                                                    class="fas fa-trash"></i> Xóa</button>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Tiêu đề phần</label>
                                            <input type="text" name="sections[{{ $index }}][title]"
                                                class="form-control @error('sections.' . $index . '.title') is-invalid @enderror"
                                                placeholder="Nhập tiêu đề" value="{{ $section['title'] }}">
                                            @error('sections.' . $index . '.title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Nội dung</label>
                                            <textarea name="sections[{{ $index }}][content]"
                                                class="form-control @error('sections.' . $index . '.content') is-invalid @enderror" rows="3"
                                                placeholder="Nhập nội dung">{{ $section['content'] }}</textarea>
                                            @error('sections.' . $index . '.content')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Ảnh cho phần này</label>
                                            <input type="file" name="sections[{{ $index }}][images][]"
                                                class="form-control section-images @error('sections.' . $index . '.images') is-invalid @enderror"
                                                multiple accept="image/*">
                                            @error('sections.' . $index . '.images')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Nhúng nội dung</label>
                                            <select name="sections[{{ $index }}][embed_type]"
                                                class="form-select embed-type-select @error('sections.' . $index . '.embed_type') is-invalid @enderror">
                                                <option value="">Không nhúng</option>
                                                <option value="tiktok"
                                                    {{ $section['embed_type'] == 'tiktok' ? 'selected' : '' }}>TikTok
                                                </option>
                                                <option value="youtube"
                                                    {{ $section['embed_type'] == 'youtube' ? 'selected' : '' }}>YouTube
                                                </option>
                                                <option value="map"
                                                    {{ $section['embed_type'] == 'map' ? 'selected' : '' }}>Google Map
                                                </option>
                                            </select>
                                            @error('sections.' . $index . '.embed_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3 embed-url-group"
                                            style="display:{{ $section['embed_type'] ? 'block' : 'none' }};">
                                            <label class="form-label">URL nhúng</label>
                                            <input type="text" name="sections[{{ $index }}][embed_url]"
                                                class="form-control embed-url-input @error('sections.' . $index . '.embed_url') is-invalid @enderror"
                                                placeholder="Dán link TikTok, YouTube hoặc Google Map"
                                                value="{{ $section['embed_url'] }}">
                                            @error('sections.' . $index . '.embed_url')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <button type="button" class="btn btn-outline-primary mb-4" id="add-section-btn">
                        <i class="fas fa-plus"></i> Thêm phần nội dung
                    </button>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Lưu bài viết
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
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

            // Xử lý preview ảnh đại diện
            $('#images').on('change', function() {
                const files = this.files;
                const preview = $('#image-preview');
                preview.empty();
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    if (file.type.startsWith('image/')) {
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
                        }
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

            // Section động
            let sectionIndex = 0;
            $('#add-section-btn').on('click', function() {
                const sectionHtml = `
                <div class="card mb-3 section-item" data-index="${sectionIndex}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6>Phần nội dung <span class="section-number">${sectionIndex + 1}</span></h6>
                            <button type="button" class="btn btn-sm btn-danger remove-section-btn"><i class="fas fa-trash"></i> Xóa</button>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tiêu đề phần</label>
                            <input type="text" name="sections[${sectionIndex}][title]" class="form-control" placeholder="Nhập tiêu đề" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nội dung</label>
                            <textarea name="sections[${sectionIndex}][content]" class="form-control" rows="3" placeholder="Nhập nội dung" autocomplete="off"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ảnh cho phần này</label>
                            <input type="file" name="sections[${sectionIndex}][images][]" class="form-control section-images" multiple accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nhúng nội dung</label>
                            <select name="sections[${sectionIndex}][embed_type]" class="form-select embed-type-select">
                                <option value="">Không nhúng</option>
                                <option value="tiktok">TikTok</option>
                                <option value="youtube">YouTube</option>
                                <option value="map">Google Map</option>
                            </select>
                        </div>
                        <div class="mb-3 embed-url-group" style="display:none;">
                            <label class="form-label">URL nhúng</label>
                            <input type="text" autocomplete="off" name="sections[${sectionIndex}][embed_url]" class="form-control embed-url-input" placeholder="Dán link TikTok, YouTube hoặc Google Map">
                        </div>
                    </div>
                </div>`;
                $('#sections-container').append(sectionHtml);
                sectionIndex++;
            });
            // Xóa section
            $(document).on('click', '.remove-section-btn', function() {
                $(this).closest('.section-item').remove();
                // Cập nhật lại số thứ tự
                $('.section-item').each(function(i, el) {
                    $(el).find('.section-number').text(i + 1);
                });
            });
            // Hiện/ẩn input URL nhúng
            $(document).on('change', '.embed-type-select', function() {
                const val = $(this).val();
                const group = $(this).closest('.card-body').find('.embed-url-group');
                if (val) {
                    group.show();
                } else {
                    group.hide();
                    group.find('input').val('');
                }
            });
            // Hiện/ẩn input loại món ăn khác
            $(document).on('change', 'input[name="cuisine[]"]', function() {
                if ($('input[name="cuisine[]"][value="Other"]:checked').length > 0) {
                    $('#cuisine-other-input').show();
                } else {
                    $('#cuisine-other-input').hide();
                    $('#cuisine-other-input input').val('');
                }
            });
        });
    </script>
    <!-- Leaflet CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var defaultLat = {{ old('latitude', 10.762622) }};
            var defaultLng = {{ old('longitude', 106.660172) }};
            var map = L.map('map').setView([defaultLat, defaultLng], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
            }).addTo(map);
            var marker;
            if (defaultLat && defaultLng && (defaultLat != 0 && defaultLng != 0)) {
                marker = L.marker([defaultLat, defaultLng]).addTo(map);
            }
            map.on('click', function(e) {
                if (marker) map.removeLayer(marker);
                marker = L.marker(e.latlng).addTo(map);
                document.getElementById('latitude').value = e.latlng.lat;
                document.getElementById('longitude').value = e.latlng.lng;
            });
            // Tìm địa chỉ bằng Nominatim
            document.getElementById('find-address-btn').addEventListener('click', function() {
                var address = document.getElementById('address').value;
                if (!address) return;
                fetch('https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(
                        address))
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.length > 0) {
                            var lat = parseFloat(data[0].lat);
                            var lon = parseFloat(data[0].lon);
                            map.setView([lat, lon], 16);
                            if (marker) map.removeLayer(marker);
                            marker = L.marker([lat, lon]).addTo(map);
                            document.getElementById('latitude').value = lat;
                            document.getElementById('longitude').value = lon;
                        } else {
                            alert('Không tìm thấy địa chỉ!');
                        }
                    });
            });
        });
    </script>
@endpush

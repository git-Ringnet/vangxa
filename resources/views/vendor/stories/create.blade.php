@extends('layouts.main')

@section('content')
    <div class="container my-5">
        <div class="row mb-4">
            <div class="col">
                <h1 class="h2 mb-0">Tạo câu chuyện mới</h1>
                <p class="text-muted">Chia sẻ câu chuyện về doanh nghiệp, sản phẩm hoặc trải nghiệm của bạn.</p>
            </div>
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

        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="{{ route('vendor.stories.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="title" class="form-label">Tiêu đề (không bắt buộc)</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    id="title" name="title" value="{{ old('title') }}"
                                    placeholder="Nhập tiêu đề cho câu chuyện của bạn">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">Nội dung câu chuyện</label>
                                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="8"
                                    placeholder="Hãy chia sẻ câu chuyện của bạn tại đây...">{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Hãy mô tả chi tiết và hấp dẫn để thu hút người đọc.</small>
                            </div>

                            <div class="mb-4">
                                <label for="image" class="form-label">Hình ảnh minh họa (không bắt buộc)</label>
                                <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image" accept="image/*">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Chọn hình ảnh minh họa cho câu chuyện của bạn. Định dạng hỗ trợ: JPG, JPEG, PNG, GIF.</small>
                                
                                <div class="mt-3 image-preview" id="imagePreview" style="display: none;">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="mb-0">Xem trước:</h6>
                                        <button type="button" class="btn btn-sm btn-outline-danger" id="removeImage">
                                            <i class="fas fa-times me-1"></i>Xóa ảnh
                                        </button>
                                    </div>
                                    <img src="" alt="Image Preview" class="img-thumbnail" style="max-height: 200px;">
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('vendor.stories.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-1"></i>Quay lại
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>Lưu câu chuyện
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm bg-light">
                    <div class="card-body">
                        <h5 class="card-title">Hướng dẫn viết câu chuyện hiệu quả</h5>
                        <ul class="card-text">
                            <li>Chia sẻ câu chuyện chân thật và cá nhân</li>
                            <li>Tập trung vào giá trị và trải nghiệm riêng biệt</li>
                            <li>Kể về quá trình phát triển sản phẩm/dịch vụ</li>
                            <li>Chia sẻ tầm nhìn và sứ mệnh của bạn</li>
                            <li>Kể về những thách thức bạn đã vượt qua</li>
                            <li>Thêm hình ảnh minh họa sẽ làm câu chuyện hấp dẫn hơn</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('image');
            const imagePreview = document.getElementById('imagePreview');
            const previewImg = imagePreview.querySelector('img');
            const removeButton = document.getElementById('removeImage');
            
            imageInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    
                    reader.addEventListener('load', function() {
                        previewImg.src = reader.result;
                        imagePreview.style.display = 'block';
                    });
                    
                    reader.readAsDataURL(file);
                } else {
                    imagePreview.style.display = 'none';
                }
            });
            
            // Xử lý khi nhấn nút xóa ảnh
            removeButton.addEventListener('click', function() {
                imageInput.value = ''; // Xóa giá trị của input file
                imagePreview.style.display = 'none'; // Ẩn khung preview
            });
        });
    </script>
@endsection

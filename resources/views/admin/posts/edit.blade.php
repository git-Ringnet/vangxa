@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa bài viết')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Chỉnh sửa bài viết</h1>
            <div>
                <a href="{{ route('posts.show', $post) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
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
                        <input type="text" class="form-control @error('address') is-invalid @enderror" id="address"
                            name="address" value="{{ old('address', $post->address) }}" required>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label">Mô tả</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                            rows="10" required>{{ old('description', $post->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Hình ảnh hiện tại</label>
                        <div class="row g-3 mb-3">
                            @forelse($post->images as $image)
                                <div class="col-md-3 image-preview-item">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" class="img-fluid rounded"
                                        alt="Post image">
                                    <div class="remove-image" data-id="{{ $image->id }}">
                                        <i class="fas fa-times"></i>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <p class="text-muted">Chưa có hình ảnh nào</p>
                                </div>
                            @endforelse
                        </div>

                        <label for="images" class="form-label">Thêm hình ảnh mới</label>
                        <input type="file" class="form-control @error('images') is-invalid @enderror" id="images"
                            name="images[]" multiple accept="image/*">
                        <div class="form-text">Bạn có thể chọn nhiều ảnh cùng lúc</div>
                        @error('images')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <div class="row" id="new-image-preview"></div>
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
<script>
    $(document).ready(function() {
        // Xử lý preview ảnh mới
        $('#images').on('change', function() {
            const files = this.files;
            const preview = $('#new-image-preview');
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

        // Xử lý xóa ảnh preview mới
        $(document).on('click', '#new-image-preview .remove-image', function() {
            const index = $(this).data('index');
            const dt = new DataTransfer();
            const input = document.getElementById('images');
            const { files } = input;

            for (let i = 0; i < files.length; i++) {
                if (i !== index) {
                    dt.items.add(files[i]);
                }
            }

            input.files = dt.files;
            $(this).closest('.image-preview-item').remove();
        });

        // Xử lý xóa ảnh hiện có
        $('.image-preview-item .remove-image').on('click', function() {
            const imageId = $(this).data('id');
            if (confirm('Bạn có chắc chắn muốn xóa ảnh này?')) {
                $.ajax({
                    url: `/admin/posts/images/${imageId}`,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $(this).closest('.image-preview-item').fadeOut();
                    }.bind(this),
                    error: function(xhr) {
                        alert('Có lỗi xảy ra khi xóa ảnh');
                    }
                });
            }
        });
    });
</script>
@endpush

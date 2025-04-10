@extends('admin.layouts.app')

@section('title', 'Sửa bài viết')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Sửa bài viết</h1>
            <a href="{{ route('posts.index') }}" class="btn btn-secondary">
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
                <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="title" class="form-label">Loại bài viết</label>
                        <select name="type" class="form-control">
                            <option value="1" {{ $post->type == 1 ? 'selected' : '' }}>Du lịch</option>
                            <option value="2" {{ $post->type == 2 ? 'selected' : '' }}>Ẩm thực</option>
                        </select>
                    </div>

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
                            rows="10">{{ old('description', $post->description) }}</textarea>
                        @error('description')
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
    <script src="{{ asset('admin/scripts.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Hàm upload ảnh
            function uploadImage(file, editor) {
                let formData = new FormData();
                formData.append('file', file);
                formData.append('_token', '{{ csrf_token() }}');

                $.ajax({
                    url: '{{ route('posts.upload-image') }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Chèn ảnh vào editor
                        $(editor).summernote('insertImage', response.location);
                    },
                    error: function(xhr) {
                        console.error('Upload failed:', xhr);
                        alert('Có lỗi xảy ra khi tải ảnh lên');
                    }
                });
            }

            // Xử lý xóa ảnh hiện có
            $('.delete-image').on('click', function() {
                if (confirm('Bạn có chắc chắn muốn xóa ảnh này?')) {
                    const imageId = $(this).data('image-id');
                    $.ajax({
                        url: '{{ url('/posts/images') }}/' + imageId,
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function() {
                            location.reload();
                        },
                        error: function() {
                            alert('Có lỗi xảy ra khi xóa ảnh');
                        }
                    });
                }
            });
        });
    </script>
@endpush

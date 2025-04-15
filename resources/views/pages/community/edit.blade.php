@extends('layouts.main')

@section('content')
    <div class="main-content">
        <div class="container-custom">
            <div class="edit-post-container">
                <h1 class="edit-post-title">Chỉnh sửa bài viết</h1>

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('community.update', $post->id) }}" method="POST" enctype="multipart/form-data"
                    id="editPostForm">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="title">Tiêu đề <span class="required">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                            name="title" value="{{ old('title', $post->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Nội dung <span class="required">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="10"
                            required>{{ old('description', $post->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                        <a href="{{ route('community.show', $post->id) }}" class="btn btn-secondary">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

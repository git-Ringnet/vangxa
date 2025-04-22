@extends('layouts.main')

@section('content')
    <div class="main-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="mb-0">Tạo nhóm mới</h2>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('groupss.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                    <label for="name" class="form-label">Tên nhóm <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" autocomplete="off"
                                        id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Mô tả</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                        rows="4">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="avatar" class="form-label">Ảnh đại diện</label>
                                            <input type="file" class="form-control @error('avatar') is-invalid @enderror"
                                                id="avatar" name="avatar" accept="image/*">
                                            @error('avatar')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Kích thước tối đa: 1MB</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="cover_image" class="form-label">Ảnh bìa</label>
                                            <input type="file"
                                                class="form-control @error('cover_image') is-invalid @enderror"
                                                id="cover_image" name="cover_image" accept="image/*">
                                            @error('cover_image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Kích thước tối đa: 2MB</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="is_private" name="is_private"
                                            value="1" {{ old('is_private') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_private">
                                            Nhóm riêng tư
                                        </label>
                                    </div>
                                    <small class="text-muted">
                                        Nhóm riêng tư chỉ hiển thị cho thành viên và yêu cầu phê duyệt để tham gia.
                                    </small>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('groupss.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Quay lại
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Tạo nhóm
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

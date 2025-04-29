@extends('layouts.main')

@section('content')
    <div class="main-content">
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">Cập nhật thông tin nhóm</h4>
                                <a href="{{ route('groupss.show', $group) }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Trở về
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('groups.update', ['id' => $group->id]) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="name" class="form-label">Tên nhóm</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name', $group->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Mô tả</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                        rows="3">{{ old('description', $group->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="cover_image" class="form-label">Ảnh bìa</label>
                                    <input type="file" class="form-control @error('cover_image') is-invalid @enderror"
                                        id="cover_image" name="cover_image" accept="image/*">
                                    @error('cover_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if ($group->cover_image)
                                        <div class="mt-2">
                                            <img src="{{ asset($group->cover_image) }}" alt="Current cover"
                                                class="img-thumbnail" style="max-height: 200px;">
                                        </div>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label for="avatar" class="form-label">Ảnh đại diện</label>
                                    <input type="file" class="form-control @error('avatar') is-invalid @enderror"
                                        id="avatar" name="avatar" accept="image/*">
                                    @error('avatar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if ($group->avatar)
                                        <div class="mt-2">
                                            <img src="{{ asset($group->avatar) }}" alt="Current avatar"
                                                class="img-thumbnail rounded-circle"
                                                style="width: 100px; height: 100px; object-fit: cover;">
                                        </div>
                                    @endif
                                </div>

                                <div class="mb-3 form-check d-none">
                                    <input type="checkbox" class="form-check-input" id="is_private" name="is_private"
                                        value="1" {{ old('is_private', $group->is_private) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_private">Nhóm riêng tư</label>
                                    <small class="form-text text-muted d-block">
                                        Nhóm riêng tư cần được chấp thuận để tham gia và không hiển thị với những người
                                        không phải là thành viên.
                                    </small>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Cập nhật
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

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="mb-3">
    <label for="name" class="form-label">Tên</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name ?? '') }}" required>
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" required>
    @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="password" class="form-label">Mật khẩu</label>
    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" {{ isset($user) ? '' : 'required' }}>
    @error('password')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    @if(isset($user))
        <small class="text-muted">Để trống nếu không muốn thay đổi mật khẩu</small>
    @endif
</div>

<div class="mb-3">
    <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
</div>

{{-- <div class="mb-3">
    <label for="role" class="form-label">Vai trò</label>
    <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
        <option value="user" {{ (old('role', $user->role ?? '') == 'user') ? 'selected' : '' }}>Người dùng</option>
        <option value="admin" {{ (old('role', $user->role ?? '') == 'admin') ? 'selected' : '' }}>Quản trị viên</option>
    </select>
    @error('role')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div> --}}
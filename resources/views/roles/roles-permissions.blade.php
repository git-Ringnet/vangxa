@extends('admin.layouts.app')

@section('content')
    <div class="container py-4">
        <h1 class="text-center mb-4">Quản Lý Role & Permission</h1>

        {{-- Danh sách roles --}}
        <div class="card shadow-sm mb-5">
            <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
                <h5 class="mb-0">Danh Sách Vai Trò (Roles)</h5>
                <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#addRoleModal">
                    <i class="bi bi-plus-lg"></i> Thêm Vai Trò
                </button>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Tên Vai Trò</th>
                            <th>Quyền (Permissions)</th>
                            <th class="text-center">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $role->name }}</td>
                                <td>
                                    @foreach ($role->permissions as $permission)
                                        <span class="badge bg-success mb-1">{{ $permission->name }}</span>
                                    @endforeach
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-info me-1" data-bs-toggle="modal"
                                        data-bs-target="#editRoleModal-{{ $role->id }}">
                                        Sửa
                                    </button>
                                    <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                            @include('roles.edit-role-modal', [
                                'role' => $role,
                                'permissions' => $permissions,
                            ])
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Danh sách permissions --}}
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center bg-secondary text-white">
                <h5 class="mb-0">Danh Sách Quyền (Permissions)</h5>
                <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#addPermissionModal">
                    <i class="bi bi-plus-lg"></i> Thêm Quyền
                </button>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Tên Quyền</th>
                            <th class="text-center">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permissions as $permission)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $permission->name }}</td>
                                <td class="text-center">
                                    <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modals --}}
    @include('roles.add-role-modal')
    @include('roles.add-permission-modal')
@endsection

@extends('layouts.main')

@section('content')
    <div class="main-content">
        <div class="container py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">Thành viên nhóm {{ $group->name }}</h4>
                                <a href="{{ route('groupss.show', $group) }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Trở về nhóm
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Thành viên</th>
                                            <th>Quyền</th>
                                            <th>Tham gia</th>
                                            @if ($group->isAdmin(auth()->user()))
                                                <th>Actions</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($members as $member)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            <h6 class="mb-0">{{ $member->name }}</h6>
                                                            <small class="text-muted">{{ $member->email }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge bg-{{ $member->pivot->role === 'admin' ? 'primary' : 'secondary' }}">
                                                        {{ ucfirst($member->pivot->role) }}
                                                    </span>
                                                </td>
                                                <td>{{ $member->pivot->joined_at }}</td>
                                                @if ($group->isAdmin(auth()->user()))
                                                    <td>
                                                        @if ($member->pivot->role !== 'admin' && $member->id !== $group->user_id)
                                                            <form
                                                                action="{{ route('groups.remove-member', [$group, $member]) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                                    onclick="return confirm('Are you sure you want to remove this member?')">
                                                                    <i class="fas fa-user-minus"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center mt-4">
                                {{ $members->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

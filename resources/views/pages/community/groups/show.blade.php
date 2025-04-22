@extends('layouts.main')

@section('content')
    <div class="main-content">
        <div class="container py-4">
            <div class="row">
                <!-- Group Header -->
                <div class="col-12">
                    <div class="card shadow-sm mb-4">
                        <div class="position-relative" style="height: 320px;">
                            <img src="{{ $group->cover_image ? asset($group->cover_image) : asset('image/default/default-group-cover.jpg') }}"
                                class="w-100 h-100 object-fit-cover" alt="{{ $group->name }}">
                            <div class="position-absolute" style="bottom: -64px; left: 32px;">
                                <img src="{{ $group->avatar ? asset($group->avatar) : asset('image/default/default-group-avatar.jpg') }}"
                                    class="rounded-circle border border-white shadow" style="width: 128px; height: 128px;">
                            </div>
                        </div>
                        <div class="card-body pt-5">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h1 class="mt-3">{{ $group->name }}</h1>
                                    <p class="lead text-muted mb-4">{{ $group->description }}</p>
                                    <div class="d-flex align-items-center gap-4 text-muted">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-users me-2 text-primary"></i>
                                            <span class="fw-bold text-dark">{{ $group->member_count }}</span>
                                            <span class="mx-1">Thành viên</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-newspaper me-2 text-primary"></i>
                                            <span class="fw-bold text-dark">{{ $group->post_count }}</span>
                                            <span class="mx-1">Bài viết</span>
                                        </div>
                                        @if ($group->is_private)
                                            <div class="badge bg-light text-dark">
                                                <i class="fas fa-lock me-1"></i>
                                                Nhóm riêng tư
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="d-flex gap-3">
                                    @if ($group->isMember(auth()->user()))
                                        @if ($group->isAdmin(auth()->user()))
                                            <form action="{{ route('groupss.destroy', ['groupss' => $group->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger">
                                                    <i class="fas fa-sign-out-alt me-2"></i>
                                                    Xóa nhóm
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('groups.leave', $group) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger">
                                                    <i class="fas fa-sign-out-alt me-2"></i>
                                                    Rời nhóm
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        <form action="{{ route('groups.join', $group) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-user-plus me-2"></i>
                                                Tham gia nhóm
                                            </button>
                                        </form>
                                    @endif

                                    @if ($group->isAdmin(auth()->user()))
                                        <a href="{{ route('groups.edit', ['id' => $group->id]) }}"
                                            class="btn btn-outline-secondary">
                                            <i class="fas fa-edit me-2"></i>
                                            Chỉnh sửa nhóm
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-lg-8">
                    @if ($group->isMember(auth()->user()))
                        <div class="card shadow-sm mb-4">
                            <div class="card-body">
                                <form action="{{ route('community.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="group_id" value="{{ $group->id }}">
                                    <input type="hidden" name="type" value="3">
                                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                    <div class="mb-3">
                                        <textarea name="description" rows="3" class="form-control" placeholder="Bạn viết gì đi..."></textarea>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-paper-plane me-2"></i>
                                            Đăng
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif

                    <!-- Posts -->
                    <div class="posts-container">
                        @forelse($group->posts as $post)
                            <div class="card shadow-sm mb-4">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div>
                                            <h5 class="mb-0">{{ $post->user->name }}</h5>
                                            <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                    <div class="post-content mb-3">
                                        {{ $post->description }}
                                    </div>
                                    <div class="d-flex gap-4 text-muted">
                                        <button class="btn btn-link text-decoration-none p-0">
                                            <i class="far fa-heart me-1"></i>
                                            Thích
                                        </button>
                                        @if (!$post->group || ($post->group && $post->group->members->contains(auth()->id())))
                                            <button class="btn btn-link text-decoration-none p-0 comment-toggle"
                                                data-post-id="{{ $post->id }}">
                                                <i class="far fa-comment me-1"></i>
                                                Bình luận
                                            </button>
                                        @endif
                                    </div>
                                    @if (!$post->group || ($post->group && $post->group->members->contains(auth()->id())))
                                        <!-- Comment Form (Hidden by default) -->
                                        <div class="comment-form mt-3" id="comment-form-{{ $post->id }}"
                                            style="display: none;">
                                            <form action="{{ route('comments.store', $post) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                                <input type="hidden" name="group_id" value="{{ $post->group_id }}">
                                                <div class="input-group">
                                                    <input type="text" name="content" class="form-control"
                                                        placeholder="Viết bình luận..." autocomplete="off">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fas fa-paper-plane"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>

                                        <!-- Comments Section -->
                                        <div class="comments-section mt-3">
                                            @if ($post->group)
                                                @if ($post->group->members->contains(auth()->id()))
                                                    <div class="comments-list">
                                                        @foreach ($post->comments->where('parent_id', null) as $comment)
                                                            @include('comments.partials.comment', [
                                                                'comment' => $comment,
                                                            ])
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <div class="alert alert-info">
                                                        <i class="fas fa-info-circle me-2"></i>
                                                        Bạn cần tham gia nhóm để xem bình luận
                                                    </div>
                                                @endif
                                            @else
                                                <div class="comments-list">
                                                    @foreach ($post->comments->where('parent_id', null) as $comment)
                                                        @include('comments.partials.comment', [
                                                            'comment' => $comment,
                                                        ])
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <div class="alert alert-info mt-3">
                                            <i class="fas fa-info-circle me-2"></i>
                                            Bạn cần tham gia nhóm để bình luận bài viết này
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="card shadow-sm text-center py-5">
                                <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                                <h3 class="h4">Không có bài viết</h3>
                                <p class="text-muted">Hãy là người đầu tiên đăng bài trong nhóm này!</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Members -->
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="card-title mb-0">Tất cả thành viên</h5>
                                <a href="{{ route('groups.members', ['id' => $group->id]) }}"
                                    class="text-primary text-decoration-none">
                                    Xem tất cả
                                </a>
                            </div>
                            <div class="members-list">
                                @foreach ($group->members->take(5)->sortBy('name') as $member)
                                    <div class="d-flex align-items-center mb-3">
                                        <div>
                                            <span class="mb-0">{{ $member->name }}</span>
                                            <small class="text-muted">({{ ucfirst($member->pivot->role) }})</small>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Group Info -->
                    <div class="card shadow-sm mt-2 p-2">
                        <h5 class="text-lg font-semibold text-gray-900 mb-4">Thông tin nhóm</h5>
                        <div class="space-y-4">
                            <div>
                                <span class="text-sm"><b>Tạo bởi:</b></span>
                                <span>{{ $group->owner ? $group->owner->name : 'Không xác định' }}</span>
                            </div>
                            <div>
                                <span class="text-sm"><b>Ngày tạo:</b></span>
                                <span>{{ $group->created_at }}</span>
                            </div>
                            <div>
                                <span class="text-sm"><b>Nhóm:</b></span>
                                <span class="text-sm">{{ $group->is_private ? 'Riêng tư' : 'Công khai' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Add Member Form -->
                    @if ($group->isAdmin(auth()->user()))
                        <div class="card shadow-sm mt-2 p-2">
                            <h5 class="text-lg font-semibold text-gray-900 mb-4">Thêm thành viên</h5>
                            <form action="{{ route('groups.add-member', ['group' => $group->id]) }}" method="POST"
                                class="space-y-4">
                                @csrf
                                @method('POST')
                                <div>
                                    <label for="user_id" class="block text-sm font-medium text-gray-700">Chọn thành
                                        viên</label>
                                    <select name="user_id" id="user_id" class="form-control">
                                        <option value="">Chọn thành viên...</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary mt-2">
                                    Thêm thành viên
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <style>
        /* Custom Styles */
        .bg-gradient {
            background: linear-gradient(45deg, #0d6efd, #6610f2);
        }

        .card {
            border: none;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .post-content {
            font-size: 1.1rem;
            line-height: 1.6;
        }

        .members-list .d-flex:hover {
            transform: translateX(5px);
            transition: transform 0.3s ease;
        }

        .btn-link:hover {
            color: #0d6efd !important;
        }

        @media (max-width: 768px) {
            .display-4 {
                font-size: 2rem;
            }

            .d-flex.gap-4 {
                flex-direction: column;
                gap: 1rem !important;
            }
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle comment form (bình luận chính)
            document.querySelectorAll('.comment-toggle').forEach(button => {
                button.addEventListener('click', function() {
                    const postId = this.dataset.postId;
                    const form = document.getElementById(`comment-form-${postId}`);
                    form.style.display = form.style.display === 'none' ? 'block' : 'none';
                    if (form.style.display === 'block') {
                        form.querySelector('input[name="content"]').focus();
                    }
                });
            });

            // Toggle reply form (phản hồi)
            document.querySelectorAll('.reply-toggle').forEach(button => {
                button.addEventListener('click', function() {
                    const commentId = this.dataset.commentId;
                    const form = document.getElementById(`reply-form-${commentId}`);
                    form.style.display = form.style.display === 'none' ? 'block' : 'none';
                    if (form.style.display === 'block') {
                        form.querySelector('input[name="content"]').focus();
                    }
                });
            });
        });
    </script>
@endsection

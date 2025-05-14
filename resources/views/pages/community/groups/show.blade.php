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

                                    <div class="dropdown">
                                        <button class="btn btn-outline-primary dropdown-toggle" type="button" id="shareGroupButton" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-share-alt me-2"></i>
                                            Chia sẻ nhóm
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="shareGroupButton">
                                            <li>
                                                <a class="dropdown-item" href="#" onclick="copyGroupLink()">
                                                    <i class="fas fa-link me-2"></i> Sao chép đường dẫn
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#" onclick="shareViaWebAPI()">
                                                    <i class="fas fa-share-alt me-2"></i> Chia sẻ qua...
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
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
                                <form action="{{ route('communities.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="group_id" value="{{ $group->id }}">
                                    <input type="hidden" name="type" value="3">
                                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                    <input type="hidden" name="page" value="nhom">
                                    <div class="mb-3">
                                        <textarea name="description" id="postDescription" rows="3" class="form-control" placeholder="Bạn viết gì đi..."
                                            autocomplete="off"></textarea>
                                        <div class="invalid-feedback" id="descriptionError">Vui lòng nhập nội dung bài viết
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tagged_vendors" class="form-label">Tag vendor</label>
                                        <select class="form-select" id="tagged_vendors" name="tagged_vendors[]" multiple>
                                            @foreach ($vendors as $vendor)
                                                <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="form-text">Bạn có thể chọn nhiều vendor để tag</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="images" class="form-label">Thêm ảnh</label>
                                        <input type="file" class="form-control" id="images" name="images[]" multiple
                                            accept="image/*">
                                        <div class="form-text">Bạn có thể chọn nhiều ảnh cùng lúc</div>
                                        <div class="invalid-feedback" id="imagesError"></div>
                                    </div>
                                    <div class="mb-3">
                                        <div id="image-preview" class="d-flex flex-wrap gap-2"></div>
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
                            <div class="border p-4 rounded-3 shadow-sm mb-4">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3 justify-content-between">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="">
                                                <img src="{{ asset('image/default/avt.png') }}" alt=""
                                                    class="rounded-circle" style="width: 30px; height: 30px;">
                                            </div>
                                            <div class="">
                                                <div class="d-flex align-items-center">
                                                    <span class="text-white">
                                                        <b>{{ $post->user->name }}</b>
                                                    </span>
                                                    <span class="mx-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="15"
                                                            height="13" viewBox="0 0 15 13" fill="none">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M7.24735 1.4282L5.37135 0.5L4.33115 2.045H2.14925V3.9512L0.248047 4.892L1.33095 6.5L0.248047 8.1077L2.14925 9.0488V10.8203H4.2405L5.37135 12.5L7.24735 11.5718L9.12335 12.5L10.2545 10.82H12.4112V9.017L14.248 8.1077L13.1648 6.5L14.248 4.8923L12.4112 3.9833V2.0453H10.1646L9.12335 0.5L7.24735 1.4282ZM9.8426 4.7957L10.6315 5.4818L6.631 8.9318L4.23875 6.8528L5.02415 6.1754L6.6296 7.5497L9.8426 4.7957Z"
                                                                fill="#0095F6" />
                                                        </svg>
                                                    </span>
                                                    @if ($post->taggedVendors->count() > 0)
                                                        <span class="text-white">
                                                            @foreach ($post->taggedVendors as $vendor)
                                                                <a href="{{ route('profile.show', $vendor->id) }}"
                                                                    class="text-decoration-none text-white">
                                                                    {{ $vendor->name }}
                                                                </a>
                                                            @endforeach
                                                        </span>
                                                    @endif
                                                </div>
                                                <p class="text-white-blur p-0 m-0">
                                                    <small>{{ $post->created_at->diffForHumans() }}</small>
                                                </p>
                                            </div>
                                        </div>
                                        @if (Auth::check() && Auth::id() == $post->user_id)
                                            <div class="dropdown">
                                                <button class="btn btn-link text-dark p-0" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M12 14C10.8954 14 10 13.1046 10 12C10 10.8954 10.8954 10 12 10C13.1046 10 14 10.8954 14 12C14 13.1046 13.1046 14 12 14Z"
                                                            fill="white" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M5 14C3.89543 14 3 13.1046 3 12C3 10.8954 3.89543 10 5 10C6.10457 10 7 10.8954 7 12C7 13.1046 6.10457 14 5 14Z"
                                                            fill="white" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M19 14C17.8954 14 17 13.1046 17 12C17 10.8954 17.8954 10 19 10C20.1046 10 21 10.8954 21 12C21 13.1046 20.1046 14 19 14Z"
                                                            fill="white" />
                                                    </svg>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                            data-bs-target="#editPostModal{{ $post->id }}">
                                                            <i class="fas fa-edit me-2"></i> Chỉnh sửa
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <form onclick="return confirm('Bạn có chắc chắn muốn xóa?')"
                                                            action="{{ route('communities.destroy', $post) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger">
                                                                <i class="fas fa-trash me-2"></i> Xóa
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="post-content mb-3 text-white description-post cursor-pointer"
                                        onclick="window.location.href='{{ route('communities.show', $post) }}'">
                                        {{ $post->description }}
                                    </div>
                                    @if ($post->images->count() > 0)
                                        <div class="post-images mb-3" data-post-id="{{ $post->id }}"
                                            data-total-images="{{ $post->images->count() }}"
                                            data-images='@json($post->images->pluck('image_path'))'>
                                            @if ($post->images->count() == 1)
                                                <div class="single-image">
                                                    <img src="{{ asset($post->images[0]->image_path) }}"
                                                        alt="Ảnh bài viết" class="img-fluid rounded cursor-pointer"
                                                        onclick="showImage(this.src, {{ $post->id }}, 0)">
                                                </div>
                                            @else
                                                <div class="row g-2">
                                                    @foreach ($post->images->take(4) as $index => $image)
                                                        <div
                                                            class="{{ $post->images->count() == 2 ? 'col-6' : 'col-4' }}">
                                                            <div class="position-relative">
                                                                <img src="{{ asset($image->image_path) }}"
                                                                    alt="Ảnh bài viết"
                                                                    class="img-fluid rounded cursor-pointer"
                                                                    onclick="showImage(this.src, {{ $post->id }}, {{ $index }})">
                                                                @if ($index == 3 && $post->images->count() > 4)
                                                                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 rounded d-flex align-items-center justify-content-center cursor-pointer"
                                                                        onclick="showImage(this.parentElement.querySelector('img').src, {{ $post->id }}, 3)">
                                                                        <span
                                                                            class="text-white fs-4">+{{ $post->images->count() - 4 }}</span>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                    <div class="d-flex gap-4 text-muted mt-2 justify-content-between">
                                        @if (Auth::check())
                                            <div class="d-flex gap-3">
                                                <button class="btn btn-link text-decoration-none p-0 like-btn"
                                                    data-post-id="{{ $post->id }}"
                                                    data-liked="{{ $post->likes->contains(auth()->id()) ? 'true' : 'false' }}">
                                                    <div class="d-flex gap-2 align-items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                            height="20" viewBox="0 0 20 20"
                                                            fill="{{ $post->likes->contains(auth()->id()) ? 'white' : 'none' }}"
                                                            class="like-icon">
                                                            <path
                                                                d="M1.49316 8.36806V8.37826C1.49315 8.93568 1.49313 9.73662 1.84578 10.7287C2.19955 11.724 2.88929 12.8643 4.19656 14.1716C6.21425 16.1893 8.4235 17.8017 9.25996 18.3886C9.70594 18.7014 10.2954 18.7014 10.7413 18.3884C11.5776 17.8014 13.7861 16.1892 15.8037 14.1716C17.1109 12.8643 17.8007 11.724 18.1544 10.7287C18.5071 9.73663 18.5071 8.93568 18.507 8.37826V8.36806C18.507 5.81629 16.7611 3.61111 14.0626 3.61111C12.8017 3.61111 11.826 4.20271 11.1026 4.94974C10.6558 5.41125 10.293 5.94345 10.0001 6.46148C9.70728 5.94345 9.34445 5.41125 8.89758 4.94974C8.17424 4.20271 7.19856 3.61111 5.93761 3.61111C3.23911 3.61111 1.49316 5.81629 1.49316 8.36806Z"
                                                                stroke="white" stroke-width="1.38889" />
                                                        </svg>
                                                        <span
                                                            class="like-count text-white">{{ $post->likes->count() }}</span>
                                                    </div>
                                                </button>
                                                @if (!$post->group || ($post->group && $post->group->members->contains(auth()->id())))
                                                    <button class="btn btn-link text-decoration-none p-0 comment-toggle"
                                                        data-post-id="{{ $post->id }}">
                                                        <div class="d-flex gap-2 align-items-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                height="20" viewBox="0 0 20 20" fill="none">
                                                                <path
                                                                    d="M17.0844 14.6863L18.0957 18.6617L14.1229 17.6498C14.0868 17.6498 14.0146 17.6498 13.9784 17.6498C12.6421 18.4087 11.053 18.7701 9.3555 18.6617C5.49104 18.3726 2.3128 15.2646 1.91552 11.3976C1.40988 6.26577 5.70774 1.96514 10.8363 2.4711C14.7008 2.86863 17.8068 6.01279 18.0957 9.91588C18.2401 11.6144 17.8429 13.2046 17.0844 14.5418C17.0844 14.614 17.0844 14.6502 17.0844 14.6863Z"
                                                                    stroke="white" stroke-width="1.38889"
                                                                    stroke-linejoin="round" />
                                                            </svg>
                                                            <span class="text-white">{{ count($post->comments) }}</span>
                                                        </div>
                                                    </button>
                                                @endif
                                            </div>
                                        @endif
                                        <!-- Share Button -->
                                        <div class="dropdown">
                                            <button class="btn btn-link text-decoration-none p-0" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <div class="d-flex gap-2 align-items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17"
                                                        viewBox="0 0 16 17" fill="none">
                                                        <path
                                                            d="M15 10.8334V13.9445C15 14.357 14.8361 14.7527 14.5444 15.0444C14.2527 15.3362 13.857 15.5 13.4444 15.5H2.55556C2.143 15.5 1.74733 15.3362 1.45561 15.0444C1.16389 14.7527 1 14.357 1 13.9445V10.8334"
                                                            stroke="white" stroke-width="1.51095" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                        <path d="M11.8901 5.38889L8.00119 1.5L4.1123 5.38889"
                                                            stroke="white" stroke-width="1.51095" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                        <path d="M8 1.5V10.8333" stroke="white" stroke-width="1.51095"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                    <span class="text-white">Chia sẻ</span>
                                                </div>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="#"
                                                        onclick="copyPostLink({{ $post->id }})">
                                                        <i class="fas fa-link me-2"></i> Sao chép liên kết
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('communities.show', $post)) }}&quote={{ urlencode($post->description) }}"
                                                        target="_blank">
                                                        <i class="fab fa-facebook me-2"></i> Facebook
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="https://twitter.com/intent/tweet?url={{ urlencode(route('communities.show', $post)) }}&text={{ urlencode($post->description) }}"
                                                        target="_blank">
                                                        <i class="fab fa-twitter me-2"></i> Twitter
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
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
                                                    {{-- <div class="comments-list">
                                                        @foreach ($post->comments->where('parent_id', null) as $comment)
                                                            @include('comments.partials.comment', [
                                                                'comment' => $comment,
                                                            ])
                                                        @endforeach
                                                    </div> --}}
                                                @else
                                                    <div class="alert alert-info">
                                                        <i class="fas fa-info-circle me-2"></i>
                                                        Bạn cần tham gia nhóm để xem bình luận
                                                    </div>
                                                @endif
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
                                <h3 class="h4 text-white">Không có bài viết</h3>
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
                                <span>{{ $group->created_at->format('d/m/Y') }}</span>
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
                                            @if (!$group->members->contains($user->id))
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endif
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
    <x-community.community-js name="nhom" />

    <!-- Edit Post Modal -->
    @foreach ($posts as $post)
        <div class="modal fade" id="editPostModal{{ $post->id }}" tabindex="-1"
            aria-labelledby="editPostModalLabel{{ $post->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPostModalLabel{{ $post->id }}">Chỉnh sửa bài viết</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('communities.update', $post) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <textarea name="description" rows="3" class="form-control" placeholder="Bạn viết gì đi..."
                                autocomplete="off">{{ $post->description }}</textarea>
                            <div class="mb-3">
                                <label for="tagged_vendors" class="form-label">Tag vendor</label>
                                <select class="form-select" id="tagged_vendors" name="tagged_vendors[]" multiple>
                                    @foreach ($vendors as $vendor)
                                        <option value="{{ $vendor->id }}"
                                            {{ $post->taggedVendors->contains($vendor->id) ? 'selected' : '' }}>
                                            {{ $vendor->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-text">Bạn có thể chọn nhiều vendor để tag</div>
                            </div>
                            @if ($post->images->count() > 0)
                                <div class="mb-3">
                                    <label class="form-label">Ảnh hiện tại</label>
                                    <div class="row g-2">
                                        @foreach ($post->images as $image)
                                            <div class="col-4">
                                                <div class="position-relative">
                                                    <img src="{{ asset($image->image_path) }}" class="img-fluid rounded"
                                                        alt="Ảnh bài viết">
                                                    <button type="button"
                                                        class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1"
                                                        onclick="deleteImage({{ $image->id }}, this)">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="mb-3">
                                <label for="images" class="form-label">Thêm ảnh mới</label>
                                <input type="file" class="form-control" id="images" name="images[]" multiple
                                    accept="image/*">
                                <div class="form-text">Bạn có thể chọn nhiều ảnh cùng lúc</div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
    <style>
        body {
            background-image: url('{{ asset('image/default/Window.png') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .dropdown-menu {
            min-width: 200px;
        }

        .dropdown-item {
            padding: 0.5rem 1rem;
        }

        .dropdown-item i {
            width: 20px;
            text-align: center;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        .show {
            display: block;
        }
    </style>
    <script>
        function copyGroupLink() {
            const groupLink = window.location.href;
            navigator.clipboard.writeText(groupLink).then(() => {
                showToast('Đã sao chép đường dẫn nhóm!', 'success');
            }).catch(err => {
                console.error('Failed to copy text: ', err);
                showToast('Có lỗi xảy ra khi sao chép đường dẫn', 'error');
            });
        }

        function shareViaWebAPI() {
            const groupLink = window.location.href;
            const groupName = '{{ $group->name }}';
            const groupDescription = '{{ $group->description }}';

            if (navigator.share) {
                navigator.share({
                    title: groupName,
                    text: groupDescription,
                    url: groupLink
                }).catch(err => {
                    console.error('Error sharing:', err);
                    showToast('Có lỗi xảy ra khi chia sẻ', 'error');
                });
                        } else {
                showToast('Trình duyệt của bạn không hỗ trợ tính năng chia sẻ này', 'error');
                        }
        }

        // Đóng dropdown khi click ra ngoài
        window.onclick = function(event) {
            if (!event.target.matches('.btn-outline-primary')) {
                const dropdowns = document.getElementsByClassName('dropdown-menu');
                for (let i = 0; i < dropdowns.length; i++) {
                    const openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
    </script>
@endsection

@extends('layouts.main')

@section('content')
    <x-community.community-js name="congdong" />
    <div>
        <div class="container-700 py-4">
            <div class="row">
                <div class="swiper-container">
                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper">
                            {{-- @if (Auth::check())
                            <div class="swiper-slide">
                                <a href="{{ route('groupss.create') }}" class="text-decoration-none">
                                    <div class="category-item text-center">
                                        <div class="category-name create-group">
                                            <i class="fas fa-plus me-1"></i>
                                            Tạo nhóm mới
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif --}}
                            @foreach ($groups as $group)
                                <div class="swiper-slide">
                                    <a href="{{ route('groupss.show', $group) }}" class="text-decoration-none">
                                        <div class="category-item text-center">
                                            <div class="category-name">{{ $group->name }}</div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    {{-- <div class="swiper-button-prev custom-nav"></div>
                <div class="swiper-button-next custom-nav"></div> --}}
                </div>
                <!-- Main Content -->
                <div class="col-lg-12 mt-4">
                    <!-- Posts -->
                    <div class="posts-container">
                        @php
                            $hasViewablePosts = false;
                        @endphp

                        @foreach ($posts as $post)
                            @if (!$post->group || ($post->group && $post->group->members->contains(auth()->id())))
                                @php
                                    $hasViewablePosts = true;
                                @endphp
                                <div class="p-4 rounded-5 border-post shadow-sm mb-4 bg-blur post-card-bg"
                                    data-post-id="{{ $post->id }}">
                                    <div class="card-body">
                                        @if ($post->group)
                                            <a href="{{ route('groupss.show', $post->group) }}"
                                                class="text-decoration-none">
                                                <p class="m-0 p-0 text-center border-bottom pb-3">
                                                    {{ $post->group->name }}
                                                </p>
                                            </a>
                                        @endif
                                        <div class="border-bottom mt-2">
                                            <div class="d-flex align-items-center mb-3 justify-content-between">
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="">
                                                        <img src="{{ asset('image/default/avt.png') }}" alt=""
                                                            class="rounded-circle" style="width: 30px; height: 30px;">
                                                    </div>
                                                    <div class="">
                                                        <div class="d-flex align-items-center">
                                                            <span>
                                                                <b>{{ $post->user->name }}</b>
                                                            </span>
                                                            @if ($post->taggedVendors->count() > 0)
                                                                <span class="mx-2">></span>
                                                                <span>
                                                                    @foreach ($post->taggedVendors as $vendor)
                                                                        <a href="{{ route('profile.show', $vendor->id) }}"
                                                                            class="text-decoration-none">
                                                                            {{ $vendor->name }}
                                                                        </a>
                                                                    @endforeach
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <p class="text-white-blur p-0 m-0">
                                                            <small>
                                                                {{ $post->created_at->diffForHumans() }}
                                                            </small>
                                                        </p>
                                                    </div>
                                                </div>
                                                @if (Auth::check() && Auth::id() == $post->user_id)
                                                    <div class="dropdown">
                                                        <button class="btn btn-link text-dark p-0" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none">
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M12 14C10.8954 14 10 13.1046 10 12C10 10.8954 10.8954 10 12 10C13.1046 10 14 10.8954 14 12C14 13.1046 13.1046 14 12 14Z"
                                                                    fill="#7c4d28" />
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M5 14C3.89543 14 3 13.1046 3 12C3 10.8954 3.89543 10 5 10C6.10457 10 7 10.8954 7 12C7 13.1046 6.10457 14 5 14Z"
                                                                    fill="#7c4d28" />
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M19 14C17.8954 14 17 13.1046 17 12C17 10.8954 17.8954 10 19 10C20.1046 10 21 10.8954 21 12C21 13.1046 20.1046 14 19 14Z"
                                                                    fill="#7c4d28" />
                                                            </svg>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a class="dropdown-item" href="#"
                                                                    data-bs-toggle="modal"
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
                                                                    <button type="submit"
                                                                        class="dropdown-item text-danger">
                                                                        <i class="fas fa-trash me-2"></i> Xóa
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="post-content mb-3 cursor-pointer description-post"
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
                                                        <div class="row g-2 images-container">
                                                            @foreach ($post->images->take(4) as $index => $image)
                                                                <div
                                                                    class="{{ $post->images->count() == 2 ? 'col-md-6' : 'col-md-4' }}">
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
                                        </div>
                                        <div class="d-flex gap-4 text-muted mt-2 justify-content-between">
                                            @if (Auth::check())
                                                <div class="d-flex gap-2">
                                                    <button class="btn btn-link text-decoration-none p-0 like-btn"
                                                        data-post-id="{{ $post->id }}"
                                                        data-liked="{{ $post->likes->contains(auth()->id()) ? 'true' : 'false' }}">
                                                        <div class="d-flex gap-2 align-items-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                height="20" viewBox="0 0 20 20"
                                                                fill="{{ $post->likes->contains(auth()->id()) ? 'red' : 'none' }}"
                                                                class="like-icon">
                                                                <path
                                                                    d="M1.49316 8.36806V8.37826C1.49315 8.93568 1.49313 9.73662 1.84578 10.7287C2.19955 11.724 2.88929 12.8643 4.19656 14.1716C6.21425 16.1893 8.4235 17.8017 9.25996 18.3886C9.70594 18.7014 10.2954 18.7014 10.7413 18.3884C11.5776 17.8014 13.7861 16.1892 15.8037 14.1716C17.1109 12.8643 17.8007 11.724 18.1544 10.7287C18.5071 9.73663 18.5071 8.93568 18.507 8.37826V8.36806C18.507 5.81629 16.7611 3.61111 14.0626 3.61111C12.8017 3.61111 11.826 4.20271 11.1026 4.94974C10.6558 5.41125 10.293 5.94345 10.0001 6.46148C9.70728 5.94345 9.34445 5.41125 8.89758 4.94974C8.17424 4.20271 7.19856 3.61111 5.93761 3.61111C3.23911 3.61111 1.49316 5.81629 1.49316 8.36806Z"
                                                                    stroke="#7c4d28" stroke-width="1.38889" />
                                                            </svg>
                                                            <span
                                                                class="like-count text-post">{{ $post->likes->count() }}</span>
                                                        </div>
                                                    </button>
                                                    @if (!$post->group || ($post->group && $post->group->members->contains(auth()->id())))
                                                        <button
                                                            class="btn btn-link text-decoration-none p-0 comment-toggle"
                                                            data-post-id="{{ $post->id }}">
                                                            <div class="d-flex gap-2 align-items-center">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                    height="20" viewBox="0 0 20 20" fill="none">
                                                                    <path
                                                                        d="M17.0844 14.6863L18.0957 18.6617L14.1229 17.6498C14.0868 17.6498 14.0146 17.6498 13.9784 17.6498C12.6421 18.4087 11.053 18.7701 9.3555 18.6617C5.49104 18.3726 2.3128 15.2646 1.91552 11.3976C1.40988 6.26577 5.70774 1.96514 10.8363 2.4711C14.7008 2.86863 17.8068 6.01279 18.0957 9.91588C18.2401 11.6144 17.8429 13.2046 17.0844 14.5418C17.0844 14.614 17.0844 14.6502 17.0844 14.6863Z"
                                                                        stroke="#7c4d28" stroke-width="1.38889"
                                                                        stroke-linejoin="round" />
                                                                </svg>
                                                                <span
                                                                    class="text-post">{{ count($post->comments) }}</span>
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="17" viewBox="0 0 16 17" fill="none">
                                                            <path
                                                                d="M15 10.8334V13.9445C15 14.357 14.8361 14.7527 14.5444 15.0444C14.2527 15.3362 13.857 15.5 13.4444 15.5H2.55556C2.143 15.5 1.74733 15.3362 1.45561 15.0444C1.16389 14.7527 1 14.357 1 13.9445V10.8334"
                                                                stroke="#7c4d28" stroke-width="1.51095"
                                                                stroke-linecap="round" stroke-linejoin="round" />
                                                            <path d="M11.8901 5.38889L8.00119 1.5L4.1123 5.38889"
                                                                stroke="#7c4d28" stroke-width="1.51095"
                                                                stroke-linecap="round" stroke-linejoin="round" />
                                                            <path d="M8 1.5V10.8333" stroke="#7c4d28"
                                                                stroke-width="1.51095" stroke-linecap="round"
                                                                stroke-linejoin="round" />
                                                        </svg>
                                                        <span class="text-post">Chia sẻ</span>
                                                    </div>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="#"
                                                            onclick="copyPostLink({{ $post->id }})">
                                                            <i class="fas fa-link me-2"></i> Sao chép đường dẫn
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#"
                                                            onclick="sharePostAsImage(this, {{ $post->id }})">
                                                            <i class="fas fa-image me-2"></i> Sao chép dạng hình
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#"
                                                            onclick="downloadPostAsImage(this, {{ $post->id }})">
                                                            <i class="fa-solid fa-download me-2"></i> Tải về dạng hình
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#"
                                                            onclick="sharePost({{ $post->id }}, 'link')">
                                                            <i class="fa-solid fa-share me-2"></i> Chia sẻ đường dẫn qua...
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#"
                                                            onclick="sharePost({{ $post->id }}, 'image')">
                                                            <i class="fa-solid fa-share-nodes me-2"></i> Chia sẻ dạng hình
                                                            qua...
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
                                            @if (!Auth::check())
                                                <div class="alert alert-info mt-3">
                                                    <i class="fas fa-info-circle me-2"></i>
                                                    Bạn cần đăng nhập để bình luận
                                                </div>
                                            @endif
                                        @else
                                            <div class="alert alert-info mt-3">
                                                <i class="fas fa-info-circle me-2"></i>
                                                Bạn cần tham gia nhóm để bình luận bài viết này
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endforeach

                        @if (!$hasViewablePosts)
                            <div class="shadow-sm text-center py-5 border rounded-3">
                                <i class="fas fa-newspaper fa-3x mb-3"></i>
                                <h3 class="h4">Không có bài viết</h3>
                                @if (auth()->check())
                                    <p class="text-white-50">Hãy tham gia các nhóm để xem bài viết hoặc tạo bài viết mới!
                                    </p>
                                @else
                                    <p>Vui lòng đăng nhập để xem và tương tác với bài viết!</p>
                                @endif
                            </div>
                        @endif

                        <!-- Load More Button -->
                        @if ($hasViewablePosts)
                            <div class="text-center mt-4">
                                <button class="btn btn-primary load-more-posts" style="display: none;">
                                    <i class="fas fa-spinner fa-spin me-2"></i>
                                    Tải thêm bài viết
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- Button trigger modal -->
        @if (Auth::check())
            <div class="create-post-btn mx-5" data-bs-toggle="modal" data-bs-target="#postModal">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M10 2V18M18 10H2" stroke="white" stroke-width="3" stroke-linecap="round" />
                </svg>
            </div>
        @endif
        <!-- Modal -->
        <div class="modal fade" id="postModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('communities.store') }}" method="POST" enctype="multipart/form-data"
                        id="postForm">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <textarea name="description" id="postDescription" rows="3" class="form-control"
                                    placeholder="Bạn viết gì đi..." autocomplete="off"></textarea>
                                <div class="invalid-feedback" id="descriptionError">Vui lòng nhập nội dung bài viết</div>
                            </div>
                            <div class="mb-3">
                                <label for="images" class="form-label">Thêm ảnh</label>
                                <input type="file" class="form-control" id="postImages" name="images[]" multiple
                                    accept="image/*">
                                <div class="form-text">Bạn có thể chọn nhiều ảnh cùng lúc</div>
                                <div class="invalid-feedback" id="imagesError"></div>
                            </div>
                            <div class="mb-3">
                                <label for="group_id" class="form-label">Chọn nhóm</label>
                                <select name="group_id" class="form-control" id="groupSelect">
                                    <option value="">Chọn nhóm</option>
                                    @foreach ($groups as $group)
                                        @if ($group->members->contains(auth()->id()))
                                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <div class="invalid-feedback" id="groupError">Vui lòng chọn nhóm</div>
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
                        </div>
                        <div class="modal-footer">
                            <div class="d-flex justify-content-between align-items-center">
                                <button type="submit" class="btn btn-primary" id="submitBtn">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    Đăng
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
@endsection
<style>
    /* Container cha bao quanh .swiper */
    .swiper-container {
        position: relative;
        width: 80%;
        max-width: 800px;
        /* Tăng max-width để hiển thị nhiều slide hơn */
        margin: 0 auto;
    }

    /* Container của Swiper */
    .swiper {
        width: 100%;
        padding: 10px 20px;
        margin-bottom: 20px;
        position: relative;
        overflow: hidden;
    }

    /* Wrapper chứa các slide */
    .swiper-wrapper {
        display: flex;
        transition: transform 0.3s ease;
    }

    /* Slide */
    .swiper-slide {
        width: 120px !important;
        display: flex;
        justify-content: center;
        transition: opacity 0.3s ease;
        margin-right: 10px !important;
    }

    /* Gradient mờ dần */
    .swiper::after {
        content: '';
        position: absolute;
        right: 0;
        top: 0;
        height: 100%;
        width: 60px;
        /* Giảm width của gradient để không che nội dung */
        /* background: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 1)); */
        pointer-events: none;
        z-index: 1;
    }

    /* Nút prev/next */
    .custom-nav {
        width: 32px;
        height: 32px;
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 50%;
        color: #495057;
        display: flex !important;
        justify-content: center;
        align-items: center;
        position: absolute;
        top: 60%;
        transform: translateY(-50%);
        z-index: 2;
        transition: all 0.3s ease;
    }

    .custom-nav:hover {
        background: #f8f9fa;
        color: #212529;
    }

    .swiper-button-prev {
        left: -40px;
        opacity: 1 !important;
    }

    .swiper-button-next {
        right: -40px;
        opacity: 1 !important;
    }

    .swiper-button-prev::after {
        content: '\2039';
        font-size: 14px;
        font-weight: bold;
    }

    .swiper-button-next::after {
        content: '\203A';
        font-size: 14px;
        font-weight: bold;
    }

    .swiper-button-disabled {
        opacity: 0.5 !important;
        pointer-events: none;
    }

    /* Category item */
    .category-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 5px;
    }

    /* Category name */
    .category-name {
        font-size: 0.9rem;
        color: #495057;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 150px;
        text-align: center;
        padding: 8px 16px;
        border-radius: 20px;
        transition: all 0.2s ease;
    }

    a:hover .category-name {
        background: #e9ecef;
        color: #212529;
    }

    /* Responsive với các breakpoint */
    @media (max-width: 240px) {
        .swiper-container {
            width: 95%;
        }

        .swiper {
            padding: 10px 10px;
        }

        .swiper-slide {
            width: 90px !important;
            margin-right: 8px !important;
        }

        .category-name {
            font-size: 0.7rem;
            max-width: 70px;
            padding: 6px 10px;
        }

        .swiper::after {
            width: 30px;
            right: 0;
        }

        .swiper-button-prev {
            left: -20px;
        }

        .swiper-button-next {
            right: -20px;
        }
    }

    @media (max-width: 320px) {
        .swiper-container {
            width: 90%;
        }

        .swiper {
            padding: 10px 15px;
        }

        .swiper-slide {
            width: 100px !important;
            margin-right: 8px !important;
        }

        .category-name {
            font-size: 0.7rem;
            max-width: 80px;
            padding: 6px 10px;
        }

        .swiper::after {
            width: 40px;
            right: 0;
        }

        .swiper-button-prev {
            left: -25px;
        }

        .swiper-button-next {
            right: -25px;
        }
    }

    @media (max-width: 480px) {
        .swiper-container {
            width: 90%;
        }

        .swiper {
            padding: 10px 15px;
        }

        .swiper-slide {
            width: 100px !important;
            margin-right: 8px !important;
        }

        .category-name {
            font-size: 0.8rem;
            max-width: 80px;
            padding: 6px 12px;
        }

        .swiper::after {
            width: 50px;
            right: 0;
        }

        .swiper-button-prev {
            left: -30px;
        }

        .swiper-button-next {
            right: -30px;
        }
    }

    @media (max-width: 768px) {
        .swiper-container {
            width: 90%;
        }

        .swiper {
            padding: 10px 20px;
        }

        .swiper-slide {
            width: 100px !important;
            margin-right: 8px !important;
        }

        .category-name {
            font-size: 0.8rem;
            max-width: 80px;
            padding: 6px 12px;
        }

        .swiper::after {
            width: 60px;
            right: 0;
        }

        .swiper-button-prev {
            left: -30px;
        }

        .swiper-button-next {
            right: -30px;
        }
    }

    @media (min-width: 1024px) {
        .swiper-container {
            width: 80%;
            max-width: 1000px;
            /* Tăng max-width để hiển thị nhiều slide */
        }

        .swiper {
            padding: 10px 20px;
        }

        .swiper-slide {
            width: 120px !important;
            margin-right: 10px !important;
        }

        .category-name {
            font-size: 0.9rem;
            max-width: 150px;
            padding: 8px 16px;
        }

        .swiper::after {
            width: 80px;
            right: 0;
        }

        .swiper-button-prev {
            left: -40px;
        }

        .swiper-button-next {
            right: -40px;
        }
    }

    @media (min-width: 1440px) {
        .swiper-container {
            width: 80%;
            max-width: 1200px;
        }

        .swiper {
            padding: 10px 20px;
        }

        .swiper-slide {
            width: 120px !important;
            margin-right: 30px !important;
        }

        .category-name {
            font-size: 1rem;
            max-width: 160px;
            padding: 8px 16px;
        }

        .swiper::after {
            width: 100px;
            right: 0;
        }

        .swiper-button-prev {
            left: -50px;
        }

        .swiper-button-next {
            right: -50px;
        }
    }

    /* Style cho nút tạo nhóm mới */
    .category-name.create-group {
        background: #e7f1ff;
        color: #0d6efd;
        border: 2px dashed #0d6efd;
        font-weight: 500;
    }

    .category-name.create-group:hover {
        background: #0d6efd;
        color: white;
        border-style: solid;
    }

    /* Share button styles */
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

    /* Like button styles */
    .like-btn {
        transition: transform 0.2s ease;
    }

    .like-btn:hover {
        transform: scale(1.1);
    }

    .like-icon {
        transition: all 0.3s ease;
    }

    .like-animation {
        animation: likeEffect 0.3s ease;
    }

    @keyframes likeEffect {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.3);
        }

        100% {
            transform: scale(1);
        }
    }

    .processing {
        pointer-events: none;
        opacity: 0.7;
    }
</style>

<script>
    // Validation form tạo bài viết
    document.addEventListener('DOMContentLoaded', function() {
        const postForm = document.getElementById('postForm');

        if (postForm) {
            postForm.addEventListener('submit', function(e) {
                const description = document.getElementById('postDescription').value.trim();
                const groupSelect = document.getElementById('groupSelect');
                const images = document.getElementById('postImages').files;
                let isValid = true;

                // Reset validation states
                document.getElementById('postDescription').classList.remove('is-invalid');
                groupSelect.classList.remove('is-invalid');

                // Kiểm tra đã nhập nội dung hoặc thêm ảnh chưa
                if (description === '' && images.length === 0) {
                    document.getElementById('postDescription').classList.add('is-invalid');
                    document.getElementById('descriptionError').textContent =
                        'Vui lòng nhập nội dung hoặc thêm ảnh cho bài viết';
                    isValid = false;
                }

                // Kiểm tra đã chọn nhóm chưa
                if (groupSelect.value === '') {
                    groupSelect.classList.add('is-invalid');
                    document.getElementById('groupError').textContent = 'Vui lòng chọn nhóm';
                    isValid = false;
                }

                if (!isValid) {
                    e.preventDefault();
                    return false;
                }
            });
        }
    });
</script>

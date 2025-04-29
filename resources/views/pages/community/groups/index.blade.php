@extends('layouts.main')

@section('content')
    <x-community.community-js name="congdong" />
    <x-sidebar-nav></x-sidebar-nav>
    <div class="main-content">
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
                            <div class="mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36"
                                    fill="none">
                                    <path
                                        d="M21.2963 21.6593C22.4552 21.6593 23.3957 22.6171 23.3957 23.7972L23.3945 24.9723C23.5349 27.6477 21.5818 29 18.0774 29C14.5863 29 12.5984 27.6684 12.5984 25.0188V23.7972C12.5984 22.6171 13.539 21.6593 14.6979 21.6593H21.2963ZM21.2963 23.4918H14.6979C14.6183 23.4918 14.542 23.5239 14.4858 23.5812C14.4295 23.6385 14.3979 23.7162 14.3979 23.7972V25.0188C14.3979 26.4554 15.4621 27.1676 18.0774 27.1676C20.6784 27.1676 21.6706 26.4786 21.5962 25.0212V23.7972C21.5962 23.7162 21.5646 23.6385 21.5083 23.5812C21.4521 23.5239 21.3758 23.4918 21.2963 23.4918ZM8.09949 15.5513H13.3494C13.1982 16.1493 13.1596 16.771 13.2354 17.3837H8.09949C8.01994 17.3837 7.94365 17.4159 7.88741 17.4731C7.83116 17.5304 7.79956 17.6081 7.79956 17.6891V18.9107C7.79956 20.3473 8.8637 21.0595 11.4791 21.0595C12.0333 21.0595 12.5144 21.0278 12.9271 20.9655C12.2407 21.4083 11.7394 22.0941 11.5198 22.8907L11.4791 22.8919C7.98791 22.8919 6 21.5604 6 18.9107V17.6891C6 16.509 6.94057 15.5513 8.09949 15.5513ZM27.8946 15.5513C29.0536 15.5513 29.9941 16.509 29.9941 17.6891L29.9929 18.8643C30.1333 21.5396 28.1802 22.8919 24.6758 22.8919L24.4731 22.8895C24.2469 22.0711 23.7248 21.3701 23.0118 20.9276C23.4761 21.0155 24.028 21.0595 24.6758 21.0595C27.2768 21.0595 28.2689 20.3705 28.1946 18.9132V17.6891C28.1946 17.6081 28.163 17.5304 28.1067 17.4731C28.0505 17.4159 27.9742 17.3837 27.8946 17.3837H22.7599C22.8341 16.7709 22.7951 16.1494 22.6447 15.5513H27.8946ZM17.9971 13.1081C18.4697 13.1081 18.9377 13.2029 19.3744 13.387C19.811 13.5712 20.2078 13.8411 20.542 14.1815C20.8762 14.5218 21.1413 14.9258 21.3222 15.3704C21.5031 15.8151 21.5962 16.2916 21.5962 16.7729C21.5962 17.2542 21.5031 17.7307 21.3222 18.1754C21.1413 18.62 20.8762 19.024 20.542 19.3643C20.2078 19.7046 19.811 19.9746 19.3744 20.1588C18.9377 20.3429 18.4697 20.4377 17.9971 20.4377C17.0425 20.4377 16.1271 20.0516 15.4521 19.3643C14.7771 18.677 14.3979 17.7449 14.3979 16.7729C14.3979 15.8009 14.7771 14.8688 15.4521 14.1815C16.1271 13.4942 17.0425 13.1081 17.9971 13.1081ZM17.9971 14.9405C17.7607 14.9405 17.5267 14.9879 17.3084 15.08C17.0901 15.172 16.8917 15.307 16.7246 15.4772C16.5575 15.6473 16.4249 15.8493 16.3345 16.0717C16.244 16.294 16.1975 16.5323 16.1975 16.7729C16.1975 17.0135 16.244 17.2518 16.3345 17.4741C16.4249 17.6964 16.5575 17.8984 16.7246 18.0686C16.8917 18.2388 17.0901 18.3737 17.3084 18.4658C17.5267 18.5579 17.7607 18.6053 17.9971 18.6053C18.4743 18.6053 18.9321 18.4123 19.2695 18.0686C19.607 17.725 19.7966 17.2589 19.7966 16.7729C19.7966 16.2869 19.607 15.8208 19.2695 15.4772C18.9321 15.1335 18.4743 14.9405 17.9971 14.9405ZM11.3987 7C12.3532 7 13.2687 7.38612 13.9436 8.07341C14.6186 8.76069 14.9978 9.69286 14.9978 10.6648C14.9978 11.6368 14.6186 12.569 13.9436 13.2563C13.2687 13.9436 12.3532 14.3297 11.3987 14.3297C10.4441 14.3297 9.52868 13.9436 8.85372 13.2563C8.17875 12.569 7.79956 11.6368 7.79956 10.6648C7.79956 9.69286 8.17875 8.76069 8.85372 8.07341C9.52868 7.38612 10.4441 7 11.3987 7ZM24.5954 7C25.55 7 26.4654 7.38612 27.1404 8.07341C27.8154 8.76069 28.1946 9.69286 28.1946 10.6648C28.1946 11.6368 27.8154 12.569 27.1404 13.2563C26.4654 13.9436 25.55 14.3297 24.5954 14.3297C23.6409 14.3297 22.7254 13.9436 22.0505 13.2563C21.3755 12.569 20.9963 11.6368 20.9963 10.6648C20.9963 9.69286 21.3755 8.76069 22.0505 8.07341C22.7254 7.38612 23.6409 7 24.5954 7ZM11.3987 8.83242C10.9214 8.83242 10.4637 9.02547 10.1262 9.36912C9.78871 9.71276 9.59912 10.1788 9.59912 10.6648C9.59912 11.1508 9.78871 11.6169 10.1262 11.9605C10.4637 12.3042 10.9214 12.4973 11.3987 12.4973C11.8759 12.4973 12.3337 12.3042 12.6712 11.9605C13.0086 11.6169 13.1982 11.1508 13.1982 10.6648C13.1982 10.1788 13.0086 9.71276 12.6712 9.36912C12.3337 9.02547 11.8759 8.83242 11.3987 8.83242ZM24.5954 8.83242C24.1182 8.83242 23.6604 9.02547 23.323 9.36912C22.9855 9.71276 22.7959 10.1788 22.7959 10.6648C22.7959 11.1508 22.9855 11.6169 23.323 11.9605C23.6604 12.3042 24.1182 12.4973 24.5954 12.4973C25.0727 12.4973 25.5304 12.3042 25.8679 11.9605C26.2054 11.6169 26.395 11.1508 26.395 10.6648C26.395 10.1788 26.2054 9.71276 25.8679 9.36912C25.5304 9.02547 25.0727 8.83242 24.5954 8.83242Z"
                                        fill="white" />
                                </svg>
                            </div>
                            @foreach ($groups as $group)
                                <div class="swiper-slide">
                                    <a href="{{ route('groupss.show', $group) }}" class="text-decoration-none">
                                        <div class="category-item text-center">
                                            <div class="category-name text-white">{{ $group->name }}</div>
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
                                <div class="p-4 rounded-5 border shadow-sm mb-4 bg-blur post-card-bg"
                                    data-post-id="{{ $post->id }}">
                                    <div class="card-body">
                                        @if ($post->group)
                                            <a href="{{ route('groupss.show', $post->group) }}"
                                                class="text-decoration-none">
                                                <p class="m-0 p-0 text-center border-bottom pb-3 text-white">
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
                                            <div class="post-content mb-3 text-white cursor-pointer description-post"
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
                                                        <button
                                                            class="btn btn-link text-decoration-none p-0 comment-toggle"
                                                            data-post-id="{{ $post->id }}">
                                                            <div class="d-flex gap-2 align-items-center">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                    height="20" viewBox="0 0 20 20" fill="none">
                                                                    <path
                                                                        d="M17.0844 14.6863L18.0957 18.6617L14.1229 17.6498C14.0868 17.6498 14.0146 17.6498 13.9784 17.6498C12.6421 18.4087 11.053 18.7701 9.3555 18.6617C5.49104 18.3726 2.3128 15.2646 1.91552 11.3976C1.40988 6.26577 5.70774 1.96514 10.8363 2.4711C14.7008 2.86863 17.8068 6.01279 18.0957 9.91588C18.2401 11.6144 17.8429 13.2046 17.0844 14.5418C17.0844 14.614 17.0844 14.6502 17.0844 14.6863Z"
                                                                        stroke="white" stroke-width="1.38889"
                                                                        stroke-linejoin="round" />
                                                                </svg>
                                                                <span
                                                                    class="text-white">{{ count($post->comments) }}</span>
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
                                                                stroke="white" stroke-width="1.51095"
                                                                stroke-linecap="round" stroke-linejoin="round" />
                                                            <path d="M11.8901 5.38889L8.00119 1.5L4.1123 5.38889"
                                                                stroke="white" stroke-width="1.51095"
                                                                stroke-linecap="round" stroke-linejoin="round" />
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
                                                            <i class="fa-solid fa-share-nodes me-2"></i> Chia sẻ dạng hình qua...
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
                                <i class="fas fa-newspaper fa-3x text-white mb-3"></i>
                                <h3 class="h4 text-white">Không có bài viết</h3>
                                @if (auth()->check())
                                    <p class="text-white-50">Hãy tham gia các nhóm để xem bài viết hoặc tạo bài viết mới!
                                    </p>
                                @else
                                    <p class="text-white-50">Vui lòng đăng nhập để xem và tương tác với bài viết!</p>
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
    body {
        background-image: url('{{ asset('image/default/Window.png') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    .post-card-bg {
        background-image: url('{{ asset('image/default/Window.png') }}');
        background-size: cover;
        background-position: center;
    }

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

    /* Toast styles */
    .toast {
        background-color: rgba(0, 0, 0, 0.8) !important;
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

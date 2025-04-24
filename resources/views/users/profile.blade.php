@extends('layouts.main')
@section('content')
    <style>
        .search-bar {
            display: none;
        }

        .footer {
            display: none;
        }

        /* Style for the dropdown chevron icon */
        .dropdown-header i {
            transition: transform 0.3s ease;
        }

        .dropdown-header.active i {
            transform: rotate(180deg);
        }

        .main-content {
            padding-top: 80px;
        }
    </style>

    <div x-data="{}">
        <div class="flex">
            <!-- Sidebar -->
            <div class="w-1/6 bg-white border-r min-h-screen p-4 sidebar">
                <div x-data="{ isOpen: true }" class="dropdown">
                    <h3 class="font-bold mb-4 dropdown-header" x-on:click="isOpen = !isOpen">
                        Không gian sở hữu
                        <i class="fa fa-chevron-down" :class="{ 'active': isOpen }"></i>
                    </h3>
                    <ul class="space-y-2" x-show="isOpen" x-transition>
                        <li class="flex items-center space-x-2">
                            <span class="text-gray-600">
                                <i class="fa fa-building"></i>
                            </span>
                            <span>Meliá Hồ Tràm Beach Resort</span>
                        </li>
                        <li class="flex justify-center items-center space-x-2">
                            <span class="text-gray-600">
                                <i class="fa fa-building"></i>
                            </span>
                            <span>Fleur De Lys Resort & Spa Long Hải</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <span class="text-gray-600">
                                <i class="fa fa-building"></i>
                            </span>
                            <span>Gia Minh Bistro - Food And Beverage</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main profile -->
            <div class="w-full main-profile">
                <div class="flex items-center justify-center space-x-8 profile-header">
                    <img src="/api/placeholder/150/150" class="w-28 h-28 rounded-full border-4 border-blue-400 object-cover"
                        alt="Avatar" />
                    <div>
                        <div class="flex items-center space-x-2">
                            <h2 class="text-2xl font-bold">{{ $user->name }}</h2>
                            <span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded text-xs font-semibold">Người đóng góp
                                nổi bật</span>
                        </div>
                        <div class="text-gray-600 mt-1">Du lịch - Ẩm thực - Văn hoá</div>
                        <div class="flex space-x-6 mt-3 stats">
                            <span><b>120</b> bài viết</span>
                            <span><b>7000</b> người theo dõi</span>
                        </div>
                    </div>
                </div>

                <div x-data="{ tab: 'posts' }" class="tabs">
                    <div class="mt-8 border-b">
                        <nav class="flex justify-center space-x-8">
                            <a href="#" @click.prevent="tab = 'posts'"
                                :class="tab === 'posts' ? 'border-blue-500 text-blue-600 border-b-2 font-semibold' :
                                    'text-gray-500 hover:text-blue-500 hover:border-blue-300'"
                                class="pb-2 transition-colors duration-150">Bài viết</a>
                            <a href="#" @click.prevent="tab = 'trusted'"
                                :class="tab === 'trusted' ? 'border-blue-500 text-blue-600 border-b-2 font-semibold' :
                                    'text-gray-500 hover:text-blue-500 hover:border-blue-300'"
                                class="pb-2 transition-colors duration-150">Danh sách tin cậy</a>
                            <a href="#" @click.prevent="tab = 'reviews'"
                                :class="tab === 'reviews' ? 'border-blue-500 text-blue-600 border-b-2 font-semibold' :
                                    'text-gray-500 hover:text-blue-500 hover:border-blue-300'"
                                class="pb-2 transition-colors duration-150">Bài đánh giá</a>
                        </nav>
                    </div>

                    <div class="mt-8 space-y-8 w-full container">
                        <div x-show="tab === 'posts'">
                            <!-- Post 1 -->
                            <div class="bg-white rounded-lg p-4 transition-all duration-200 post mb-6">
                                <div class="flex items-center space-x-3 mb-2 post-header">
                                    <img src="/api/placeholder/50/50"
                                        class="w-8 h-8 rounded-full border-2 border-blue-300 object-cover shadow"
                                        alt="Avatar" />
                                    <span class="font-semibold">Việt Nguyễn</span>
                                    <span class="text-xs text-gray-400">1 giờ trước</span>
                                </div>
                                <div class="post-content">
                                    <span>Check in <a href="#"
                                            class="text-blue-600 underline hover:text-blue-800 transition">Meliá Hồ Tràm
                                            Beach Resort</a></span>
                                    <div class="grid grid-cols-2 gap-2 mt-2 post-images">
                                        <img src="/api/placeholder/400/300" class="rounded-lg object-cover w-full h-32"
                                            alt="Food" />
                                        <img src="/api/placeholder/400/300" class="rounded-lg object-cover w-full h-32"
                                            alt="Resort" />
                                    </div>
                                    <div class="mt-2 text-gray-700">Kỳ nghỉ tuyệt vời tại Meliá Hồ Tràm Beach Resort!</div>
                                    <div class="flex items-center space-x-4 mt-2 text-gray-500 post-footer">
                                        <span><i class="fa fa-heart text-red-500"></i> 250</span>
                                        <span><i class="fa fa-comment"></i> 25</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Post 2 -->
                            <div class="bg-white rounded-lg p-4 transition-all duration-200 post">
                                <div class="flex items-center space-x-3 mb-2 post-header">
                                    <img src="/api/placeholder/50/50"
                                        class="w-8 h-8 rounded-full border-2 border-blue-300 object-cover shadow"
                                        alt="Avatar" />
                                    <span class="font-semibold">Việt Nguyễn</span>
                                    <span class="text-xs text-gray-400">3 giờ trước</span>
                                </div>
                                <div class="post-content">
                                    <span>Check in <a href="#"
                                            class="text-blue-600 underline hover:text-blue-800 transition">Gia Minh Bistro -
                                            Food And Beverage</a></span>
                                    <div class="mt-1 text-gray-700">Một trải nghiệm đáng nhớ cùng gia đình.</div>
                                    <div class="grid grid-cols-2 gap-2 mt-2 post-images">
                                        <img src="/api/placeholder/400/300" class="rounded-lg object-cover w-full h-32"
                                            alt="Food" />
                                        <img src="/api/placeholder/400/300" class="rounded-lg object-cover w-full h-32"
                                            alt="Resort" />
                                    </div>
                                    <div class="flex items-center space-x-4 mt-2 text-gray-500 post-footer">
                                        <span><i class="fa fa-heart text-red-500"></i> 250</span>
                                        <span><i class="fa fa-comment"></i> 25</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div x-show="tab === 'trusted'" class="py-8">
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($user->trustlists as $post)
                                <div class="bg-white rounded-lg shadow-md overflow-hidden transition-all duration-200">
                                    <div class="listing-image-container">
                                        <div class="image-carousel">
                                            <div class="carousel-images">
                                                @foreach ($post->post->images as $image)
                                                <img src="{{ asset($image->image_path) }}" class="img-fluid rounded" alt="Post image">
                                                @endforeach
                                            </div>
                                            <button class="carousel-nav prev" onclick="event.preventDefault(); prevImage(this);">
                                                <i class="fas fa-chevron-left"></i>
                                            </button>
                                            <button class="carousel-nav next" onclick="event.preventDefault(); nextImage(this);">
                                                <i class="fas fa-chevron-right"></i>
                                            </button>
                                            <div class="carousel-dots">
                                                @for($i = 0; $i < count($post->post->images); $i++)
                                                    <span class="dot {{ $i === 0 ? 'active' : '' }}"></span>
                                                    @endfor
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-4">
                                        <div class="flex items-center justify-between mb-2">
                                            <a href="{{ $post->post->type == 2 ? route('dining.detail-dining', ['id' => $post->post_id]) : route('detail', ['id' => $post->post_id]) }}"
                                                class="text-lg font-semibold text-gray-800 hover:text-blue-600 transition">
                                                {{ $post->post->title }}
                                            </a>
                                            <div class="flex items-center space-x-1">
                                                <i class="fa fa-heart text-red-500"></i>
                                                <span class="text-gray-600">4.93</span>
                                            </div>
                                        </div>
                                        <div class="text-gray-600 text-sm">{{ $post->post->address }}</div>
                                        <div class="flex items-center space-x-3 mt-2 text-gray-500 text-sm">
                                            <span class="flex items-center space-x-1">
                                                <i class="fa fa-heart text-red-500"></i>
                                                <span>{{ $post->post->saves_count }}</span>
                                            </span>
                                            <span class="flex items-center space-x-1">
                                                <i class="fa fa-comment"></i>
                                                <span>{{ $post->post->comments_count }}</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div x-show="tab === 'reviews'" class="py-8">
                            <div class="text-gray-500 text-center">Chưa có bài đánh giá nào.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/carousel.js') }}"></script>
@endsection

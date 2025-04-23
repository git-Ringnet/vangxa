<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vangxa - Khám phá ẩm thực và du lịch Việt Nam</title>
    <meta name="description" content="Vangxa - Nền tảng kết nối những địa điểm ẩm thực và du lịch độc đáo tại Việt Nam. Khám phá những trải nghiệm ẩm thực địa phương và điểm đến du lịch hấp dẫn.">
    <meta property="og:title" content="Vangxa - Khám phá ẩm thực và du lịch Việt Nam">
    <meta property="og:description" content="Kết nối với những địa điểm ẩm thực và du lịch độc đáo tại Việt Nam">
    <meta property="og:image" content="https://vangxa.com/images/hero-banner.jpg">
    <meta property="og:url" content="https://vangxa.com">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4a90e2;
            --secondary-color: #50c878;
            --accent-color: #ff6b6b;
            --text-color: #2c3e50;
            --light-bg: #f8f9fa;
        }

        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)),
                url('https://images.unsplash.com/photo-1552566626-52f8b828add9?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80') center/cover no-repeat;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(74, 144, 226, 0.1), rgba(80, 200, 120, 0.1));
            animation: gradientAnimation 8s ease infinite;
        }

        .feature-card {
            transition: all 0.3s ease;
            transform: translateY(0);
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .story-book {
            position: relative;
            perspective: 1000px;
            cursor: pointer;
        }

        .story-book:hover .book-cover {
            transform: rotateY(-30deg);
        }

        .book-cover {
            transition: transform 0.6s ease;
            transform-style: preserve-3d;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 1000;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .modal.active {
            display: flex;
            opacity: 1;
        }

        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 12px;
            max-width: 600px;
            width: 90%;
            margin: auto;
            position: relative;
            transform: scale(0.9);
            transition: transform 0.3s ease;
        }

        .modal.active .modal-content {
            transform: scale(1);
        }

        .close-modal {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 24px;
            cursor: pointer;
            color: var(--text-color);
        }

        .text-gradient {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: gradientText 3s ease infinite;
        }

        .btn-primary {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 30px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        @keyframes gradientAnimation {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        @keyframes gradientText {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .floating {
            animation: floating 3s ease-in-out infinite;
        }

        .pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        .fade-in {
            animation: fadeIn 1s ease-in;
        }

        @keyframes floating {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.8;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .scroll-indicator {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            animation: bounce 2s infinite;
        }

        @keyframes bounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-30px);
            }

            60% {
                transform: translateY(-15px);
            }
        }

        .hover-scale {
            transition: transform 0.3s ease;
        }

        .hover-scale:hover {
            transform: scale(1.05);
        }

        .footer {
            background-color: #f7f7f7;
            padding: 48px 0;
            border-top: 1px solid #dddddd;
        }

        .container-custom {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 40px;
            margin-bottom: 48px;
        }

        .footer-section h3 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 16px;
            color: #222222;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: #222222;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.2s;
        }

        .footer-links a:hover {
            color: #ff385c;
        }

        .footer-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 24px;
            border-top: 1px solid #dddddd;
        }

        .footer-legal {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #222222;
        }

        .footer-legal a {
            color: #222222;
            text-decoration: none;
        }

        .footer-legal a:hover {
            text-decoration: underline;
        }

        .footer-locale {
            display: flex;
            align-items: center;
            gap: 24px;
        }

        .language-selector,
        .currency-selector {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #222222;
            cursor: pointer;
        }

        .social-links {
            display: flex;
            gap: 16px;
        }

        .social-links a {
            color: #222222;
            font-size: 18px;
            transition: color 0.2s;
        }

        .social-links a:hover {
            color: #ff385c;
        }

        .feature-card {
            transition: all 0.3s ease;
            transform: translateY(0);
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: 2px solid transparent;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border-color: var(--primary-color);
        }

        .feature-card i {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: iconPulse 2s ease-in-out infinite;
        }

        .feature-card h3 {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: textGradient 3s ease infinite;
        }
       
    </style>
</head>

<body class="font-sans">
    <!-- Hero Section -->
    <section class="hero-section min-h-screen flex items-center justify-center text-white">
        <div class="container mx-auto px-4 text-center relative z-10">
            <h1 class="text-5xl md:text-7xl font-bold mb-6 fade-in text-gradient">Khám phá ẩm thực & du lịch Việt Nam</h1>
            <p class="text-xl md:text-2xl mb-8 fade-in" data-aos="fade-up" data-aos-delay="200">Kết nối với những địa điểm ẩm thực và du lịch độc đáo dành cho những người tử tế!</p>
            <a href="#waitlist" class="btn-primary hover-scale pulse" data-aos="fade-up" data-aos-delay="400">
                Tham gia danh sách chờ
            </a>
        </div>
        <div class="scroll-indicator">
            <i class="fas fa-chevron-down text-white text-2xl"></i>
        </div>
    </section>

    <!-- Story Section -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="text-4xl font-bold mb-6 text-gradient" data-aos="fade-up">Câu chuyện của chúng tôi</h2>
                <p class="text-xl text-gray-600 mb-8" data-aos="fade-up" data-aos-delay="200">
                    Vangxa ra đời từ niềm đam mê với ẩm thực và văn hóa Việt Nam. Chúng tôi mong muốn kết nối những người yêu ẩm thực với những địa điểm độc đáo, mang đến trải nghiệm chân thực nhất về ẩm thực Việt Nam.
                </p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12">
                    <a href="{{ route('lodging') }}" class="p-6 bg-white rounded-lg shadow-lg feature-card hover:no-underline" data-aos="fade-up" data-aos-delay="400">
                        <i class="fas fa-map-marked-alt text-4xl text-primary mb-4 floating"></i>
                        <h3 class="text-xl font-bold mb-2 text-primary">Nơi du lịch</h3>
                        <p class="text-gray-600">Tìm kiếm những địa điểm du lịch đặc sắc</p>
                    </a>
                    <a href="{{ route('dining') }}" class="p-6 bg-white rounded-lg shadow-lg feature-card hover:no-underline" data-aos="fade-up" data-aos-delay="300">
                        <i class="fas fa-utensils text-4xl text-primary mb-4 floating"></i>
                        <h3 class="text-xl font-bold mb-2 text-primary">Ẩm thực địa phương</h3>
                        <p class="text-gray-600">Khám phá những món ăn truyền thống và hiện đại</p>
                    </a>

                    <a href="{{ route('groupss.index') }}" class="p-6 bg-white rounded-lg shadow-lg feature-card hover:no-underline" data-aos="fade-up" data-aos-delay="300">
                        <i class="fas fa-utensils text-4xl text-primary mb-4 floating"></i>
                        <h3 class="text-xl font-bold mb-2 text-primary">Cộng đồng yêu ẩm thực</h3>
                        <p class="text-gray-600">Kết nối với những người cùng đam mê</p>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Stories Section -->
    <section class="py-20">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center mb-12 text-gradient" data-aos="fade-up">Địa điểm nổi bật & Câu chuyện đặc sắc</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Story 1 -->
                <div class="story-book" data-aos="fade-up" data-aos-delay="200" onclick="openModal('story1')">
                    <div class="book-cover">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1552566626-52f8b828add9?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Nhà hàng Hương Việt" class="w-full h-48 object-cover rounded-t-lg">
                            <div class="absolute -bottom-8 left-1/2 transform -translate-x-1/2">
                                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80" alt="Chủ nhà hàng" class="w-16 h-16 rounded-full border-4 border-white object-cover">
                            </div>
                        </div>
                        <div class="pt-8 text-center">
                            <h3 class="text-xl font-bold text-primary">Nhà hàng Hương Việt</h3>
                            <p class="text-gray-600 mt-2">Ẩm thực miền Bắc truyền thống</p>
                            <div class="flex items-center justify-center mt-2 text-yellow-500">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span class="text-gray-600 ml-2">4.5</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Story 2 -->
                <div class="story-book" data-aos="fade-up" data-aos-delay="300" onclick="openModal('story2')">
                    <div class="book-cover">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Quán ăn Sài Gòn" class="w-full h-48 object-cover rounded-t-lg">
                            <div class="absolute -bottom-8 left-1/2 transform -translate-x-1/2">
                                <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80" alt="Chủ quán" class="w-16 h-16 rounded-full border-4 border-white object-cover">
                            </div>
                        </div>
                        <div class="pt-8 text-center">
                            <h3 class="text-xl font-bold text-primary">Quán ăn Sài Gòn</h3>
                            <p class="text-gray-600 mt-2">Hương vị miền Nam đặc trưng</p>
                            <div class="flex items-center justify-center mt-2 text-yellow-500">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                                <span class="text-gray-600 ml-2">4.0</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Story 3 -->
                <div class="story-book" data-aos="fade-up" data-aos-delay="400" onclick="openModal('story3')">
                    <div class="book-cover">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Quán cà phê Hội An" class="w-full h-48 object-cover rounded-t-lg">
                            <div class="absolute -bottom-8 left-1/2 transform -translate-x-1/2">
                                <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80" alt="Chủ quán" class="w-16 h-16 rounded-full border-4 border-white object-cover">
                            </div>
                        </div>
                        <div class="pt-8 text-center">
                            <h3 class="text-xl font-bold text-primary">Quán cà phê Hội An</h3>
                            <p class="text-gray-600 mt-2">Không gian cổ điển</p>
                            <div class="flex items-center justify-center mt-2 text-yellow-500">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span class="text-gray-600 ml-2">5.0</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="story-book" data-aos="fade-up" data-aos-delay="200" onclick="openModal('story1')">
                    <div class="book-cover">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1552566626-52f8b828add9?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Nhà hàng Hương Việt" class="w-full h-48 object-cover rounded-t-lg">
                            <div class="absolute -bottom-8 left-1/2 transform -translate-x-1/2">
                                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80" alt="Chủ nhà hàng" class="w-16 h-16 rounded-full border-4 border-white object-cover">
                            </div>
                        </div>
                        <div class="pt-8 text-center">
                            <h3 class="text-xl font-bold text-primary">Nhà hàng Hương Việt</h3>
                            <p class="text-gray-600 mt-2">Ẩm thực miền Bắc truyền thống</p>
                            <div class="flex items-center justify-center mt-2 text-yellow-500">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span class="text-gray-600 ml-2">4.5</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Story 2 -->
                <div class="story-book" data-aos="fade-up" data-aos-delay="300" onclick="openModal('story2')">
                    <div class="book-cover">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Quán ăn Sài Gòn" class="w-full h-48 object-cover rounded-t-lg">
                            <div class="absolute -bottom-8 left-1/2 transform -translate-x-1/2">
                                <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80" alt="Chủ quán" class="w-16 h-16 rounded-full border-4 border-white object-cover">
                            </div>
                        </div>
                        <div class="pt-8 text-center">
                            <h3 class="text-xl font-bold text-primary">Quán ăn Sài Gòn</h3>
                            <p class="text-gray-600 mt-2">Hương vị miền Nam đặc trưng</p>
                            <div class="flex items-center justify-center mt-2 text-yellow-500">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                                <span class="text-gray-600 ml-2">4.0</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Story 3 -->
                <div class="story-book" data-aos="fade-up" data-aos-delay="400" onclick="openModal('story3')">
                    <div class="book-cover">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Quán cà phê Hội An" class="w-full h-48 object-cover rounded-t-lg">
                            <div class="absolute -bottom-8 left-1/2 transform -translate-x-1/2">
                                <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80" alt="Chủ quán" class="w-16 h-16 rounded-full border-4 border-white object-cover">
                            </div>
                        </div>
                        <div class="pt-8 text-center">
                            <h3 class="text-xl font-bold text-primary">Quán cà phê Hội An</h3>
                            <p class="text-gray-600 mt-2">Không gian cổ điển</p>
                            <div class="flex items-center justify-center mt-2 text-yellow-500">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span class="text-gray-600 ml-2">5.0</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Story Modals -->
    <div id="story1" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal('story1')">&times;</span>
            <div class="flex items-center mb-6">
                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80" alt="Chủ nhà hàng" class="w-20 h-20 rounded-full object-cover mr-4">
                <div>
                    <h2 class="text-2xl font-bold text-primary">Nhà hàng Hương Việt</h2>
                    <p class="text-gray-600">Chủ nhà hàng: Nguyễn Văn An</p>
                </div>
            </div>
            <img src="https://images.unsplash.com/photo-1552566626-52f8b828add9?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Nhà hàng Hương Việt" class="w-full h-64 object-cover rounded-lg mb-4">
            <p class="text-gray-600 mb-4">
                "Tôi bắt đầu với một quán phở nhỏ ở Hà Nội vào năm 1995. Sau nhiều năm nỗ lực, tôi đã mang hương vị ẩm thực miền Bắc đến với Sài Gòn. Điều tôi tự hào nhất là giữ được hương vị truyền thống trong mỗi món ăn."
            </p>
            <p class="text-gray-600">
                Đặc biệt, nhà hàng nổi tiếng với món phở bò truyền thống, được chế biến từ công thức gia truyền với nước dùng được ninh từ xương bò trong 12 tiếng, tạo nên hương vị đậm đà khó quên.
            </p>
        </div>
    </div>

    <div id="story2" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal('story2')">&times;</span>
            <div class="flex items-center mb-6">
                <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80" alt="Chủ quán" class="w-20 h-20 rounded-full object-cover mr-4">
                <div>
                    <h2 class="text-2xl font-bold text-primary">Quán ăn Sài Gòn</h2>
                    <p class="text-gray-600">Chủ quán: Trần Thị Bình</p>
                </div>
            </div>
            <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Quán ăn Sài Gòn" class="w-full h-64 object-cover rounded-lg mb-4">
            <p class="text-gray-600 mb-4">
                "Tôi đã tiếp quản quán ăn từ cha mẹ tôi vào năm 2000. Mỗi ngày, tôi đều cố gắng giữ gìn hương vị đặc trưng của ẩm thực miền Nam, đồng thời sáng tạo thêm những món mới để phục vụ thực khách."
            </p>
            <p class="text-gray-600">
                Điểm đặc biệt của quán là không gian ấm cúng, thân thiện và menu đa dạng với nhiều món ăn truyền thống như bún mắm, hủ tiếu Nam Vang, và các món ăn vặt đặc trưng của Sài Gòn.
            </p>
        </div>
    </div>

    <div id="story3" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal('story3')">&times;</span>
            <div class="flex items-center mb-6">
                <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80" alt="Chủ quán" class="w-20 h-20 rounded-full object-cover mr-4">
                <div>
                    <h2 class="text-2xl font-bold text-primary">Quán cà phê Hội An</h2>
                    <p class="text-gray-600">Chủ quán: Lê Văn Minh</p>
                </div>
            </div>
            <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Quán cà phê Hội An" class="w-full h-64 object-cover rounded-lg mb-4">
            <p class="text-gray-600 mb-4">
                "Tôi đã dành cả đời để nghiên cứu và phát triển nghệ thuật pha cà phê. Quán cà phê này không chỉ là nơi kinh doanh mà còn là nơi tôi chia sẻ niềm đam mê với cà phê Việt Nam."
            </p>
            <p class="text-gray-600">
                Điểm đặc biệt của quán là phương pháp pha cà phê truyền thống, sử dụng phin pha cà phê bằng gốm và nước sôi được đun trên bếp than. Mỗi tách cà phê ở đây đều mang hương vị đặc trưng của cà phê Việt Nam.
            </p>
        </div>
    </div>

    <!-- CTA Section -->
    <section id="waitlist" class="py-20 bg-gradient-to-r from-primary to-secondary text-white relative overflow-hidden">
        <div class="container mx-auto px-4 text-center relative z-10">
            <h2 class="text-4xl font-bold mb-6  bg-gradient-to-r from-primary to-secondary text-transparent bg-clip-text" data-aos="fade-up">Tham gia cùng chúng tôi</h2>
            <p class="text-xl mb-8 bg-gradient-to-r from-primary to-secondary text-transparent bg-clip-text" data-aos="fade-up" data-aos-delay="200">Đăng ký để nhận thông tin về những địa điểm ẩm thực mới và ưu đãi đặc biệt</p>
            <form class="max-w-md mx-auto" data-aos="fade-up" data-aos-delay="400">
                <div class="flex flex-col md:flex-row gap-4">
                    <input type="email" placeholder="Email của bạn" class="flex-grow px-4 py-3 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-white">
                    <button type="submit" class="btn-primary">
                        Đăng ký
                    </button>
                </div>
            </form>
        </div>
    </section>

    @include('components.footer')

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100
        });

        function openModal(modalId) {
            document.getElementById(modalId).classList.add('active');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('active');
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.classList.remove('active');
            }
        }
    </script>
</body>

</html>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8"> <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<title>VANGXA – Khám phá Việt Nam qua ẩm thực và du lịch</title> 
<meta name="description" content="Đặt tour du lịch Việt Nam, khám phá ẩm thực địa phương. Cộng đồng chia sẻ kinh nghiệm du lịch và ẩm thực Việt Nam. Đặt khách sạn, nhà nghỉ, homestay với giá tốt nhất." /> 
<meta name="keywords" content="du lịch Việt Nam, ẩm thực Việt Nam, đặt tour du lịch, đặt khách sạn, nhà nghỉ, homestay, kinh nghiệm du lịch, ẩm thực địa phương, cộng đồng du lịch, khám phá Việt Nam" /> 
<meta name="robots" content="index, follow" /> 
<meta name="author" content="VANGXA" /> 
<meta name="language" content="vi" /> 
<meta name="copyright" content="VANGXA 2025" /> 
<!-- Open Graph / Facebook --> 
 <meta property="og:type" content="website" /> 
 <meta property="og:url" content="https://vangxa.vn" /> 
 <meta property="og:title" content="VANGXA – Khám phá Việt Nam qua ẩm thực và du lịch" /> 
 <meta property="og:description" content="Đặt tour du lịch Việt Nam, khám phá ẩm thực địa phương. Cộng đồng chia sẻ kinh nghiệm du lịch và ẩm thực Việt Nam. Đặt khách sạn, nhà nghỉ, homestay với giá tốt nhất." /> 
 <meta property="og:image" content="https://vangxa.vn/image/og-image.jpg" /> 
 <!-- Twitter --> 
  <meta property="twitter:card" content="summary_large_image" /> 
  <meta property="twitter:url" content="https://vangxa.vn" /> 
  <meta property="twitter:title" content="VANGXA – Khám phá Việt Nam qua ẩm thực và du lịch" /> 
  <meta property="twitter:description" content="Đặt tour du lịch Việt Nam, khám phá ẩm thực địa phương. Cộng đồng chia sẻ kinh nghiệm du lịch và ẩm thực Việt Nam. Đặt khách sạn, nhà nghỉ, homestay với giá tốt nhất." /> 
  <meta property="twitter:image" content="https://vangxa.vn/image/og-image.jpg" />
  
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Dancing+Script:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Thêm GSAP và ScrollTrigger -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <style>
        body {
            font-family: 'Playfair Display', serif;
            overflow-x: hidden;
            background-color: #2c1c0f;
            position: relative;
            transition: background-color 1s ease;
            margin: 0;
            padding: 0;
            color: #f8f8f8;
            background-image: 
                radial-gradient(ellipse at center, rgba(231, 142, 90, 0.9) 0%, rgba(229, 139, 42, 0.95) 70%, rgba(2, 66, 4, 0.98) 100%);
            background-attachment: fixed;
            background-blend-mode: soft-light;
        }
        
        /* Chế độ hiệu suất - giảm hiệu ứng khi tab ẩn hoặc FPS thấp */
        body.performance-mode .particles,
        body.performance-mode .firefly,
        body.performance-mode .light-rays,
        body.performance-mode .mystical-light {
            opacity: 0.3 !important;
            animation-play-state: paused;
        }
        
        /* Tạo các lớp để chuyển đổi theme nhanh hơn thay vì tính toán gradient phức tạp */
        body.theme-intro {
            background-color: #2c1c0f;
            background-image: 
                radial-gradient(ellipse at center, rgba(200, 97, 37, 0.9) 0%, rgba(97, 53, 6, 0.95) 70%, rgba(20, 12, 6, 0.98) 100%);
        }
        
        body.theme-part1 {
            background-color: #2d1d07;
            background-image: 
                radial-gradient(ellipse at center, rgba(42, 21, 10, 0.9) 0%, rgba(18, 10, 5, 0.95) 70%, rgba(20, 12, 6, 0.98) 100%);
        }
        
        body.theme-part2 {
            background-color: #3d2815;
            background-image: 
                radial-gradient(ellipse at center, rgba(77, 50, 25, 0.9) 0%, rgba(60, 38, 17, 0.95) 70%, rgba(30, 15, 6, 0.98) 100%);
        }
        
        body.theme-part3 {
            background-color: #6a3c0a;
            background-image: 
                radial-gradient(ellipse at center, rgba(130, 61, 1, 0.9) 0%, rgba(109, 58, 4, 0.85) 70%, rgba(150, 55, 6, 0.9) 100%);
        }
        
        h1, h2, h3 {
            font-family: 'Dancing Script', cursive;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.6);
        }
        
        p {
            font-family: 'Playfair Display', serif;
            font-weight: 400;
            letter-spacing: 0.015em;
            text-shadow: 0 1px 4px rgba(0, 0, 0, 0.4);
        }
        
        em, .subscript {
            font-family: 'Dancing Script', cursive;
            font-size: 1.2em;
        }
        
        .gradient-text {
            background: linear-gradient(45deg, #ff8f00 0%, #ffb74d 50%, #ffcc80 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            color: transparent;
            text-shadow: 0px 2px 4px rgba(0,0,0,0.2);
            z-index: 10;
        }
        
        section {
            position: relative;
            padding: 8vh 0;
            min-height: 100vh;
        }
        
        .content-container {
            width: 100%;
            max-width: 900px;
            margin: 0 auto;
            padding: 0 1rem;
            z-index: 10;
            position: relative;
            animation: oldFilmShake 20s infinite;
        }
        
        .content-container p {
            line-height: 1.85;
            margin-bottom: 1rem;
            color: #fff8e6;
            font-size: 1.1rem;
            text-shadow: 0 1px 3px rgba(0,0,0,0.3);
        }
        
        .content-container h1,
        .content-container h2,
        .content-container h3 {
            margin-bottom: 1.2rem;
            color: #ffffff;
        }
        
        #canvas-container {
            display: none; /* Không cần Three.js nữa */
        }
        
        main {
            margin-left: 0;
            width: 100%;
            position: relative;
            z-index: 10;
            left: 300px;
        }
        
        #boat-container {
            position: fixed;
            top: 50%;
            left: 20%;
            transform: translate(-50%, -50%);
            width: 20%;
            height: 50%;
            z-index: 100;
            perspective: 1000px;
        }
        
        #boat-image {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            max-width: 100%;
            animation: floatBoat 5s ease-in-out infinite;
            filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.4));
            z-index: 2;
        }
        
      
        
        .wave-1, .wave-2 {
            position: absolute;
            width: 360px;
            height: 180px;
            left: -90px;
            background: url('data:image/svg+xml;utf8,<svg viewBox="0 0 400 200" xmlns="http://www.w3.org/2000/svg"><path d="M0,150 C100,50 300,150 400,100 V200 H0 Z" fill="%231a4780" fill-opacity="0.4"/></svg>') repeat-x;
            background-size: 360px 180px;
            animation: wave-move 6s linear infinite;
            will-change: transform;
        }
        
        .wave-2 {
            top: 15px;
            animation-delay: -2s;
            opacity: 0.6;
            animation-duration: 7s;
        }
        
        .wave-3 {
            display: none; /* Ẩn sóng thứ 3 để tối ưu */
        }
        
        .foam {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 15px;
            background: linear-gradient(180deg, rgba(255,255,255,0.3) 0%, transparent 100%);
            opacity: 0.5;
        }
        
        @keyframes wave-move {
            0% { transform: translateX(0); }
            100% { transform: translateX(360px); }
        }
        
        @keyframes floatBoat {
            0% { transform: translate(-50%, -50%) rotate(0deg); }
            25% { transform: translate(-50%, -52%) rotate(1deg); }
            50% { transform: translate(-50%, -50%) rotate(0deg); }
            75% { transform: translate(-50%, -48%) rotate(-1deg); }
            100% { transform: translate(-50%, -50%) rotate(0deg); }
        }
        
        #loading {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #0a192f;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            color: white;
            font-size: 24px;
        }
        
        .loader {
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top: 4px solid white;
            width: 40px;
            height: 40px;
            margin-right: 15px;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .aurora {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            opacity: 0;
            pointer-events: none;
            background: 
                linear-gradient(0deg, transparent 0%, rgba(65, 105, 225, 0.2) 20%, transparent 100%),
                linear-gradient(90deg, transparent 0%, rgba(138, 43, 226, 0.2) 50%, transparent 100%);
            filter: blur(40px);
            animation: aurora 15s infinite alternate;
            transition: opacity 2s ease;
        }
        
        @keyframes aurora {
            0% { transform: translateY(-20px) translateX(-30px); opacity: 0.3; }
            50% { opacity: 0.4; }
            100% { transform: translateY(20px) translateX(30px); opacity: 0.3; }
        }
        
        .celestial {
            position: fixed;
            top: 15%;
            left: 10%;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            z-index: 0;
            transition: all 2s ease;
        }
        
        .sun {
            background-color: #ffdb58;
            box-shadow: 0 0 50px 10px rgba(255, 219, 88, 0.7);
        }
        
        .moon {
            background-color: rgba(255, 255, 255, 0.8);
            box-shadow: 0 0 50px 10px rgba(255, 255, 255, 0.5);
            opacity: 0;
        }
        
        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            background-image: radial-gradient(circle, rgba(255,255,255,0.8) 1px, transparent 1px);
            background-size: 20px 20px;
            animation: particlesMove 5s linear infinite;
            opacity: 0.3;
            z-index: 0;
        }
        
        @keyframes particlesMove {
            0% { background-position: 0 0; }
            100% { background-position: 100px 100px; }
        }
        
        header {
            background-color: rgba(10, 25, 47, 0.8);
            transition: transform 0.3s ease, background-color 0.3s ease, box-shadow 0.3s ease;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 50;
        }
        
        header.scrolled {
            background-color: rgba(10, 25, 47, 0.95);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        
        header.header-hidden {
            transform: translateY(-100%);
        }
        
        .header-nav-link {
            position: relative;
            padding: 0.5rem 0;
        }
        
        .header-nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background: linear-gradient(45deg, #f97316 0%, #8b5cf6 50%, #ec4899 100%);
            transition: width 0.3s ease;
        }
        
        .header-nav-link:hover::after,
        .header-nav-link.active::after {
            width: 100%;
        }
        
        header.intro-section {
            background-color: rgba(10, 25, 47, 0.8);
        }
        
        header.part1-section {
            background-color: rgba(10, 25, 47, 0.8);
        }
        
        header.part2-section {
            background-color: rgba(10, 25, 47, 0.8);
            background-image: none;
        }
        
        header.part3-section {
            background-color: rgba(10, 25, 47, 0.8);
            background-image: none;
        }
        
        .animate-text {
            opacity: 0;
            transform: translateY(30px);
        }
        
        .animate-title {
            opacity: 0;
            transform: translateY(50px);
        }
        
        .animate-stagger {
            opacity: 0;
            transform: translateY(20px);
        }

        /* Hamburger menu styles */
        .hamburger {
            display: none;
            flex-direction: column;
            justify-content: space-between;
            width: 24px;
            height: 18px;
            cursor: pointer;
        }
        
        .hamburger span {
            width: 100%;
            height: 3px;
            background-color: white;
            transition: all 0.3s ease;
        }
        
        .hamburger.active span:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }
        
        .hamburger.active span:nth-child(2) {
            opacity: 0;
        }
        
        .hamburger.active span:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -7px);
        }
        
        .mobile-menu {
            display: none;
            position: fixed;
            top: 70px;
            left: 0;
            width: 100%;
            background-color: rgba(10, 25, 47, 0.95);
            padding: 1rem;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
            z-index: 40;
        }
        
        .mobile-menu.active {
            display: flex;
        }

        /* Footer styles */
        footer {
            background-color: rgba(10, 25, 47, 0.95);
            color: white;
            padding: 2rem 1rem;
            text-align: center;
        }
        
        footer .content-container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        footer h3 {
            font-size: 1.8rem;
            margin-bottom: 0.8rem;
        }
        
        footer p {
            font-size: 0.9rem;
            color: #cbd5e1;
        }
        
        footer .social-links {
            display: flex;
            justify-content: center;
            gap: 1.2rem;
            margin: 1.2rem 0;
        }
        
        footer .social-links a {
            color: #cbd5e1;
            font-size: 1.3rem;
            transition: color 0.3s ease;
        }
        
        footer .social-links a:hover {
            color: #a855f7;
        }

        /* Responsive styles */
        @media screen and (max-width: 1024px) {
            #canvas-container {
                display: none;
            }
            
            main {
                margin-left: 0;
                width: 100%;
                margin-top: 0;
                z-index: 10;
                position: relative;
            }
            
            #boat-container {
                position: fixed !important;
                top: 40% !important;
                left: 50% !important;
                width: 100%;
                height: 50vh;
                z-index: 5;
            }
            
            /* #intro {
                margin-top: -60vh;
            } */
            
            section {
                position: relative;
                z-index: 10;
            }
            
            #boat-image {
                max-width: 120%;
                transform: translate(-50%, -50%) scale(1.3);
            }
            
            .content-container h1,
            .content-container h2,
            .content-container h3 {
                text-align: center;
            }
            
            .content-container h1 {
                font-size: 4rem;
            }
            
            .content-container h2 {
                font-size: 3.5rem;
            }
            
            .content-container h3 {
                font-size: 2rem;
            }
            
            .content-container p {
                font-size: 1rem;
            }
            
            .celestial {
                width: 60px;
                height: 60px;
            }
            
            .wave-1, .wave-2 {
                width: 360px;
                height: 180px;
                background-size: 360px 180px;
            }

            /* Header responsive styles for tablets */
            header .container {
                padding: 0.8rem 1.5rem;
            }

            header nav {
                gap: 1.5rem;
            }

            .header-nav-link {
                font-size: 0.95rem;
            }

            .dropdown-trigger {
                padding: 6px 10px;
            }
        }

        @media screen and (max-width: 768px) {
            header .container {
                padding: 0.6rem 1rem;
            }
main{
    left: 0;
}
            header nav {
                display: none;
            }

            .hamburger {
                display: flex;
            }

            .mobile-menu {
                top: 60px;
                padding: 1rem 0;
                background-color: rgba(10, 25, 47, 0.98);
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            }

            .mobile-menu a {
                font-size: 1rem;
                padding: 0.8rem 1.5rem;
                width: 100%;
                text-align: center;
                transition: all 0.3s ease;
            }

            .mobile-menu a:hover {
                background-color: rgba(255, 255, 255, 0.1);
            }

            .mobile-menu .dropdown {
                width: 100%;
            }

            .mobile-menu .dropdown-trigger {
                width: 100%;
                justify-content: center;
                padding: 0.8rem 1.5rem;
            }

            .mobile-menu .dropdown-content {
                position: static;
                width: 100%;
                background-color: rgba(17, 24, 39, 0.95);
                box-shadow: none;
                border-radius: 0;
                transform: none;
                opacity: 1;
                display: none;
            }

            .mobile-menu .dropdown-content.active {
                display: block;
            }

            .mobile-menu .dropdown-content a {
                padding: 0.8rem 2rem;
                border-left: none;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            }

            .header-icons {
                margin-right: 15px;
            }

            .dropdown-trigger {
                padding: 6px 8px;
            }

            .dropdown-trigger i {
                font-size: 14px;
            }

            .dropdown-content {
                min-width: 160px;
            }

            .dropdown-content a {
                padding: 10px 14px;
                font-size: 0.9rem;
            }
            #boat-image{
                opacity: 0.3;
            }
        }

        @media screen and (max-width: 430px) {
            header .container {
                padding: 0.5rem 0.8rem;
            }

            .text-2xl {
                font-size: 1.5rem;
            }

            .header-icons {
                margin-right: 10px;
            }

            .dropdown-trigger {
                padding: 5px 6px;
            }

            .dropdown-trigger i {
                font-size: 12px;
            }

            .mobile-menu {
                top: 50px;
            }

            .mobile-menu a {
                font-size: 0.9rem;
                padding: 0.7rem 1rem;
            }

            .mobile-menu .dropdown-trigger {
                padding: 0.7rem 1rem;
            }

            .mobile-menu .dropdown-content a {
                padding: 0.7rem 1.5rem;
                font-size: 0.85rem;
            }

            .dropdown-content {
                min-width: 140px;
            }

            .dropdown-content a {
                padding: 8px 12px;
                font-size: 0.85rem;
            }
        }
        .vangxa-highlight {
            font-weight: 700;
            background: linear-gradient(45deg, #ff8f00 0%, #ffb74d 50%, #ffcc80 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            color: transparent;
            text-shadow: 0px 1px 2px rgba(0,0,0,0.2);
            padding: 0 2px;
        }

        /* Dropdown menu styles - Thiết lập kiểu dropdown menu */
        .dropdown {
            position: relative;
            display: inline-flex;
            align-items: center;
            cursor: pointer;
        }
        
        .dropdown-content {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background-color: rgba(17, 24, 39, 0.95);
            min-width: 180px;
            box-shadow: 0px 8px 24px rgba(0,0,0,0.3);
            z-index: 60;
            border-radius: 8px;
            overflow: hidden;
            transform: translateY(10px);
            opacity: 0;
            transition: transform 0.3s ease, opacity 0.3s ease;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            will-change: transform, opacity;
        }
        
        .dropdown-content.active {
            display: block;
            transform: translateY(0);
            opacity: 1;
        }
        
        .dropdown-content a {
            color: white;
            padding: 12px 16px;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }
        
        .dropdown-content a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        .dropdown-content a:hover {
            background-color: rgba(99, 102, 241, 0.2);
            border-left: 3px solid #6366f1;
        }
        
        .dropdown-content a.active {
            background-color: rgba(99, 102, 241, 0.1);
            border-left: 3px solid #6366f1;
        }
        
        .dropdown-trigger {
            color: white;
            display: flex;
            align-items: center;
            padding: 8px 12px;
            border-radius: 6px;
            transition: all 0.3s ease;
            background-color: rgba(255, 255, 255, 0.05);
        }
        
        .dropdown-trigger:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .dropdown-trigger i.fa-chevron-down {
            transition: transform 0.3s ease;
        }
        
        .dropdown.open .dropdown-trigger i.fa-chevron-down {
            transform: rotate(180deg);
        }
        
        .dropdown-trigger i {
            margin-right: 6px;
            font-size: 16px;
        }
        
        .header-icons {
            display: flex;
            align-items: center;
            margin-left: 20px;
            gap: 16px;
        }
        
       
        /* Fog effect - Vô hiệu hóa / Giảm hiệu ứng sương mù */
        .fog-container {
            display: none; /* Vô hiệu hóa sương mù để tăng hiệu suất */
        }
        
        /* Floating lanterns - Vô hiệu hóa / Giảm hiệu ứng đèn lồng */
        .floating-lanterns {
            display: none; /* Vô hiệu hóa đèn lồng để tăng hiệu suất */
        }
        
        /* Light rays */
        .light-rays {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(ellipse at 30% 40%, rgba(255, 210, 120, 0), rgba(255, 200, 120, 0.15) 20%, rgba(255, 178, 107, 0) 60%);
            opacity: 0;
            transition: opacity 2s ease;
            pointer-events: none;
            z-index: 2;
        }
        
        .light-rays.active {
            opacity: 0.7;
        }
        
        /* Mystical light */
        .mystical-light {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(ellipse at 70% 40%, rgba(209, 187, 151, 0), rgba(209, 187, 151, 0.2) 20%, rgba(209, 187, 151, 0) 60%);
            opacity: 0;
            transition: opacity 2s ease;
            pointer-events: none;
            z-index: 2;
        }
        
        .mystical-light.active {
            opacity: 0.8;
        }
        
        /* Border effect */
        .border-effect {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            box-shadow: inset 0 0 250px 80px rgba(10, 6, 2, 0.95);
            pointer-events: none;
            z-index: 3;
        }
        
        /* Vignette effect for vintage feel */
        .vignette {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(ellipse at center, transparent 35%, rgba(10, 6, 2, 0.7) 100%);
            pointer-events: none;
            z-index: 3;
            opacity: 0.8;
        }
        
        /* Fireflies effect */
        .fireflies-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 2;
            pointer-events: none;
            overflow: hidden;
        }
        
        .firefly {
            position: absolute;
            width: 6px;
            height: 6px;
            background-color: rgba(255, 230, 150, 0.95);
            border-radius: 50%;
            box-shadow: 0 0 15px 5px rgba(255, 230, 150, 0.6);
            animation: firefly-float 15s linear infinite;
            opacity: 0;
        }
        
        @keyframes firefly-float {
            0% { opacity: 0; transform: translateY(0) translateX(0); }
            10% { opacity: 0.8; transform: translateY(-10px) translateX(10px); }
            30% { opacity: 0.3; transform: translateY(-30px) translateX(-15px); }
            50% { opacity: 0.9; transform: translateY(-50px) translateX(5px); }
            70% { opacity: 0.5; transform: translateY(-70px) translateX(-10px); }
            90% { opacity: 0.8; transform: translateY(-90px) translateX(15px); }
            100% { opacity: 0; transform: translateY(-100px) translateX(0); }
        }
        
        /* Hiệu ứng rung nhẹ cho hình ảnh kiểu phim cũ */
        @keyframes oldFilmShake {
            0% { transform: translateX(0) translateY(0); }
            25% { transform: translateX(-0.5px) translateY(0.5px); }
            50% { transform: translateX(0.5px) translateY(-0.5px); }
            75% { transform: translateX(-0.5px) translateY(-0.5px); }
            100% { transform: translateX(0) translateY(0); }
        }
        
        /* Cải thiện hiệu ứng cho các phần tử xuất hiện khi scroll bằng CSS thuần */
        .animate-text,
        .animate-title,
        .animate-stagger {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }
        
        .animate-text.visible,
        .animate-title.visible,
        .animate-stagger.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Thời gian transition khác nhau cho các loại phần tử */
        .animate-title {
            transition-duration: 1s;
        }
        
        .animate-text {
            transition-duration: 0.8s;
        }
        
        /* Hiệu ứng xuất hiện tuần tự đơn giản */
        section .animate-stagger:nth-child(1) { transition-delay: 0s; }
        section .animate-stagger:nth-child(2) { transition-delay: 0s; }
        section .animate-stagger:nth-child(3) { transition-delay: 0s; }
        section .animate-stagger:nth-child(4) { transition-delay: 0s; }
        section .animate-stagger:nth-child(5) { transition-delay: 0s; }
        section .animate-stagger:nth-child(6) { transition-delay: 0s; }
        section .animate-stagger:nth-child(7) { transition-delay: 0s; }
        section .animate-stagger:nth-child(8) { transition-delay: 0s; }
        section .animate-stagger:nth-child(9) { transition-delay: 0s; }
        section .animate-stagger:nth-child(10) { transition-delay: 0s; }
        section .animate-stagger:nth-child(n+11) { transition-delay: 0s; }
        
        /* Smooth scroll behavior using native CSS */
        html {
            scroll-behavior: smooth;
        }
        
        /* Điều chỉnh cho hiệu ứng scroll đơn giản hơn */
        @media (prefers-reduced-motion: reduce) {
            html {
                scroll-behavior: auto;
            }
            
            .animate-text,
            .animate-title,
            .animate-stagger {
                transition: none !important;
                opacity: 1 !important;
                transform: none !important;
            }
        }
        
        /* Thêm CSS mới cho hiệu ứng scroll đơn giản */
        .animate-on-scroll {
            visibility: visible;
            transition: opacity 0.5s, transform 0.5s;
        }
        
        .not-scrolled {
            opacity: 0;
            transform: translateY(30px);
        }
        
        /* Hiệu ứng mặc định cho header khi scroll */
        header {
            transition: background-color 0.3s ease;
        }
        
        header.scrolled {
            background-color: rgba(10, 25, 47, 0.95);
        }
        
        /* Hiệu ứng float ngắn hơn cho thuyền */
        @keyframes floatBoat {
            0% { transform: translate(-50%, -50%) rotate(0deg); }
            25% { transform: translate(-50%, -52%) rotate(1deg); }
            50% { transform: translate(-50%, -50%) rotate(0deg); }
            75% { transform: translate(-50%, -48%) rotate(-1deg); }
            100% { transform: translate(-50%, -50%) rotate(0deg); }
        }
        
        /* Thiết lập keyframes animation cho hiệu ứng flash sáng */
        @keyframes flash-light {
            0% { opacity: 0.7; }
            50% { opacity: 0.9; }
            100% { opacity: 0.7; }
        }
        
        .light-rays.active,
        .mystical-light.active {
            animation: flash-light 5s infinite ease-in-out;
        }
        
        /* CSS thuần cho hiệu ứng chuyển đổi màu sắc */
        .gradient-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
            transition: background-color 1.5s ease;
        }
        
        /* Xóa các class và CSS liên quan đến hiệu ứng cũ */
        .fade-up {
            opacity: 0;
            /* Không cần transform ban đầu, GSAP sẽ xử lý */
        }
        
        /* Bỏ tất cả các class animate-text, animate-title, animate-stagger */
        
        /* Loại bỏ các CSS transition và animation trước đây */
        
        /* Bỏ hiệu ứng stagger cũ */
        
        /* Thêm style cho màn intro */
        #intro-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #000;
            z-index: 1000;
            display: flex;
            justify-content: center;
            align-items: center;
            pointer-events: none;
        }
        
        #intro-title {
            font-family: 'Dancing Script', cursive;
            font-size: 8vw;
            color: transparent;
            background: linear-gradient(45deg, #ff8f00 0%, #ffb74d 50%, #ffcc80 100%);
            -webkit-background-clip: text;
            background-clip: text;
            text-shadow: 0 2px 10px rgba(255, 143, 0, 0.3);
            opacity: 0;
            transform: scale(0.8);
        }
        
        .reveal-mask {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 900;
            background: radial-gradient(circle at center, transparent 0%, #000 80%);
            opacity: 0;
            pointer-events: none;
        }
        
        /* Thêm hiệu ứng lấp lánh cho các phần tử */
        .sparkle {
            position: absolute;
            background-color: white;
            border-radius: 50%;
            opacity: 0;
            pointer-events: none;
        }
        
        /* Ẩn nội dung ban đầu trước khi hiệu ứng chạy */
        body.loading-intro main,
        body.loading-intro header,
        body.loading-intro #boat-container {
            opacity: 0;
        }
        
        /* Thay đổi nhẹ màu của Vangxa để nổi bật hơn */
        .vangxa-highlight {
            position: relative;
            font-weight: 700;
            background: linear-gradient(45deg, #ff8f00 0%, #ffb74d 50%, #ffcc80 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            color: transparent;
            text-shadow: 0px 1px 2px rgba(0,0,0,0.2);
            padding: 0 2px;
        }
        
        .vangxa-highlight::after {
            content: '';
            position: absolute;
            width: 0;
            height: 100%;
            bottom: 0;
            left: 0;
            background: rgba(255, 143, 0, 0.2);
            z-index: -1;
            transition: width 0.5s ease;
        }
        
        .vangxa-highlight:hover::after {
            width: 100%;
        }
        
        /* Thêm hiệu ứng sáng chói khi hover boat */
        #boat-image {
            transition: filter 0.5s ease;
        }
        
        #boat-image:hover {
            filter: drop-shadow(0 5px 15px rgba(255, 180, 0, 0.8)) brightness(1.2);
        }

        /* Hiệu ứng sóng nước */
        .ripple-effect {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at center, transparent, #000 75%);
            z-index: 950;
            opacity: 0;
            transform: scale(0);
            pointer-events: none;
        }

    </style>
</head>
<body class="loading-intro">
    <div id="loading">
        <div class="loader"></div>
        <span>Đang tải trang...</span>
    </div>
    
    <!-- Thêm overlay intro animation -->
    <div id="intro-overlay">
        <h1 id="intro-title">Vangxa</h1>
    </div>
    <div class="reveal-mask"></div>
    
    <!-- Fog effect - Đã vô hiệu hóa -->
    <!-- <div class="fog-container">
        <div class="fog fog-1"></div>
        <div class="fog fog-2"></div>
    </div> -->
    
    <!-- Fireflies effect -->
    <div class="fireflies-container" id="firefliesContainer">
        <!-- Fireflies will be added dynamically by JS -->
    </div>
    
    <!-- Floating lanterns - Đã vô hiệu hóa -->
    <!-- <div class="floating-lanterns" id="floatingLanterns">
    </div> -->
    
    <!-- Light effects -->
    <div class="light-rays"></div>
    <div class="mystical-light"></div>
    
    <!-- Border effect -->
    <div class="border-effect"></div>
    <div class="vignette"></div>
    
    <header class="fixed top-0 left-0 w-full bg-opacity-80 backdrop-blur-md z-50 shadow-md transition-all duration-500">
        <div class="container mx-auto flex justify-between items-center p-4">
          
            <div class="text-2xl font-bold gradient-text">
                <a href="/" class="navbar-brand" style="display: flex; align-items: center; text-decoration: none;">
                    <img src="/image/ship.png" alt="Logo" width="50" height="52" />
                    <span style="margin-left: 8px; font-size: 26px;     font-weight: bold; color: #008cff; font-family: Verdana, sans-serif;">
                        Vangxa
                    </span>
                </a>
            </div>
            <div class="flex items-center">
            <nav class="hidden md:flex space-x-6">
                <a href="#intro" class="header-nav-link text-white hover:text-amber-300 transition-colors">Giới thiệu</a>
                <a href="#part1" class="header-nav-link text-white hover:text-amber-300 transition-colors">Phần I</a>
                <a href="#part2" class="header-nav-link text-white hover:text-amber-300 transition-colors">Phần II</a>
                <a href="#part3" class="header-nav-link text-white hover:text-amber-300 transition-colors">Phần III</a>
            </nav>
                <div class="header-icons">
                    <div class="dropdown" id="settingsDropdown">
                        <div class="dropdown-trigger">
                            <i class="fas fa-cog"></i>
                            <i class="fas fa-chevron-down" style="font-size: 0.75rem; margin-left: 4px;"></i>
                        </div>
                        <div class="dropdown-content">
                            <a href="#"><i class="fas fa-sign-in-alt"></i>Đăng nhập</a>
                            <a href="#"><i class="fas fa-user-cog"></i>Cài đặt</a>
                        </div>
                    </div>
                </div>
                <div class="hamburger md:hidden">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
        <div class="mobile-menu">
            <a href="#intro" class="header-nav-link text-white hover:text-amber-300 transition-colors">Giới thiệu</a>
            <a href="#part1" class="header-nav-link text-white hover:text-amber-300 transition-colors">Phần I</a>
            <a href="#part2" class="header-nav-link text-white hover:text-amber-300 transition-colors">Phần II</a>
            <a href="#part3" class="header-nav-link text-white hover:text-amber-300 transition-colors">Phần III</a>
            <div class="flex justify-center mt-4 space-x-6">
                <div class="dropdown" id="mobileSettingsDropdown">
                    <div class="dropdown-trigger">
                        <i class="fas fa-cog"></i> Cài đặt
                    </div>
                    <div class="dropdown-content">
                        <a href="#"><i class="fas fa-sign-in-alt"></i>Đăng nhập</a>
                        <a href="#"><i class="fas fa-user-cog"></i>Cài đặt</a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    
    <div id="boat-container">
        <img id="boat-image" src="/image/long den.png" alt="Thuyền buồm" />
    </div>
    
    <main class="relative text-white">
        <section id="intro" class="flex flex-col justify-center items-center text-center">
            <div class="content-container">
                <h1 class="text-8xl font-bold mb-8 gradient-text fade-up" style="line-height: 1.2;">Đây không phải là một bài giới thiệu.</h1>
                <p class="text-xl mb-4 fade-up">Cũng chẳng phải một kế hoạch bí mật.</p>
                <p class="text-xl mb-4 fade-up">Đây là một câu chuyện.</p>
                <p class="text-xl mb-4 fade-up">Một câu chuyện được kể qua ba phần — mở bài, thân bài, và kết luận.</p>
                <p class="text-xl mb-4 fade-up">Một câu chuyện giản dị, nhưng là câu chuyện hay — câu chuyện về một chuyến phiêu lưu</p>
                <p class="text-xl mb-4 fade-up">Và như mọi chuyến phiêu lưu vĩ đại, nhân vật chính là một người, một người rất đặc biệt.</p>
                <p class="text-3xl font-bold mb-24 fade-up" style="background: linear-gradient(45deg, #ff8f00 0%, #ffb74d 50%, #ffcc80 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Người đó chính là bạn.</p>
            </div>
        </section>
        
        <section id="part1" class="pt-24">
            <div class="content-container">
                <h3 class="text-3xl font-bold mb-4 gradient-text fade-up">Phần I</h3>
                <h2 class="text-8xl font-bold mb-4 gradient-text fade-up" style="line-height: 1.2;">Khi phép màu vụt tắt</h2>
                <p class="text-xl mb-4 fade-up">Ngày xưa, mỗi con hẻm, mỗi góc chợ đều là một câu chuyện sống động.</p>
                <p class="text-xl mb-4 fade-up">Bạn dễ dàng lạc vào một quán phở nhỏ ở Sài Gòn, nơi cụ bà với mái tóc bạc mỉm cười.</p>
                <p class="text-xl mb-4 fade-up">Một homestay giữa núi rừng Đà Lạt, nơi chú chủ nhà kể chuyện về những chuyến đi xa.</p>
                <p class="text-xl mb-4 fade-up">Không có bảng hiệu hoành tráng.</p>
                <p class="text-xl mb-4 fade-up">Không chạy quảng cáo.</p>
                <p class="text-xl mb-4 fade-up">Nhưng bạn vẫn tìm thấy nó –</p>
                <p class="text-xl mb-4 fade-up">ở cuối một con hẻm,</p>
                <p class="text-xl mb-4 fade-up">trên một góc phố vắng,</p>
                <p class="text-xl mb-4 fade-up">hay trong lời rỉ tai của một người từng ghé qua và vẫn nhớ mãi.</p>
                <p class="text-xl mb-4 fade-up">Một tô mì nóng với tiếng cười cô chủ.</p>
                <p class="text-xl mb-4 fade-up">Một chén chè được bà Sáu hỏi "con ăn nóng hay ăn đá? chè này ăn nóng mới ngon đó con".</p>
                <p class="text-xl mb-4 fade-up">Một phòng nghỉ nhỏ, sạch sẽ và có cây xanh ngoài cửa sổ.</p>
                <p class="text-xl mb-4 fade-up">Một cảm giác an toàn, gần gũi.</p>
                <p class="text-xl mb-8 fade-up">Bạn không chỉ ăn, không chỉ nghỉ ngơi—bạn cảm nhận.</p>
                <p class="text-xl mb-8 fade-up">Bạn cảm nhận được một mảnh ghép của linh hồn Việt.</p>
                <p class="text-xl mb-8 fade-up">Đó không chỉ là sản phẩm hay dịch vụ.</p>
                <p class="text-xl mb-8 fade-up">Đó là Việt Nam của phép màu—nơi mỗi món ăn, mỗi nơi dừng chân đều được dệt nên từ lòng tử tế, sự tận tâm và tình người.</p>
                <p class="text-xl mb-8 fade-up">Chúng ta nhìn lại những khoảnh khắc ấy với sự hoài niệm.</p>
                <p class="text-xl mb-8 fade-up">Nhưng phép màu ấy, đang dần phai nhạt.</p>
                <p class="text-xl mb-8 fade-up">Chuyện gì đã diễn ra?</p>
                <p class="text-xl mb-8 fade-up">Công nghệ – thứ từng được kỳ vọng gìn giữ kho báu ấy – nay trở thành con dao hai lưỡi.</p>
                <p class="text-xl mb-8 fade-up">Các mạng xã hội trở thành mê cung, nơi sự giả dối ẩn nấp sau những bài review bóng bẩy.</p>
                <p class="text-xl mb-8 fade-up">Quảng cáo rầm rộ che khuất ánh sáng của những người tử tế.</p>
                <p class="text-xl mb-8 fade-up">Còn các nghệ nhân – những người dành cả đời để chăm chút từng chiếc bánh, từng căn phòng - thì dần biến mất trong im lặng.</p>
                <p class="text-xl mb-8 fade-up">Hành trình khám phá Việt Nam giờ đây giống như băng qua một đầm lầy nhơ nhớp.</p>
                <p class="text-xl mb-8 fade-up">Bạn lạc lối giữa hàng trăm fanpage giả, những lời hứa hẹn suông và những kẻ lừa đảo chờ chực cướp đi niềm tin.</p>
                <p class="text-xl mb-16 fade-up">Nhưng trong cơn tuyệt vọng, một tia sáng lóe lên.</p>
            </div>
        </section>
        
        <section id="part2" class="pt-24">
            <div class="content-container">
                <h3 class="text-3xl font-bold mb-4 gradient-text fade-up">Phần II</h3>
                <h2 class="text-8xl font-bold mb-4 gradient-text fade-up" style="line-height: 1.2;">Ngọn lửa được nhóm lên</h2>
                <p class="text-xl mb-4 fade-up">Giữa màn sương hoài nghi và sự lặng im của những người tốt…</p>
                <p class="text-xl mb-8 fade-up">…một đốm lửa nhỏ được thắp lên. Không phải bởi một anh hùng vĩ đại.</p>
                <p class="text-xl mb-4 fade-up">Mà bởi kẻ "ngang bướng" không chịu để phép màu biến mất.</p>
                <p class="text-xl mb-4 fade-up">Là người từng bị lừa bởi một bài review giả.</p>
                <p class="text-xl mb-4 fade-up">Là người từng cảm thấy xúc động vì một người quá đỗi dễ thương và chân thành.</p>
                <p class="text-xl mb-8 fade-up">Là người không biết làm truyền thông, nhưng biết thế nào là "thật".</p>
                <p class="text-xl mb-8 fade-up">Họ không có phép thuật.</p>
                <p class="text-xl mb-8 fade-up">Nhưng họ có lòng tin — vào những điều tưởng như cổ tích:</p>
                <p class="text-xl mb-8 fade-up">Rằng món ăn nấu bằng cả trái tim sẽ ngon hơn.</p>
                <p class="text-xl mb-8 fade-up">Rằng một người chủ quán có thể trở thành người bạn dễ thương.</p>
                <p class="text-xl mb-8 fade-up">Rằng mỗi quán ăn, mỗi nơi ở, là một chương trong cuốn sách mang tên Việt Nam.</p>
                <p class="text-xl mb-8 fade-up">Họ không xây đế chế.</p>
                <p class="text-xl mb-8 fade-up">Họ đóng một chiếc thuyền.</p>
                <p class="text-xl mb-8 fade-up">Nhỏ thôi. Nhưng vững vàng.</p>
                <p class="text-xl mb-8 fade-up">Và đặt tên cho nó là <span class="vangxa-highlight">Vangxa</span> — tiếng vang của sự tử tế, được lan tỏa bằng sự chân thật.</p>
            </div>
        </section>
        
        <section id="part3" class="pt-24">
            <div class="content-container">
                <h3 class="text-3xl font-bold mb-4 gradient-text fade-up">Phần III</h3>
                <h2 class="text-8xl font-bold mb-4 gradient-text fade-up" style="line-height: 1.2;">Phép màu quay trở lại</h2>
                <p class="text-xl mb-4 fade-up"><span class="vangxa-highlight">Vangxa</span> không bắt đầu bằng động lực.</p>
                <p class="text-xl mb-4 fade-up">Nó bắt đầu bằng một nỗi trăn trở không thể nào nguôi.</p>
                <p class="text-xl mb-4 fade-up">Bằng sự quyết liệt muốn tìm lại phép màu đã bị mất.</p>
                <p class="text-xl mb-4 fade-up">Không kèn, không trống.</p>
                <p class="text-xl mb-8 fade-up">Chỉ có những bước chân lặng lẽ đi tìm điều thật.</p>
                <p class="text-xl mb-8 fade-up">Chỉ có những câu chuyện được kể bằng trái tim.</p>
                <p class="text-xl mb-8 fade-up">Những cái gật đầu của người chủ quán lâu năm, những nụ cười rụt rè nhưng ấm lòng.</p>
                <p class="text-xl mb-8 fade-up">Và dần dần, điều kỳ diệu xảy ra.</p>
                <p class="text-xl mb-8 fade-up">Một quán nhỏ bên bờ kênh bỗng đón thêm khách.</p>
                <p class="text-xl mb-8 fade-up">Một homestay vắng vẻ bỗng có người quay lại.</p>
                <p class="text-xl mb-8 fade-up">Một người trẻ, lần đầu được chạm vào sự tử tế — và nhận ra thế giới này chưa hề tuyệt vọng.</p>
                <p class="text-xl mb-8 fade-up">Phép màu, tưởng chừng đã biến mất, bắt đầu quay lại.</p>
                <p class="text-xl mb-8 fade-up">Không ồn ào. Không hào nhoáng.</p>
                <p class="text-xl mb-8 fade-up">Chỉ là những khoảnh khắc nhỏ xíu, góp nhặt thành một điều lớn lao.</p>
                <p class="text-xl mb-8 fade-up"><span class="vangxa-highlight">Vangxa</span> không chỉ là nền tảng.</p>
                <p class="text-xl mb-8 fade-up"><span class="vangxa-highlight">Vangxa</span> là bản đồ — chỉ đường bạn đến những con người, những địa điểm.</p>
                <p class="text-xl mb-8 fade-up">Là ánh lửa — để bạn sưởi ấm sau những lần bị niềm tin tổn thương.</p>
                <p class="text-xl mb-8 fade-up">Là lời mời — để bạn cùng kể tiếp câu chuyện đang dang dở.</p>
                <p class="text-xl mb-8 fade-up">Bởi vì nếu ta không kể, thì ai sẽ kể về những người chân thành, làm việc bằng tất cả tâm huyết?</p>
                <p class="text-xl mb-8 fade-up">Nếu ta không lan tỏa, thì những điều tử tế sẽ bị bỏ quên trong tiếng ồn.</p>
                <p class="text-xl mb-8 fade-up">Nếu ta không hành động, thì phép màu sẽ không thể nào quay trở lại.</p>
                <p class="text-xl mb-8 fade-up">Và bạn — người đang đọc những dòng này —</p>
                <p class="text-5xl font-bold mb-24 fade-up" style="background: linear-gradient(45deg, #ff8f00 0%, #ffb74d 50%, #ffcc80 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Bạn có muốn lên thuyền không? Đây là <span style="font-weight: 900; text-shadow: 0 2px 4px rgba(0,0,0,0.2);">Vangxa</span>. Một chuyến phiêu lưu đi tìm sự tử tế. Chúng tôi cần bạn.</p>
            </div>
        </section>
    </main>

    <footer>
        <div class="content-container">
            <h3 class="gradient-text"><span class="vangxa-highlight">Vangxa</span></h3>
            <p>Lan tỏa sự tử tế, kết nối những câu chuyện chân thật.</p>
            <div class="social-links">
                <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
            </div>
            <p>© 2025 <span class="vangxa-highlight">Vangxa</span>. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Cache DOM elements để tránh truy vấn lặp đi lặp lại
        const domElements = {
            header: document.querySelector('header'),
            lightRays: document.querySelector(".light-rays"),
            mysticalLight: document.querySelector(".mystical-light"),
            body: document.body,
            sections: document.querySelectorAll('section'),
            navLinks: document.querySelectorAll('.header-nav-link'),
            hamburger: document.querySelector('.hamburger'),
            mobileMenu: document.querySelector('.mobile-menu')
        };
        
        // Thêm biến để theo dõi scroll
        let lastScrollTop = 0;
        let scrollTimeout;
        let currentSection = "";
        let previousSection = "";
        let ticking = false;
        let isScrolling = false; // Theo dõi trạng thái scroll
        
        // Throttle function để tối ưu scroll events
        function throttle(callback, delay) {
            let last = 0;
            return function() {
                const now = Date.now();
                if (now - last >= delay) {
                    callback.apply(this, arguments);
                    last = now;
                }
            };
        }
        
        // Thêm object theo dõi theme colors để dùng với GSAP
        const themeColors = {
            intro: {
                bgColor: "#2c1c0f",
                gradientColors: {
                    color1: "rgba(200, 97, 37, 0.9)",
                    color2: "rgba(97, 53, 6, 0.95)",
                    color3: "rgba(20, 12, 6, 0.98)"
                }
            },
            part1: {
                bgColor: "#2d1d07",
                gradientColors: {
                    color1: "rgba(42, 21, 10, 0.9)",
                    color2: "rgba(18, 10, 5, 0.95)",
                    color3: "rgba(20, 12, 6, 0.98)"
                }
            },
            part2: {
                bgColor: "#3d2815",
                gradientColors: {
                    color1: "rgba(77, 50, 25, 0.9)",
                    color2: "rgba(60, 38, 17, 0.95)",
                    color3: "rgba(30, 15, 6, 0.98)"
                }
            },
            part3: {
                bgColor: "#6a3c0a",
                gradientColors: {
                    color1: "rgba(130, 61, 1, 0.9)",
                    color2: "rgba(109, 58, 4, 0.85)",
                    color3: "rgba(150, 55, 6, 0.9)"
                }
            }
        };
        
        // Sử dụng IntersectionObserver thay vì scroll event cho viewport section detection
        function setupSectionObservers() {
            const options = {
                root: null,
                rootMargin: '-45% 0px -55% 0px',
                threshold: 0
            };
            
            const sectionObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        previousSection = currentSection;
                        currentSection = entry.target.id;
                        if (previousSection !== currentSection) {
                            if (!isScrolling) {
                                handleSectionChange(currentSection, previousSection);
                            } else {
                                clearTimeout(scrollTimeout);
                                scrollTimeout = setTimeout(() => {
                                    handleSectionChange(currentSection, previousSection);
                                }, 100);
                            }
                        }
                    }
                });
            }, options);
            
            domElements.sections.forEach(section => {
                sectionObserver.observe(section);
            });
        }
        
        // Xử lý khi thay đổi section - với animation mượt mà
        function handleSectionChange(newSectionId, oldSectionId) {
            if (!newSectionId) return; // Tránh xử lý khi không có section ID

            // Cập nhật nav links
            updateNavLinks(newSectionId);
            
            // Animate theme transition thay vì chuyển đổi đột ngột
            animateThemeTransition(oldSectionId, newSectionId);
            
            // Cập nhật hiệu ứng ánh sáng theo section
            requestAnimationFrame(() => {
                if (newSectionId === "part2") {
                    domElements.lightRays.classList.add("active");
                    domElements.mysticalLight.classList.remove("active");
                } else if (newSectionId === "part3") {
                    domElements.lightRays.classList.remove("active");
                    domElements.mysticalLight.classList.add("active");
                } else {
                    domElements.lightRays.classList.remove("active");
                    domElements.mysticalLight.classList.remove("active");
                }
            });
        }
        
        // Animation chuyển đổi theme mượt mà
        function animateThemeTransition(fromSection, toSection) {
            // Nếu không có section trước đó (lần đầu load) thì đặt ngay không cần animation
            if (!fromSection) {
                // Đặt background trực tiếp, không cần animate
                updateThemeForSection(toSection);
                return;
            }
            
            // Lấy thông tin màu từ section cũ và mới
            const fromTheme = themeColors[fromSection] || themeColors.intro;
            const toTheme = themeColors[toSection] || themeColors.intro;
            
            // Tạo một element tạm cho animation (không thể animate gradient trực tiếp)
            const dummyEl = { 
                progress: 0,
                r1: parseInt(fromTheme.gradientColors.color1.match(/\d+/g)[0]),
                g1: parseInt(fromTheme.gradientColors.color1.match(/\d+/g)[1]),
                b1: parseInt(fromTheme.gradientColors.color1.match(/\d+/g)[2]),
                a1: parseFloat(fromTheme.gradientColors.color1.match(/[\d.]+(?=\))/)),
                r2: parseInt(fromTheme.gradientColors.color2.match(/\d+/g)[0]),
                g2: parseInt(fromTheme.gradientColors.color2.match(/\d+/g)[1]),
                b2: parseInt(fromTheme.gradientColors.color2.match(/\d+/g)[2]),
                a2: parseFloat(fromTheme.gradientColors.color2.match(/[\d.]+(?=\))/)),
                r3: parseInt(fromTheme.gradientColors.color3.match(/\d+/g)[0]),
                g3: parseInt(fromTheme.gradientColors.color3.match(/\d+/g)[1]),
                b3: parseInt(fromTheme.gradientColors.color3.match(/\d+/g)[2]),
                a3: parseFloat(fromTheme.gradientColors.color3.match(/[\d.]+(?=\))/))
            };
            
            // Mục tiêu values
            const toR1 = parseInt(toTheme.gradientColors.color1.match(/\d+/g)[0]);
            const toG1 = parseInt(toTheme.gradientColors.color1.match(/\d+/g)[1]);
            const toB1 = parseInt(toTheme.gradientColors.color1.match(/\d+/g)[2]);
            const toA1 = parseFloat(toTheme.gradientColors.color1.match(/[\d.]+(?=\))/));
            
            const toR2 = parseInt(toTheme.gradientColors.color2.match(/\d+/g)[0]);
            const toG2 = parseInt(toTheme.gradientColors.color2.match(/\d+/g)[1]);
            const toB2 = parseInt(toTheme.gradientColors.color2.match(/\d+/g)[2]);
            const toA2 = parseFloat(toTheme.gradientColors.color2.match(/[\d.]+(?=\))/));
            
            const toR3 = parseInt(toTheme.gradientColors.color3.match(/\d+/g)[0]);
            const toG3 = parseInt(toTheme.gradientColors.color3.match(/\d+/g)[1]);
            const toB3 = parseInt(toTheme.gradientColors.color3.match(/\d+/g)[2]);
            const toA3 = parseFloat(toTheme.gradientColors.color3.match(/[\d.]+(?=\))/));
            
            // Sử dụng GSAP để animation màu nền
            gsap.to(domElements.body, {
                backgroundColor: toTheme.bgColor,
                duration: 1.2,
                ease: "power2.inOut"
            });
            
            // Animate màu gradient
            gsap.to(dummyEl, {
                progress: 1,
                r1: toR1,
                g1: toG1,
                b1: toB1,
                a1: toA1,
                r2: toR2,
                g2: toG2,
                b2: toB2,
                a2: toA2,
                r3: toR3,
                g3: toG3,
                b3: toB3,
                a3: toA3,
                duration: 1.2,
                ease: "power2.inOut",
                onUpdate: function() {
                    // Cập nhật gradient trong khi animation
                    const newGradient = `radial-gradient(ellipse at center, 
                        rgba(${Math.round(dummyEl.r1)}, ${Math.round(dummyEl.g1)}, ${Math.round(dummyEl.b1)}, ${dummyEl.a1}) 0%, 
                        rgba(${Math.round(dummyEl.r2)}, ${Math.round(dummyEl.g2)}, ${Math.round(dummyEl.b2)}, ${dummyEl.a2}) 70%, 
                        rgba(${Math.round(dummyEl.r3)}, ${Math.round(dummyEl.g3)}, ${Math.round(dummyEl.b3)}, ${dummyEl.a3}) 100%)`;
                    
                    domElements.body.style.backgroundImage = newGradient;
                }
            });
        }
        
        // Thay đổi theme dựa trên section - không có animation, chỉ dùng khi khởi tạo
        function updateThemeForSection(section) {
            if (!section) section = 'intro';
            
            const theme = themeColors[section];
            if (!theme) return;
            
            // Cập nhật màu nền và gradient trực tiếp
            domElements.body.style.backgroundColor = theme.bgColor;
            
            const gradient = `radial-gradient(ellipse at center, 
                ${theme.gradientColors.color1} 0%, 
                ${theme.gradientColors.color2} 70%, 
                ${theme.gradientColors.color3} 100%)`;
                
            domElements.body.style.backgroundImage = gradient;
        }
        
        // Hàm mới chỉ cập nhật active nav link mà không thay đổi màu header
        function updateNavLinks(currentSection) {            
            // Cập nhật active nav link
            domElements.navLinks.forEach(link => {
                const linkHref = link.getAttribute('href').substring(1);
                link.classList.remove('active');
                if (linkHref === currentSection) {
                    link.classList.add('active');
                }
            });
        }
        
        // Tính toán phần trăm scroll trong một section - Không còn cần thiết, giữ lại cho tương thích ngược
        function calculateSectionProgress(sectionId) {
            const section = document.getElementById(sectionId);
            if (!section) return 0;
            
            const rect = section.getBoundingClientRect();
            const sectionHeight = rect.height;
            const viewportHeight = window.innerHeight;
            const scrolledHeight = viewportHeight / 2 - rect.top;
            
            return Math.max(0, Math.min(1, scrolledHeight / sectionHeight));
        }
        
        // Lazy load các chức năng không cần thiết ngay lập tức
        window.addEventListener('load', function() {
            // Bắt đầu hiệu ứng intro animation
            playIntroAnimation();
            
            // Cache các DOM elements còn lại sau khi trang đã tải xong
            domElements.sections = document.querySelectorAll('section');
            domElements.navLinks = document.querySelectorAll('.header-nav-link');
            domElements.hamburger = document.querySelector('.hamburger');
            domElements.mobileMenu = document.querySelector('.mobile-menu');
            
            // Thiết lập IntersectionObserver cho sections
            setupSectionObservers();
            
            // Đặt theme ban đầu
            updateThemeForSection('intro');
            
            // Khởi tạo GSAP ScrollTrigger cho các animation
            initGSAPAnimations();
            
            // Sử dụng requestIdleCallback để tải các tính năng không quan trọng
            if ('requestIdleCallback' in window) {
                requestIdleCallback(() => {
                    setupEventListeners();
                });
                
                // Trì hoãn tải hiệu ứng đặc biệt
                setTimeout(() => {
                    requestIdleCallback(() => {
                        addRandomLightFlashes();
                        createFireflies();
                    });
                }, 2500); // Tăng delay để sau intro animation
            } else {
                // Fallback cho trình duyệt không hỗ trợ requestIdleCallback
                setTimeout(() => {
                    setupEventListeners();
                    setTimeout(() => {
                        addRandomLightFlashes();
                        createFireflies();
                    }, 2500);
                }, 100);
            }
        });
        
        function playIntroAnimation() {
    // Ẩn nhanh loading indicator
    gsap.to("#loading", { opacity: 0, duration: 0.1, onComplete: () => {
        document.getElementById('loading').style.display = 'none';
    }});
    
    // Thêm hiệu ứng sóng nước
    const ripple = document.createElement('div');
    ripple.className = 'ripple-effect';
    document.body.appendChild(ripple);
    
    // Tạo timeline cho intro animation
    const introTimeline = gsap.timeline({
        onComplete: () => {
            // Xóa class loading-intro và overlay ngay lập tức
            document.body.classList.remove('loading-intro');
            document.getElementById('intro-overlay').style.opacity = '0';
            document.getElementById('intro-overlay').style.display = 'none';
            document.querySelector('.reveal-mask').style.display = 'none';
        }
    });
    
    // Thêm intro title animation - rút ngắn toàn bộ thời gian
    introTimeline
        .to("#intro-title", {
            opacity: 1,
            scale: 1.2,
            duration: 1.5,
            ease: "power2.out"
        })
        .to("#intro-title", {
            scale: 10,
            opacity: 0,
            duration: 0.5,
            ease: "power1.in"
        })
        
        // Hiệu ứng sóng nước - rút ngắn
        .to(ripple, {
            opacity: 0.9,
            scale: 5,
            duration: 0.5,
            ease: "sine.out"
        }, "-=0.3")
        .to(ripple, {
            opacity: 0,
            scale: 15,
            duration: 0.8,
            ease: "power2.out"
        }, "-=0.9")
        
        // Hiện các phần chính của trang ngay lập tức, không stagger
        .fromTo([
            "header", 
            "#boat-container", 
            "#intro .content-container", 
            ".light-rays",
            ".vignette",
            ".border-effect"], 
            { opacity: 0, y: (i) => i === 1 ? 10 : -30 },
            { 
                opacity: 1, 
                y: 0, 
                stagger: 0.01, 
                duration: 0.3, 
                ease: "power3.out",
                onComplete: () => {
                    // Flash nhanh
                    const flash = document.createElement('div');
                    flash.style.cssText = `
                        position: fixed;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        background-color: rgba(255, 180, 50, 0.2);
                        z-index: 90;
                        pointer-events: none;
                    `;
                    document.body.appendChild(flash);
                    
                    gsap.to(flash, {
                        opacity: 0,
                        duration: 1.3,
                        onComplete: () => flash.remove()
                    });
                }
            }, 
            "-=0.1"
        );
    
    // Thêm hiệu ứng tỏa sáng nhưng giảm thời gian
    createSparkleEffect();
}
        
        
        // Tạo hiệu ứng tỏa sáng
        function createSparkleEffect() {
    // Tạo ít đốm sáng hơn và giảm thời gian
    const container = document.body;
    
    for (let i = 0; i < 4; i++) {
        const sparkle = document.createElement('div');
        sparkle.className = 'sparkle';
        
        // Random kích thước
        const size = 3 + Math.random() * 8;
        
        // Vị trí ngẫu nhiên xung quanh center
        const centerX = window.innerWidth / 2;
        const centerY = window.innerHeight / 2;
        const angle = Math.random() * Math.PI * 2;
        const distance = 100 + Math.random() * 150;
        
        const x = centerX + Math.cos(angle) * distance;
        const y = centerY + Math.sin(angle) * distance;
        
        // Set style
        Object.assign(sparkle.style, {
            width: `${size}px`,
            height: `${size}px`,
            left: `${x}px`,
            top: `${y}px`,
            boxShadow: `0 0 ${size * 2}px ${size/2}px rgba(255, 180, 0, 0.8)`
        });
        
        container.appendChild(sparkle);
        
        // Animate nhanh hơn
        gsap.to(sparkle, {
            opacity: Math.random() * 0.7 + 0.3,
            duration: 0.2,
            delay: 0.1,
            onComplete: () => {
                gsap.to(sparkle, {
                    opacity: 0,
                    duration: 0.2,
                    delay: 0.4,
                    onComplete: () => sparkle.remove()
                });
            }
        });
        
        // Di chuyển nhanh hơn
        gsap.to(sparkle, {
            x: Math.random() * 100 - 50,
            y: Math.random() * 100 - 50,
            duration: 0.3,
            delay: 0.5,
            ease: "power1.out"
        });
    }
}
        // Khởi tạo GSAP animations
        function initGSAPAnimations() {
            // Đăng ký ScrollTrigger plugin
            gsap.registerPlugin(ScrollTrigger);
            
            // Cấu hình hiệu suất ScrollTrigger
            ScrollTrigger.config({
                limitCallbacks: true, // Giới hạn callbacks để tăng hiệu suất
                ignoreMobileResize: true, // Bỏ qua resize trên mobile
                refreshPriority: -10, // Giảm độ ưu tiên refresh để tối ưu hiệu suất
            });
            
            // Tạo batching cho elements giúp tăng hiệu suất
            // Batch tất cả các fade-up elements trong mỗi section
            domElements.sections.forEach(section => {
                const elements = section.querySelectorAll('.fade-up');
                
                // Sử dụng GSAP batch để giảm thiểu reflows
                gsap.set(elements, { opacity: 0, y: 30 });
                
                ScrollTrigger.batch(elements, {
                    batchMax: 4, // Giảm số lượng phần tử animate cùng lúc
                    onEnter: batch => gsap.to(batch, {
                        opacity: 1, 
                        y: 0, 
                        stagger: { 
                            each: 0.05,  // Giảm thời gian stagger
                            grid: [1, 2] // Giảm grid size
                        },
                        duration: 0.5,
                        ease: "power1.out", // Sử dụng ease function nhẹ hơn
                        overwrite: true, // Ngăn animations xung đột
                    }),
                    start: "top 85%", // Bắt đầu animation sớm hơn một chút
                    once: true, // Chỉ chạy animation một lần
                });
            });
            
            // Xử lý đặc biệt cho các tiêu đề
            const titles = document.querySelectorAll('h1.fade-up, h2.fade-up, h3.fade-up');
            
            gsap.set(titles, { opacity: 0, y: 50 });
            
            ScrollTrigger.batch(titles, {
                onEnter: batch => gsap.to(batch, {
                    opacity: 1, 
                    y: 0, 
                    duration: 0.6,
                    ease: "power1.out",
                }),
                start: "top 85%",
                once: true,
            });
            
            // Cleanup và invalidate để tối ưu bộ nhớ
            ScrollTrigger.addEventListener("refresh", () => {
                // Force garbage collection khi refresh ScrollTrigger
                if (window.gc) window.gc();
            });
            
            // Tối ưu hiệu suất bằng cách giảm mức chi tiết khi scroll nhanh
            // Sử dụng throttle để giảm số lượng event handler calls
            const throttledScrollHandler = throttle(() => {
                isScrolling = true;
                document.body.classList.add('fast-scrolling');
                
                clearTimeout(scrollTimeout);
                scrollTimeout = setTimeout(() => {
                    document.body.classList.remove('fast-scrolling');
                    isScrolling = false;
                }, 150);
            }, 50); // Throttle ở 50ms
            
            window.addEventListener("scroll", throttledScrollHandler, { passive: true });
        }
        
        // Tách biệt việc thiết lập event listeners để quản lý tốt hơn
        function setupEventListeners() {
            // Hamburger menu toggle - Chuyển đổi menu hamburger
            domElements.hamburger.addEventListener('click', () => {
                domElements.hamburger.classList.toggle('active');
                domElements.mobileMenu.classList.toggle('active');
            });
            
            document.querySelectorAll('.mobile-menu a').forEach(link => {
                link.addEventListener('click', () => {
                    domElements.hamburger.classList.remove('active');
                    domElements.mobileMenu.classList.remove('active');
                });
            });
            
            // Dropdown functionality - Chức năng dropdown
            const dropdowns = document.querySelectorAll('.dropdown');
            
            dropdowns.forEach(dropdown => {
                const trigger = dropdown.querySelector('.dropdown-trigger');
                const content = dropdown.querySelector('.dropdown-content');
                
                trigger.addEventListener('click', (e) => {
                    e.stopPropagation();
                    // Đóng tất cả dropdown khác
                    dropdowns.forEach(otherDropdown => {
                        if (otherDropdown !== dropdown) {
                            otherDropdown.classList.remove('open');
                            otherDropdown.querySelector('.dropdown-content').classList.remove('active');
                        }
                    });
                    
                    // Chuyển đổi dropdown hiện tại
                    dropdown.classList.toggle('open');
                    content.classList.toggle('active');
                });
            });
            
            // Đóng dropdown khi click bên ngoài
            document.addEventListener('click', () => {
                dropdowns.forEach(dropdown => {
                    dropdown.classList.remove('open');
                    dropdown.querySelector('.dropdown-content').classList.remove('active');
                });
            });
            
            // Ngăn sự kiện click trên nội dung dropdown lan ra ngoài
            document.querySelectorAll('.dropdown-content').forEach(content => {
                content.addEventListener('click', (e) => {
                    e.stopPropagation();
                });
            });
        }
        
        // Tối ưu hàm tạo hiệu ứng ánh sáng
        function addRandomLightFlashes() {
            // Giảm số lần flash và kiểm tra section hiện tại ít hơn
            let flashTimeout;
            
            function flashLight() {
                if (currentSection === "part2" && domElements.lightRays.classList.contains("active")) {
                    // Sử dụng requestAnimationFrame và transform thay vì opacity để tận dụng GPU
                    requestAnimationFrame(() => {
                        domElements.lightRays.style.filter = 'brightness(1.3)';
                        
                        setTimeout(() => {
                            if (domElements.lightRays.classList.contains("active")) {
                                requestAnimationFrame(() => {
                                    domElements.lightRays.style.filter = 'brightness(1)';
                                });
                            }
                        }, 200);
                    });
                }
                
                if (currentSection === "part3" && domElements.mysticalLight.classList.contains("active")) {
                    requestAnimationFrame(() => {
                        domElements.mysticalLight.style.filter = 'brightness(1.3)';
                        
                        setTimeout(() => {
                            if (domElements.mysticalLight.classList.contains("active")) {
                                requestAnimationFrame(() => {
                                    domElements.mysticalLight.style.filter = 'brightness(1)';
                                });
                            }
                        }, 200);
                    });
                }
                
                // Giảm tần suất flash xuống (5-12 giây) để giảm tải CPU
                flashTimeout = setTimeout(flashLight, 5000 + Math.random() * 7000);
            }
            
            // Bắt đầu chu kỳ flash
            flashLight();
            
            // Dừng hiệu ứng khi tab không hiển thị để tiết kiệm tài nguyên
            document.addEventListener('visibilitychange', function() {
                if (document.hidden) {
                    clearTimeout(flashTimeout);
            } else {
                    flashLight();
                }
            });
        }
        
        // Tối ưu hàm tạo đom đóm
        function createFireflies() {
    const container = document.getElementById('firefliesContainer');
    const isMobile = window.innerWidth <= 768;
    const count = isMobile ? 10 : Math.min(20, Math.floor(window.innerWidth / 60));
    const fragment = document.createDocumentFragment();

    for (let i = 0; i < count; i++) {
        const firefly = document.createElement('div');
        firefly.className = 'firefly';

        const randomX = Math.random() * 100;
        const randomY = Math.random() * 100;

        Object.assign(firefly.style, {
            left: `${randomX}%`,
            top: `${randomY}%`,
            animation: `firefly-float ${15 + Math.random() * 7}s linear infinite`,
            animationDelay: `${Math.random() * 3}s`,
            willChange: 'transform, opacity'
        });

        fragment.appendChild(firefly);
    }

    container.appendChild(fragment);
}
        
        // Xóa hàm createFloatingLanterns() vì không còn cần thiết
        
        // Tối ưu hiệu suất khi tab không được hiển thị
        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                // Tạm dừng các animation không cần thiết khi tab không hiển thị
                document.body.classList.add('performance-mode');
            } else {
                document.body.classList.remove('performance-mode');
            }
        });
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r134/three.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
  <script src="https://unpkg.com/@studio-freight/lenis@1.0.42/dist/lenis.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
  <style>
    :root {
      --bg: #0a1c2e;
      --text: #e0f7fa;
      --text-bright: #f0faff;
      --neon: #00e5ff;
      --neon-dark: #00b7cc;
    }
    .dark-mode {
      --bg: #121212;
      --text: #e0e0e0;
      --text-bright: #ffffff;
      --neon: #bb86fc;
      --neon-dark: #3700b3;
    }
    body {
      margin: 0;
      overflow-x: hidden;
      background: var(--bg);
      color: var(--text);
      font-family: 'Arial', sans-serif;
    }
    canvas {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 1;
      pointer-events: none;
    }
    .header {
      position: fixed;
      top: 0;
      width: 100%;
      background: rgba(10, 28, 46, 0.85);
      z-index: 100;
      transition: transform 0.3s ease;
      transform: translateY(-100%);
    }
    .dark-mode .header {
      background: rgba(18, 18, 18, 0.85);
    }
    .header.visible {
      transform: translateY(0);
    }
    .header .logo {
      font-size: 1.5rem;
      font-weight: bold;
      color: var(--neon);
      text-shadow: 0 0 10px var(--neon-dark);
    }
    .header .menu {
      display: flex;
      align-items: center;
    }
    .header .menu ul {
      display: flex;
      list-style: none;
      margin: 0;
      padding: 0;
    }
    .header .menu li {
      margin: 0 1rem;
    }
    .header .menu a {
      color: var(--text);
      font-size: 1.1rem;
      transition: color 0.3s, text-shadow 0.3s;
      padding-bottom: 0.3rem;
      position: relative;
    }
    .header .menu a::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 2px;
      background: var(--neon);
      transform: scaleX(0);
      transform-origin: right;
      transition: transform 0.3s ease;
    }
    .header .menu a:hover {
      color: var(--neon);
      text-shadow: 0 0 10px var(--neon-dark);
    }
    .header .menu a:hover::after {
      transform: scaleX(1);
      transform-origin: left;
    }
    .header .language,
    .header .user-menu {
      position: relative;
      display: flex;
      align-items: center;
      cursor: pointer;
      width: 40px;
      height: 40px;
      border: 2px solid var(--neon);
      border-radius: 50%;
      transition: transform 0.3s, box-shadow 0.3s;
      margin-left: 0.5rem;
    }
    .header .language:hover,
    .header .user-menu:hover {
      transform: rotate(360deg);
      box-shadow: 0 0 15px var(--neon-dark);
    }
    .header .language svg,
    .header .user-menu svg {
      width: 24px;
      height: 24px;
      fill: var(--neon);
      margin: auto;
    }
    .header .language-dropdown,
    .header .user-dropdown {
      display: none;
      position: absolute;
      top: 100%;
      right: 0;
      background: rgba(10, 28, 46, 0.95);
      border: 2px solid var(--neon);
      border-radius: 0.5rem;
      list-style: none;
      padding: 0.5rem 0;
      margin: 0.5rem 0 0;
      z-index: 10;
      min-width: 150px;
    }
    .dark-mode .language-dropdown,
    .dark-mode .user-dropdown {
      background: rgba(18, 18, 18, 0.95);
    }
    .header .language-dropdown.active,
    .header .user-dropdown.active {
      display: block;
    }
    .header .language-dropdown li,
    .header .user-dropdown li {
      padding: 0.5rem 1.5rem;
      color: var(--text);
      cursor: pointer;
      transition: background 0.3s, color 0.3s;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }
    .header .language-dropdown li:hover,
    .header .user-dropdown li:hover {
      background: rgba(var(--neon-rgb, 0, 229, 255), 0.2);
      color: var(--neon);
    }
    .header .user-dropdown svg {
      width: 16px;
      height: 16px;
    }
    .header .hamburger {
      display: none;
      cursor: pointer;
      width: 40px;
      height: 40px;
      border: 2px solid var(--neon);
      border-radius: 50%;
      transition: transform 0.3s, box-shadow 0.3s;
    }
    .header .hamburger:hover {
      transform: rotate(360deg);
      box-shadow: 0 0 15px var(--neon-dark);
    }
    .header .hamburger svg {
      width: 24px;
      height: 24px;
      fill: var(--neon);
      margin: auto;
    }
    .header .mobile-menu {
  position: fixed;
  top: 0;
  right: 0;
  width: 80%;
  height: auto; /* Chiều cao tự điều chỉnh theo nội dung */
  background: linear-gradient(135deg, rgba(0, 229, 255, 0.9), rgba(10, 28, 46, 1));
  border-left: 2px solid var(--neon);
  transform: translateX(100%);
  transition: transform 0.3s ease;
  z-index: 99;
  padding: 2rem;
  display: flex;
  flex-direction: column;
  align-items: center;
  box-sizing: border-box;
}
.dark-mode .mobile-menu {
  background: linear-gradient(135deg, rgba(187, 134, 252, 0.9), rgba(18, 18, 18, 1));
}
.header .mobile-menu > * {
  background: transparent !important;
  position: relative;
  z-index: 1;
}
.header .mobile-menu.active {
  transform: translateX(0);
}
.header .mobile-menu .logo {
  font-size: 2rem;
  margin-bottom: 2rem;
  background: transparent;
}
.header .mobile-menu .exit-menu {
  position: absolute;
  top: 2rem;
  right: 2rem;
  background: transparent;
}
.header .mobile-menu ul {
  list-style: none;
  padding: 0;
  width: 100%;
  text-align: center;
  background: transparent;
  margin-bottom: 2rem; /* Thêm margin để giữ khoảng cách */
}
.header .mobile-menu li {
  margin: 1.5rem 0;
}
.header .mobile-menu a {
  color: var(--text);
  font-size: 1.5rem;
  transition: color 0.3s, text-shadow 0.3s;
}
.header .mobile-menu a:hover {
  color: var(--neon);
  text-shadow: 0 0 10px var(--neon-dark);
}
    
    .section {
      position: relative;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 10;
      padding: 5rem 2rem;
    }
    .section-content {
      max-width: 1400px;
      width: 100%;
      pointer-events: auto;
      z-index: 15;
    }
    .section h2 {
      font-size: 4rem;
      text-shadow: 0 0 20px var(--neon-dark);
      margin-bottom: 2rem;
      color: var(--text-bright);
    }
    .section p {
      font-size: 1.3rem;
      line-height: 1.9;
      color: var(--text-bright);
      text-shadow: 0 0 10px var(--neon-dark);
    }
    .cta-button {
      display: inline-block;
      margin-top: 2.5rem;
      padding: 1rem 2.5rem;
      background: linear-gradient(45deg, var(--neon), var(--neon-dark));
      color: var(--bg);
      font-weight: bold;
      border-radius: 0.75rem;
      transition: transform 0.3s, box-shadow 0.3s, background 0.3s;
      pointer-events: auto;
      position: relative;
      overflow: hidden;
      z-index: 20;
    }
    .cta-button:hover {
      transform: translateY(-6px) rotate(2deg);
      box-shadow: 0 0 30px var(--neon-dark);
      background: linear-gradient(45deg, var(--neon-dark), var(--neon));
    }
    .cta-button::after {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 0;
      height: 0;
      background: rgba(255, 255, 255, 0.3);
      border-radius: 50%;
      transform: translate(-50%, -50%);
      transition: width 0.4s, height 0.4s;
    }
    .cta-button:hover::after {
      width: 200px;
      height: 200px;
    }
    .banner {
      text-align: center;
      pointer-events: none;
      z-index: 10;
    }
    .banner h2 {
      font-size: 8rem;
      font-weight: 900;
      color: var(--text-bright);
      text-shadow: 0 0 25px var(--neon);
      line-height: 1.2;
    }
    .banner p {
      font-size: 2.2rem;
      color: var(--text-bright);
      text-shadow: 0 0 15px var(--neon-dark);
    }
    @keyframes pulse {
      0%, 100% { opacity: 0.8; }
      50% { opacity: 1; }
    }
    .footer {
      position: relative;
      padding: 4rem 2rem;
      background: rgba(10, 28, 46, 0.95);
      z-index: 15;
      overflow: hidden;
      text-align: center;
    }
    .dark-mode .footer {
      background: rgba(18, 18, 18, 0.95);
    }
    .footer::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: repeating-linear-gradient(
        0deg,
        transparent,
        transparent 20px,
        rgba(var(--neon-rgb, 0, 229, 255), 0.1) 20px,
        rgba(var(--neon-rgb, 0, 229, 255), 0.1) 22px
      ),
      repeating-linear-gradient(
        90deg,
        transparent,
        transparent 20px,
        rgba(var(--neon-rgb, 0, 229, 255), 0.1) 20px,
        rgba(var(--neon-rgb, 0, 229, 255), 0.1) 22px
      );
      opacity: 0.5;
      z-index: -1;
    }
    .footer .logo {
      font-size: 3rem;
      font-weight: 900;
      color: var(--neon);
      text-shadow: 0 0 15px var(--neon);
      margin-bottom: 2rem;
      animation: neonPulse 2s infinite ease-in-out;
    }
    @keyframes neonPulse {
      0%, 100% { text-shadow: 0 0 15px var(--neon); }
      50% { text-shadow: 0 0 25px var(--neon); }
    }
    .footer .social-links {
      display: flex;
      justify-content: center;
      gap: 2rem;
    }
    .footer .social-links a {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 50px;
      height: 50px;
      background: rgba(var(--neon-rgb, 0, 229, 255), 0.2);
      border: 2px solid var(--neon);
      border-radius: 50%;
      transition: transform 0.3s, background 0.3s, box-shadow 0.3s;
      position: relative;
      overflow: hidden;
    }
    .footer .social-links a:hover {
      transform: rotate(360deg);
      background: rgba(var(--neon-rgb, 0, 229, 255), 0.4);
      box-shadow: 0 0 20px var(--neon-dark);
    }
    .footer .social-links a::after {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 0;
      height: 0;
      background: rgba(255, 255, 255, 0.3);
      border-radius: 50%;
      transform: translate(-50%, -50%);
      transition: width 0.4s, height 0.4s;
    }
    .footer .social-links a:hover::after {
      width: 100px;
      height: 100px;
    }
    .footer .social-links svg {
      fill: var(--neon);
      width: 24px;
      height: 24px;
    }
    .about-container {
      display: flex;
      align-items: center;
      gap: 4rem;
    }
    .about-image {
      width: 50%;
      height: 500px;
      background: url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c') center/cover no-repeat;
      border-radius: 1.5rem;
      transform: rotate(-5deg);
      transition: transform 0.5s, box-shadow 0.5s;
      opacity: 0;
    }
    .about-image:hover {
      transform: rotate(0deg) scale(1.05);
      box-shadow: 0 0 40px var(--neon-dark);
    }
    .about-text {
      width: 50%;
      padding: 3rem;
      background: rgba(10, 28, 46, 0.7);
      border-radius: 1.5rem;
      transform: translateX(20px);
      transition: transform 0.5s, background 0.5s;
    }
    .dark-mode .about-text {
      background: rgba(18, 18, 18, 0.7);
    }
    .about-text:hover {
      transform: translateX(0) scale(1.03);
      background: rgba(10, 28, 46, 0.9);
    }
    .dark-mode .about-text:hover {
      background: rgba(18, 18, 18, 0.9);
    }
    .features-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 2.5rem;
    }
    .feature-card {
      background: rgba(10, 28, 46, 0.9);
      border: 2px solid var(--neon);
      border-radius: 1rem;
      padding: 2rem;
      text-align: center;
      transition: transform 0.3s, box-shadow 0.3s;
      margin: 1rem;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 1rem;
      text-decoration: none;
      color: inherit;
    }
    .feature-card:hover {
      transform: translateY(-15px) rotate(3deg);
      box-shadow: 0 0 50px var(--neon-dark);
      background: linear-gradient(135deg, rgba(var(--neon-rgb, 0, 229, 255), 0.2), rgba(10, 28, 46, 0.9));
    }
    .dark-mode .feature-card:hover {
      background: linear-gradient(135deg, rgba(var(--neon-rgb, 187, 134, 252), 0.2), rgba(18, 18, 18, 0.9));
    }
    .feature-card::before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle, rgba(var(--neon-rgb, 0, 229, 255), 0.3), transparent);
      opacity: 0;
      transition: opacity 0.5s;
    }
    .feature-card:hover::before {
      opacity: 1;
    }
    .feature-icon {
      width: 100px;
      height: 100px;
      margin: 0 auto 1.5rem;
      background: url('https://images.unsplash.com/photo-1516321310764-8a238815b2fd') center/cover no-repeat;
      border-radius: 50%;
      transition: transform 0.5s;
    }
    .feature-card:hover .feature-icon {
      transform: scale(1.2) rotate(10deg);
    }
    .story-container {
      padding: 4rem 0;
    }
    .story-entry {
      display: flex;
      align-items: center;
      margin: 4rem 0;
      opacity: 0;
    }
    .story-entry:nth-child(odd) {
      flex-direction: row-reverse;
    }
    .story-content {
      width: 50%;
      padding: 2.5rem;
      background: rgba(10, 28, 46, 0.85);
      border-radius: 1rem;
      transition: transform 0.5s, box-shadow 0.5s, background 0.5s;
    }
    .dark-mode .story-content {
      background: rgba(18, 18, 18, 0.85);
    }
    .story-entry:hover .story-content {
      transform: scale(1.08) rotate(-2deg);
      box-shadow: 0 0 40px var(--neon-dark);
      background: rgba(10, 28, 46, 1);
    }
    .dark-mode .story-entry:hover .story-content {
      background: rgba(18, 18, 18, 1);
    }
    .story-image {
      width: 300px;
      height: 300px;
      background: url('https://images.unsplash.com/photo-1516321497487-e288fb19713f') center/cover no-repeat;
      border-radius: 1rem;
      margin: 0 3rem;
      transform: rotate(5deg);
      transition: transform 0.5s, box-shadow 0.5s;
      box-shadow: 0 0 20px rgba(var(--neon-rgb, 0, 229, 255), 0.3);
    }
    .story-entry:hover .story-image {
      transform: rotate(0deg) scale(1.1);
      box-shadow: 0 0 50px rgba(var(--neon-rgb, 0, 229, 255), 0.5);
    }
    .join-container {
      background: rgba(10, 28, 46, 0.9);
      padding: 4rem;
      border-radius: 2rem;
      max-width: 800px;
      margin: 0 auto;
      opacity: 0;
      box-shadow: 0 0 30px rgba(var(--neon-rgb, 0, 229, 255), 0.4);
      transition: transform 0.5s, box-shadow 0.5s;
    }
    .dark-mode .join-container {
      background: rgba(18, 18, 18, 0.9);
    }
    .join-container:hover {
      transform: scale(1.05);
      box-shadow: 0 0 60px rgba(var(--neon-rgb, 0, 229, 255), 0.6);
    }
    .join-form input,
    .join-form textarea {
      width: 100%;
      padding: 1.2rem;
      margin: 1rem 0;
      background: var(--text);
      border: none;
      border-radius: 0.75rem;
      color: var(--bg);
      transition: transform 0.3s, box-shadow 0.3s, background 0.3s;
    }
    .join-form input:focus,
    .join-form textarea:focus {
      transform: scale(1.03);
      box-shadow: 0 0 20px var(--neon);
      background: var(--text-bright);
      outline: none;
    }
    .join-form button {
      background: linear-gradient(45deg, var(--neon), var(--neon-dark));
      color: var(--bg);
      padding: 1.2rem 3rem;
      border: none;
      border-radius: 0.75rem;
      cursor: pointer;
      transition: transform 0.3s, box-shadow 0.3s, background 0.3s;
      position: relative;
      overflow: hidden;
    }
    .join-form button:hover {
      transform: translateY(-6px) rotate(2deg);
      box-shadow: 0 0 40px var(--neon-dark);
      background: linear-gradient(45deg, var(--neon-dark), var(--neon));
    }
    .join-form button::after {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 0;
      height: 0;
      background: rgba(255, 255, 255, 0.4);
      border-radius: 50%;
      transform: translate(-50%, -50%);
      transition: width 0.4s, height 0.4s;
    }
    .join-form button:hover::after {
      width: 300px;
      height: 300px;
    }
    .scroll-progress {
      position: fixed;
      top: 0;
      left: 0;
      width: 0;
      height: 4px;
      background: var(--neon);
      z-index: 100;
      transition: width 0.2s ease;
    }
    @media (max-width: 768px) {
      .header .menu {
        display: none;
      }
      .header .hamburger {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: 0.5rem;
      }
      .header .language,
      .header .user-menu {
        margin-left: 0.5rem;
      }
      .section {
        padding: 3rem 1rem;
      }
      .banner h2 {
        font-size: 4rem;
      }
      .banner p {
        font-size: 1.2rem;
      }
      .section h2 {
        font-size: 2.5rem;
      }
      .section p {
        font-size: 0.9rem;
      }
      .cta-button {
        padding: 0.8rem 2rem;
      }
      .about-container {
        flex-direction: column;
        gap: 2rem;
      }
      .about-image,
      .about-text {
        width: 100%;
        transform: none;
      }
      .about-image {
        height: 300px;
      }
      .about-text {
        padding: 2rem;
      }
      .features-grid {
        grid-template-columns: 1fr;
      }
      .story-entry {
        flex-direction: column;
        gap: 2rem;
      }
      .story-content,
      .story-image {
        width: 100%;
        margin: 0;
      }
      .story-image {
        height: 200px;
      }
      .join-container {
        padding: 2rem;
      }
      .footer {
        padding: 2rem 1rem;
      }
      .footer .logo {
        font-size: 2rem;
      }
      .footer .social-links {
        flex-direction: column;
        gap: 1rem;
      }
      .footer .social-links a {
        width: 40px;
        height: 40px;
      }
      .footer .social-links svg {
        width: 20px;
        height: 20px;
      }
    }
    .header .exit-menu {
  position: absolute;
  top: 2rem;
  right: 2rem;
  cursor: pointer;
  width: 40px;
  height: 40px;
  border: 2px solid var(--neon);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: transform 0.3s, box-shadow 0.3s;
}
.header .exit-menu:hover {
  transform: rotate(90deg);
  box-shadow: 0 0 15px var(--neon-dark);
}
.header .exit-menu svg {
  width: 24px;
  height: 24px;
  fill: var(--neon);
}
  </style>
</head>
<body>
  <div class="scroll-progress"></div>
  <header class="header">
    <div class="container mx-auto flex justify-between items-center py-4 px-6">
    <a href="/" class="logo"
                    style="display: flex; align-items: center; text-decoration: none;">
                    <img src="/image/ship.png" alt="Logo" width="50" height="52" />
                    <span
                        style="margin-left: 8px; font-size: 26px;     font-weight: bold; color: #008cff; font-family: Verdana, sans-serif;">
                        Vangxa
                    </span>
                </a>
      
      <nav class="menu">
        <ul>
          <li><a href="#banner">Trang chủ</a></li>
          <li><a href="#about">Giới thiệu</a></li>
          <li><a href="#features">Tính năng</a></li>
          <li><a href="#story">Câu chuyện</a></li>
          <li><a href="#join">Tham gia</a></li>
        </ul>
      </nav>
      <div class="flex items-center">
        <div class="language">
          <svg viewBox="0 0 24 24">
            <path d="M12 2a10 10 0 00-10 10 10 10 0 0010 10 10 10 0 0010-10A10 10 0 0012 2zm0 18a8 8 0 01-8-8 8 8 0 018-8 8 8 0 018 8 8 8 0 01-8 8zm4-14h-2v6h2zm-4 8H8v2h4zm0-2V8H8v4zm4 0h-2v2h2z"/>
          </svg>
          <ul class="language-dropdown">
            <li>Tiếng Việt</li>
            <li>English</li>
          </ul>
        </div>
        <div class="user-menu">
          <svg viewBox="0 0 24 24">
            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
          </svg>
          <ul class="user-dropdown">
            <li>
              <svg viewBox="0 0 24 24">
                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
              </svg>
              Login
            </li>
            <li>
              <svg viewBox="0 0 24 24">
                <path d="M19.14 12.94c.04-.3.06-.61.06-.94s-.02-.64-.06-.94l2.03-1.58a.49.49 0 00.12-.61l-1.92-3.32a.49.49 0 00-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94l-.36-2.54a.49.49 0 00-.48-.41h-3.84a.49.49 0 00-.48.41l-.36 2.54c-.59.24-1.13-.56-1.62-.94l-2.39-.96a.49.49 0 00-.59.22l-1.92 3.32c-.12.22-.07.5.12.61l2.03 1.58c-.04.3-.06.64-.06.94s.02.64.06.94l-2.03 1.58a.49.49 0 00-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .43-.17.48-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32c.12-.22.07-.5-.12-.61l-2.03-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6 3.6 1.62 3.6 3.6-1.62 3.6-3.6 3.6z"/>
              </svg>
              Settings
            </li>
            <li class="dark-mode-toggle">
              <svg viewBox="0 0 24 24">
                <path d="M12 7c-2.76 0-5 2.24-5 5s2.24 5 5 5 5-2.24 5-5-2.24-5-5-5zM2 13h2c.55 0 1-.45 1-1s-.45-1-1-1H2c-.55 0-1 .45-1 1s.45 1 1 1zm18 0h2c.55 0 1-.45 1-1s-.45-1-1-1h-2c-.55 0-1 .45-1 1s.45 1 1 1zM11 2v2c0 .55.45 1 1 1s1-.45 1-1V2c0-.55-.45-1-1-1s-1 .45-1 1zm0 18v2c0 .55.45 1 1 1s1-.45 1-1v-2c0-.55-.45-1-1-1s-1 .45-1 1zM5.99 4.57a1 1 0 00-1.41 0L3.17 6.17a1 1 0 000 1.41c.39.39 1.02.39 1.41 0l1.41-1.41a1 1 0 000-1.41zm14.24 14.24a1 1 0 000-1.41l-1.41-1.41a1 1 0 00-1.41 0 1 1 0 000 1.41l1.41 1.41a1 1 0 001.41 0zM4.57 19.43l1.41-1.41a1 1 0 000-1.41 1 1 0 00-1.41 0l-1.41 1.41a1 1 0 000 1.41c.39.39 1.02.39 1.41 0zm14.24-14.24l1.41 1.41a1 1 0 001.41 0 1 1 0 000-1.41l-1.41-1.41a1 1 0 00-1.41 0 1 1 0 000 1.41z"/>
              </svg>
              Dark Mode
            </li>
          </ul>
        </div>
        <div class="hamburger">
          <svg viewBox="0 0 24 24">
            <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/>
          </svg>
        </div>
      </div>
    </div>
    <div class="mobile-menu">
      <div class="logo">VANGXA</div>
      <div class="exit-menu">
        <svg viewBox="0 0 24 24">
          <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
        </svg>
      </div>
      <ul>
        <li><a href="#banner">Trang chủ</a></li>
        <li><a href="#about">Về VANGXA</a></li>
        <li><a href="#features">Khám phá</a></li>
        <li><a href="#story">Câu chuyện</a></li>
        <li><a href="#join">Tham gia ngay</a></li>
      </ul>
     
    </div>
  </header>
  <section id="banner" class="section">
    <div class="section-content">
      <div class="banner">
        <h2>VANGXA</h2>
        <p>Khám phá Việt Nam qua ẩm thực và những câu chuyện du lịch</p>
       
        
      </div>
    </div>
  </section>
  <section id="about" class="section">
    <div class="section-content">
      <h2 class="text-center" id="about-title">Khám phá VANGXA</h2>
      <div class="about-container">
        <div class="about-image" style="background-image: url('https://images.unsplash.com/photo-1516321497487-e288fb19713f')"></div>
        <div class="about-text">
          <h2>Khám phá Việt Nam</h2>
          <p>Trải nghiệm văn hóa Việt Nam thông qua ẩm thực và tour du lịch</p>
          <p>VANGXA là cầu nối giúp bạn khám phá những điểm đến đẹp nhất Việt Nam, thưởng thức tinh hoa ẩm thực bản địa và chia sẻ những câu chuyện độc đáo về văn hóa Việt Nam.</p>
          <a href="#features" class="cta-button">Khám phá ngay</a>
        </div>
      </div>
    </div>
  </section>
  <section id="features" class="section">
    <div class="section-content">
      <h2 class="text-center" id="features-title">Khám phá Việt Nam qua ẩm thực và những câu chuyện du lịch</h2>
      <div class="features-grid">
        <a href="{{ route('lodging') }}" class="feature-card">
          <div class="feature-icon" style="background-image: url('https://images.unsplash.com/photo-1516321497487-e288fb19713f')"></div>
          <h3>Điểm Đến</h3>
          <p>Đặt tour và khám phá các điểm đến du lịch độc đáo tại Việt Nam</p>
        </a>
        <a href="{{ route('dining') }}" class="feature-card">
          <div class="feature-icon" style="background-image: url('https://images.unsplash.com/photo-1516321497487-e288fb19713f')"></div>
          <h3>Ẩm Thực</h3>
          <p>Khám phá tinh hoa ẩm thực Việt Nam và đặt tour thưởng thức ẩm thực địa phương</p>
        </a>
        <a href="{{ route('groupss.index') }}" class="feature-card">
          <div class="feature-icon" style="background-image: url('https://images.unsplash.com/photo-1516321497487-e288fb19713f')"></div>
          <h3>Cộng Đồng</h3>
          <p>Kết nối với cộng đồng chia sẻ kinh nghiệm du lịch và ẩm thực Việt Nam</p>
        </a>
      </div>
      <a href="#story" class="cta-button block text-center">Hiểu thêm về chúng tôi</a>
    </div>
  </section>
  <section id="story" class="section">
    <div class="section-content">
      <h2 class="text-center" id="story-title">Hành trình của VANGXA</h2>
      <div class="story-container">
        <div class="story-entry">
          <div class="story-image"></div>
          <div class="story-content">
            <h3 class="text-2xl">Khởi nguồn từ tình yêu</h3>
            <p>Năm 2023, VANGXA ra đời từ tình yêu với văn hóa ẩm thực và du lịch Việt Nam, với mong muốn chia sẻ những điều tốt đẹp nhất của đất nước.</p>
          </div>
        </div>
        <div class="story-entry">
          <div class="story-image" style="background-image: url('https://images.unsplash.com/photo-1534447677768-be436bb09401')"></div>
          <div class="story-content">
            <h3 class="text-2xl">Kết nối văn hóa</h3>
            <p>Đến năm 2025, VANGXA đã trở thành cầu nối quan trọng giữa văn hóa ẩm thực và du lịch Việt Nam với bạn bè quốc tế.</p>
          </div>
        </div>
      </div>
      <a href="#join" class="cta-button block text-center">Tham gia ngay</a>
    </div>
  </section>
  <section id="join" class="section">
    <div class="section-content">
      <h2 class="text-center" id="join-title">Bắt đầu hành trình sáng tạo</h2>
      <p class="text-center max-w-3xl mx-auto">Hãy tham gia VANGXA để kể câu chuyện của bạn, kết nối với cộng đồng, và trở thành nhà sáng tạo mà bạn luôn mơ ước. Đăng ký miễn phí ngay hôm nay!</p>
      <div class="join-container">
        <form class="join-form">
          <input type="text" placeholder="Họ và tên" />
          <input type="email" placeholder="Email" />
          <textarea placeholder="Bạn muốn sáng tạo điều gì?" rows="5"></textarea>
          <button>Tham gia miễn phí</button>
        </form>
      </div>
    </div>
  </section>
  <footer class="footer" id="footer">
    <div class="logo">VANGXA</div>
    <div class="social-links">
      <a href="#">
        <svg viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path></svg>
      </a>
      <a href="#">
        <svg viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"></path></svg>
      </a>
      <a href="#">
        <svg viewBox="0 0 24 24"><path d="M16.5 3h-9A4.5 4.5 0 003 7.5v9A4.5 4.5 0 007.5 21h9a4.5 4.5 0 004.5-4.5v-9A4.5 4.5 0 0016.5 3zm-4.5 15.75a6 6 0 110-12 6 6 0 010 12zm6.75-10.5a1.5 1.5 0 110-3 1.5 1.5 0 010 3z"></path></svg>
      </a>
    </div>
  </footer>
  <script>
    // Set neon RGB for CSS
    const setNeonRGB = () => {
      const neon = document.documentElement.classList.contains('dark-mode') ? '187, 134, 252' : '0, 229, 255';
      document.documentElement.style.setProperty('--neon-rgb', neon);
    };

    // Dark Mode
    if (localStorage.getItem('dark-mode') === 'enabled') {
      document.documentElement.classList.add('dark-mode');
    }
    setNeonRGB();
    document.querySelectorAll('.dark-mode-toggle').forEach(toggle => {
      toggle.addEventListener('click', () => {
        document.documentElement.classList.toggle('dark-mode');
        localStorage.setItem('dark-mode', document.documentElement.classList.contains('dark-mode') ? 'enabled' : 'disabled');
        setNeonRGB();
        renderer.setClearColor(document.documentElement.classList.contains('dark-mode') ? 0x121212 : 0x0a1c2e, 1);
        directionalLight.color.setHex(document.documentElement.classList.contains('dark-mode') ? 0xbb86fc : 0x00e5ff);
      });
    });

    // Smooth scrolling with Lenis
    const lenis = new Lenis({
      duration: 1.2,
      easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
    });
    function raf(time) {
      lenis.raf(time);
      requestAnimationFrame(raf);
    }
    requestAnimationFrame(raf);

    // Three.js setup
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 100);
    const renderer = new THREE.WebGLRenderer({ antialias: true });
    renderer.setSize(window.innerWidth, window.innerHeight);
    renderer.setClearColor(document.documentElement.classList.contains('dark-mode') ? 0x121212 : 0x0a1c2e, 1);
    document.body.appendChild(renderer.domElement);

    // Lighting
    const ambientLight = new THREE.AmbientLight(0x404040, 1.5);
    const directionalLight = new THREE.DirectionalLight(document.documentElement.classList.contains('dark-mode') ? 0xbb86fc : 0x00e5ff, 1.2);
    directionalLight.position.set(2, 3, 4);
    scene.add(ambientLight, directionalLight);

    // Earth
    const geometry = new THREE.SphereGeometry(1.5, 64, 64);
    const textureLoader = new THREE.TextureLoader();
    const earthTexture = textureLoader.load(
      'https://threejs.org/examples/textures/planets/earth_atmos_2048.jpg',
      () => console.log('Earth texture loaded'),
      undefined,
      (err) => console.error('Earth texture load error:', err)
    );
    const material = new THREE.MeshStandardMaterial({
      map: earthTexture,
      emissive: 0x001122,
      metalness: 0.3,
      roughness: 0.7
    });
    const earth = new THREE.Mesh(geometry, material);
    scene.add(earth);
    earth.position.set(0, 0, 0);

    // Particles
    const particlesCount = 1000;
    const particlesGeometry = new THREE.BufferGeometry();
    const createCircleTexture = () => {
      const canvas = document.createElement('canvas');
      canvas.width = 64;
      canvas.height = 64;
      const context = canvas.getContext('2d');
      context.beginPath();
      context.arc(32, 32, 30, 0, Math.PI * 2);
      context.fillStyle = '#E0E0E0';
      context.fill();
      return new THREE.CanvasTexture(canvas);
    };
    const particlesMaterial = new THREE.PointsMaterial({
      color: 0xE0E0E0,
      size: 0.07,
      map: createCircleTexture(),
      transparent: true,
      opacity: 0.7,
      blending: THREE.AdditiveBlending,
    });
    const positions = new Float32Array(particlesCount * 3);
    const velocities = new Float32Array(particlesCount * 3);
    for (let i = 0; i < particlesCount * 3; i++) {
      positions[i] = (Math.random() - 0.5) * 20;
      velocities[i] = (Math.random() - 0.5) * 0.02;
    }
    particlesGeometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));
    const particles = new THREE.Points(particlesGeometry, particlesMaterial);
    scene.add(particles);

    // Mini-planets
    const planetCount = 8;
    const miniPlanets = [];
    const planetSizes = [0.15, 0.25, 0.18, 0.22, 0.16, 0.20, 0.19, 0.17];
    for (let i = 0; i < planetCount; i++) {
      const planetGeometry = new THREE.SphereGeometry(planetSizes[i], 16, 16);
      const planetMaterial = new THREE.MeshStandardMaterial({
        map: earthTexture,
        emissive: 0x001122,
        color: 0xffffff
      });
      const planet = new THREE.Mesh(planetGeometry, planetMaterial);
      const radius = 3 + i * 0.5;
      const angle = Math.random() * Math.PI * 2;
      planet.position.set(radius * Math.cos(angle), 0, radius * Math.sin(angle));
      planet.userData = { radius, angle, speed: 0.01 };
      scene.add(planet);
      miniPlanets.push(planet);
    }

    camera.position.z = 5;

    // Mouse interaction
    const raycaster = new THREE.Raycaster();
    const mouse = new THREE.Vector2();
    const mouse3D = new THREE.Vector3();
    let mousePlaneZ = -2;
    window.addEventListener('mousemove', (event) => {
      mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
      mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;
      raycaster.setFromCamera(mouse, camera);
      const direction = raycaster.ray.direction;
      const origin = raycaster.ray.origin;
      const t = (mousePlaneZ - origin.z) / direction.z;
      mouse3D.x = origin.x + t * direction.x;
      mouse3D.y = origin.y + t * direction.y;
      mouse3D.z = mousePlaneZ;
    });

    // GSAP animations
    gsap.registerPlugin(ScrollTrigger);

    // Header scroll
    let lastScroll = 0;
    lenis.on('scroll', ({ scroll }) => {
      const header = document.querySelector('.header');
      if (scroll > lastScroll && scroll > 100) {
        header.classList.remove('visible');
      } else if (scroll < lastScroll) {
        header.classList.add('visible');
      }
      lastScroll = scroll;
    });

    // Header animations
    gsap.from('.header .menu li', {
      opacity: 0,
      y: -20,
      stagger: 0.1,
      duration: 0.5,
      ease: 'power3.out',
      delay: 0.5
    });
    gsap.from('.header .language', {
      opacity: 0,
      scale: 0.5,
      duration: 0.5,
      ease: 'power3.out',
      delay: 0.8
    });
    gsap.from('.header .user-menu', {
      opacity: 0,
      scale: 0.5,
      duration: 0.5,
      ease: 'power3.out',
      delay: 1
    });

    // Hamburger menu toggle
    const hamburger = document.querySelector('.hamburger');
const mobileMenu = document.querySelector('.mobile-menu');
const exitMenu = document.querySelector('.exit-menu');

const toggleMobileMenu = (show) => {
  mobileMenu.classList.toggle('active', show);
  if (show) {
    gsap.fromTo('.mobile-menu.active ul li', {
      opacity: 0,
      y: 20
    }, {
      opacity: 1,
      y: 0,
      stagger: 0.1,
      duration: 0.5,
      ease: 'power3.out'
    });
    gsap.fromTo('.mobile-menu.active .language', {
      opacity: 0,
      scale: 0.5
    }, {
      opacity: 1,
      scale: 1,
      duration: 0.5,
      ease: 'power3.out',
      delay: 0.5
    });
    gsap.fromTo('.mobile-menu.active .user-menu', {
      opacity: 0,
      scale: 0.5
    }, {
      opacity: 1,
      scale: 1,
      duration: 0.5,
      ease: 'power3.out',
      delay: 0.7
    });
  }
};

hamburger.addEventListener('click', () => toggleMobileMenu(true));
exitMenu.addEventListener('click', () => toggleMobileMenu(false));

// Close dropdowns and mobile menu on outside click
document.addEventListener('click', (e) => {
  if (!e.target.closest('.language, .user-menu')) {
    document.querySelectorAll('.language-dropdown, .user-dropdown').forEach(d => d.classList.remove('active'));
  }
  if (!e.target.closest('.hamburger, .mobile-menu, .exit-menu')) {
    toggleMobileMenu(false);
  }
});

    // Dropdown toggle
    document.querySelectorAll('.language, .user-menu').forEach(menu => {
      menu.addEventListener('click', (e) => {
        e.stopPropagation();
        const dropdown = menu.querySelector('.language-dropdown, .user-dropdown');
        const isActive = dropdown.classList.contains('active');
        document.querySelectorAll('.language-dropdown, .user-dropdown').forEach(d => d.classList.remove('active'));
        if (!isActive) {
          dropdown.classList.add('active');
          gsap.fromTo(dropdown.querySelectorAll('li'), {
            opacity: 0,
            y: 10
          }, {
            opacity: 1,
            y: 0,
            stagger: 0.1,
            duration: 0.3,
            ease: 'power3.out'
          });
        }
      });
    });

    // Close dropdowns and mobile menu on outside click
    document.addEventListener('click', (e) => {
      if (!e.target.closest('.language, .user-menu')) {
        document.querySelectorAll('.language-dropdown, .user-dropdown').forEach(d => d.classList.remove('active'));
      }
      if (!e.target.closest('.hamburger, .mobile-menu')) {
        mobileMenu.classList.remove('active');
      }
    });

    // Banner animation
    gsap.fromTo('.banner h2', {
      opacity: 0,
      scale: 0.6,
      y: 50
    }, {
      opacity: 1,
      scale: 1.5,
      y: 0,
      duration: 2,
      ease: 'power3.out'
    });
    gsap.fromTo('.banner p', {
      opacity: 0,
      scale: 0.6,
      y: 50
    }, {
      opacity: 1,
      scale: 1.5,
      y: 0,
      duration: 2,
      delay: 0.3,
      ease: 'power3.out'
    });
    gsap.to('.banner h2', {
      y: -15,
      repeat: -1,
      yoyo: true,
      duration: 2.5,
      ease: 'sine.inOut'
    });

    // About animations
    gsap.fromTo('.about-image', {
      opacity: 0,
      scale: 0.8,
      rotate: -10
    }, {
      opacity: 1,
      scale: 1,
      rotate: -5,
      duration: 1.5,
      ease: 'power3.out',
      scrollTrigger: {
        trigger: '#about',
        start: 'top 80%',
        end: 'bottom 20%',
        scrub: true
      }
    });
    gsap.fromTo('.about-text', {
      opacity: 0,
      x: 100
    }, {
      opacity: 1,
      x: 20,
      duration: 1.5,
      ease: 'power3.out',
      scrollTrigger: {
        trigger: '#about',
        start: 'top 80%',
        end: 'top 20%',
        scrub: true
      }
    });

    // Features animations
    document.querySelectorAll('.feature-card').forEach((card, index) => {
      gsap.fromTo(card, {
        opacity: 0,
        y: 150,
        rotate: index % 2 === 0 ? -5 : 5
      }, {
        opacity: 1,
        y: 0,
        rotate: 0,
        duration: 1,
        delay: index * 0.2,
        ease: 'power3.out',
        scrollTrigger: {
          trigger: '#features',
          start: 'top 80%',
          end: 'top 20%',
          scrub: true
        }
      });
    });

    // Story animations
    document.querySelectorAll('.story-entry').forEach((entry, index) => {
      gsap.fromTo(entry, {
        opacity: 0,
        x: index % 2 === 0 ? -150 : 150,
        rotate: index % 2 === 0 ? -10 : 10
      }, {
        opacity: 1,
        x: 0,
        rotate: 0,
        duration: 1.5,
        ease: 'power3.out',
        scrollTrigger: {
          trigger: entry,
          start: 'top 80%',
          end: 'top 20%',
          scrub: true
        }
      });
    });

    // Join animation
    gsap.fromTo('.join-container', {
      opacity: 0,
      y: 150,
      scale: 0.9
    }, {
      opacity: 1,
      y: 0,
      scale: 1,
      duration: 1.5,
      ease: 'power3.out',
      scrollTrigger: {
        trigger: '#join',
        start: 'top 80%',
        end: 'top 20%',
        scrub: true
      }
    });

    // Footer animation
    gsap.fromTo('.footer', {
      opacity: 0,
      y: 100
    }, {
      opacity: 1,
      y: 0,
      duration: 1.5,
      ease: 'power3.out',
      scrollTrigger: {
        trigger: '#footer',
        start: 'top 90%',
        end: 'top 30%',
        scrub: true
      }
    });

    // Camera zoom
    gsap.to(camera.position, {
      z: 15,
      scrollTrigger: {
        trigger: 'body',
        start: 'top top',
        end: 'bottom bottom',
        scrub: true
      }
    });

    // Animation loop
    function animate() {
      requestAnimationFrame(animate);
      earth.rotation.y += 0.005;
      miniPlanets.forEach(planet => {
        planet.userData.angle += planet.userData.speed;
        planet.position.x = planet.userData.radius * Math.cos(planet.userData.angle);
        planet.position.z = planet.userData.radius * Math.sin(planet.userData.angle);
        planet.rotation.y += 0.01;
      });
      const posAttr = particlesGeometry.attributes.position;
      const attractionRadius = 3;
      const attractionStrength = 0.08;
      for (let i = 0; i < particlesCount; i++) {
        const x = posAttr.array[i * 3];
        const y = posAttr.array[i * 3 + 1];
        const z = posAttr.array[i * 3 + 2];
        const dx = mouse3D.x - x;
        const dy = mouse3D.y - y;
        const dz = mouse3D.z - z;
        const distance = Math.sqrt(dx * dx + dy * dy + dz * dz);
        if (distance < attractionRadius) {
          const force = attractionStrength * (1 - distance / attractionRadius);
          posAttr.array[i * 3] += dx * force;
          posAttr.array[i * 3 + 1] += dy * force;
          posAttr.array[i * 3 + 2] += dz * force;
        }
        posAttr.array[i * 3] += velocities[i * 3];
        posAttr.array[i * 3 + 1] += velocities[i * 3 + 1];
        posAttr.array[i * 3 + 2] += velocities[i * 3 + 2];
        if (Math.abs(posAttr.array[i * 3]) > 10 || Math.abs(posAttr.array[i * 3 + 1]) > 10 || Math.abs(posAttr.array[i * 3 + 2]) > 10) {
          posAttr.array[i * 3] = (Math.random() - 0.5) * 20;
          posAttr.array[i * 3 + 1] = (Math.random() - 0.5) * 20;
          posAttr.array[i * 3 + 2] = (Math.random() - 0.5) * 20;
        }
      }
      posAttr.needsUpdate = true;
      renderer.render(scene, camera);
    }
    animate();

    // Resize handling
    window.addEventListener('resize', () => {
      camera.aspect = window.innerWidth / window.innerHeight;
      camera.updateProjectionMatrix();
      renderer.setSize(window.innerWidth, window.innerHeight);
    });

    // Scroll progress
    lenis.on('scroll', ({ scroll, limit }) => {
      const progress = (scroll / limit) * 100;
      document.querySelector('.scroll-progress').style.width = `${progress}%`;
    });

    // Typed.js
    new Typed('#banner p', {
      strings: ['Đánh thức nhà sáng tạo trong bạn', 'Kể câu chuyện của bạn', 'Kết nối với thế giới'],
      typeSpeed: 50,
      backSpeed: 30,
      loop: true,
      startDelay: 1000
    });
  </script>
</body>
</html>
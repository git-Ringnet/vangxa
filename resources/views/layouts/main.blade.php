<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="icon" href="/image/ship.png" type="image/x-icon">
    @vite(['resources/css/main.css', 'resources/js/app.js', 'resources/css/leaderboard/leaderboard.css'])
    <link rel="stylesheet" href="{{ asset('community/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/filter.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Styles for the side menu */
        .main-layout {
            display: flex;
            min-height: 100vh;
            background-color: #faf6e9;
        }

        .sidemenu {
            width: 230px;
            background-color: #faf6e9;
            padding-top: 22px;
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
            z-index: 100;
            border-right: 1px solid rgba(122, 92, 46, 0.1);
        }

        .sidemenu-item {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: #5d4037;
            cursor: pointer;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
            text-decoration: none;
        }

        .sidemenu-item span {
            transition: all 0.2s ease;
        }

        .sidemenu-item.active {
            background-color: rgba(122, 92, 46, 0.1);
            border-left: 3px solid #7a5c2e;
            font-weight: 500;
            color: #7a5c2e;
        }

        .sidemenu-item.active span {
            color: #7a5c2e;
        }

        .sidemenu-item:hover {
            background-color: rgba(122, 92, 46, 0.05);
            color: #7a5c2e;
        }

        .sidemenu-item:hover svg path {
            stroke-opacity: 0.8;
        }

        .sidemenu-item:hover svg path[fill] {
            fill-opacity: 0.8;
        }

        .sidemenu-item i {
            margin-right: 12px;
            font-size: 18px;
            width: 24px;
            text-align: center;
        }

        .sidemenu-item svg {
            margin-right: 12px;
            width: 24px;
            text-align: center;
            transition: all 0.2s ease;
        }

        /* Change all SVG paths and strokes to highlight color when menu item is active */
        .sidemenu-item.active svg path {
            stroke: #7a5c2e !important;
            stroke-opacity: 1 !important;
            stroke-width: 2.5 !important;
        }

        .sidemenu-item.active svg path[fill] {
            fill: #7a5c2e !important;
            fill-opacity: 1 !important;
        }

        /* Override for SVG icons that use only fill and no stroke */
        .sidemenu-item.active svg path:not([stroke]) {
            fill: #7a5c2e !important;
            fill-opacity: 1 !important;
        }

        .main-content {
            margin-left: 230px;
            width: calc(100% - 230px);
            padding-top: 70px;
        }

        /* Mobile responsive */
        @media (max-width: 991px) {
            .sidemenu {
                display: none;
            }

            .main-content {
                margin-left: 0;
                width: 100%;
            }
        }
    </style>
    <!-- <style>
        /* Toast Notifications */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 10000;
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 350px;
        }
        .toast {
            padding: 15px;
            border-radius: 8px;
            color: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            opacity: 0;
            transform: translateX(20px);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .toast.show {
            opacity: 1;
            transform: translateX(0);
        }
        .toast-success {
            background-color: #4caf50;
        }
        .toast-error {
            background-color: #f44336;
        }
        .toast-warning {
            background-color: #ff9800;
        }
        .toast-info {
            background-color: #2196f3;
        }
        .toast-content {
            flex-grow: 1;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .toast-content i {
            font-size: 20px;
        }
        .toast-content span {
            word-break: break-word;
        }
        .toast-close {
            cursor: pointer;
            background: none;
            border: none;
            color: white;
            font-size: 20px;
            opacity: 0.8;
            padding: 0 5px;
        }
        .toast-close:hover {
            opacity: 1;
        }
        .toast-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            background-color: rgba(255, 255, 255, 0.4);
            width: 100%;
            transform-origin: left;
        }
    </style> -->
</head>
@stack('scripts')

<body data-user-id="{{ auth()->check() ? auth()->id() : '' }}">
    <div class="main-layout">
        <!-- Side Menu -->
        <div class="sidemenu">
                <!-- Logo -->
            <a href="/" class="navbar-brand p-3"
                    style="display: flex; align-items: center; text-decoration: none;">
                <svg width="38" height="39" viewBox="0 0 38 39" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M16.625 6.83244L14.25 7.31994C14.25 5.71296 14.5799 4.12403 15.2182 2.65666L15.2629 2.55372C15.3303 2.39876 15.5447 2.39876 15.6121 2.55372L15.8505 3.10179C16.3611 4.27572 16.625 5.54685 16.625 6.83244ZM11.875 17.0699C11.875 14.1449 8.70834 10.9762 7.125 9.75743L23.75 7.31994L23.8115 7.3409C25.0254 7.75481 27.5662 8.62112 28.5 13.4137C29.2125 17.0699 27.3125 21.5387 26.125 21.9449L7.125 25.6011C8.70834 24.3823 11.875 20.7262 11.875 17.0699ZM3.36727 29.0877C2.79469 29.1856 2.375 29.6941 2.375 30.2898V31.6948C2.375 34.3873 4.50165 36.5698 7.125 36.5698H21.375C29.245 36.5698 35.625 30.0222 35.625 21.9449V19.5074L34.4375 17.0699C35.0932 17.0699 35.625 16.5243 35.625 15.8512C35.625 15.1781 35.0932 14.6324 34.4375 14.6324H34.2912C33.6794 14.6324 33.146 15.0599 32.9975 15.6692L32.3857 18.1807C31.4683 21.9466 28.4618 24.7952 24.7311 25.4334L3.36727 29.0877Z"
                        fill="#7C4D28" />
                </svg>
                    <span
                    style="margin-left: 8px; font-size: 26px; font-weight: bold; color: #7C4D28; font-family: Verdana, sans-serif;">
                        Vangxa
                    </span>
                </a>
            <a href="{{ route('dining') }}" class="sidemenu-item p-3 {{ request()->is('dining') ? 'active' : '' }}">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M2.5 10.9384C2.5 9.71422 3.06058 8.55744 4.02142 7.79888L9.52142 3.45677C10.9747 2.30948 13.0253 2.30948 14.4786 3.45677L19.9786 7.79888C20.9394 8.55744 21.5 9.71422 21.5 10.9384V17.5C21.5 19.7091 19.7091 21.5 17.5 21.5H16C15.4477 21.5 15 21.0523 15 20.5V17.5C15 16.3954 14.1046 15.5 13 15.5H11C9.89543 15.5 9 16.3954 9 17.5V20.5C9 21.0523 8.55228 21.5 8 21.5H6.5C4.29086 21.5 2.5 19.7091 2.5 17.5L2.5 10.9384Z"
                        stroke="#3C3C3C" stroke-opacity="0.5" stroke-width="2" />
                </svg>
                <span class="pl-3 text-menu">Ăn uống</span>
            </a>
            <a href="{{ route('lodging') }}" class="sidemenu-item p-3 {{ request()->is('lodging') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none">
                    <path
                        d="M9.24805 16.1553H14.7471C15.3693 16.1554 15.9201 16.6608 15.9863 17.3525L15.9932 17.4932L15.9922 18.5049V18.5303C16.0437 19.545 15.7175 20.2409 15.1133 20.7031C14.4806 21.187 13.4716 21.4697 12.0645 21.4697C10.6637 21.4697 9.64562 21.1916 8.98926 20.709C8.35825 20.245 8.00195 19.5491 8.00195 18.5449V17.4932C8.00195 16.7305 8.58443 16.1554 9.24805 16.1553ZM9.24805 16.7266C9.06559 16.7266 8.89399 16.7933 8.76074 16.9082L8.70605 16.96C8.5679 17.1055 8.49512 17.298 8.49512 17.4932V18.5449C8.49512 19.307 8.78194 19.9464 9.44727 20.3613C10.0637 20.7456 10.9478 20.8994 12.0645 20.8994C13.1699 20.8994 14.043 20.7523 14.6406 20.3643C14.9514 20.1624 15.185 19.8972 15.3301 19.5693C15.4371 19.3274 15.4893 19.0668 15.501 18.7959L15.5 18.5225V17.4932C15.5 17.3467 15.4589 17.2017 15.3799 17.0771L15.2891 16.96L15.2344 16.9082C15.1011 16.7932 14.9295 16.7266 14.7471 16.7266H9.24805ZM20.2451 10.8945C20.8674 10.8945 21.4181 11.4001 21.4844 12.0918L21.4912 12.2324L21.4902 13.2441V13.2568L21.4912 13.2695C21.5427 14.2844 21.2158 14.9801 20.6113 15.4424C20.0076 15.9041 19.0619 16.1795 17.7539 16.2041C17.6757 16.0053 17.5798 15.8158 17.4678 15.6367C17.4994 15.637 17.5314 15.6387 17.5635 15.6387C18.669 15.6386 19.5421 15.4917 20.1396 15.1035C20.4505 14.9016 20.6841 14.6365 20.8291 14.3086C20.9685 13.9933 21.0131 13.6466 20.998 13.2861H20.999V12.2324C20.999 12.0859 20.9579 11.941 20.8789 11.8164L20.7871 11.6992L20.7324 11.6475C20.5992 11.5327 20.4274 11.4658 20.2451 11.4658H16.5C16.5007 11.2749 16.4909 11.0841 16.4697 10.8945H20.2451ZM3.75 10.8945H7.52539C7.50423 11.0842 7.49419 11.2749 7.49512 11.4658H3.75C3.56769 11.4658 3.39592 11.5327 3.2627 11.6475L3.20801 11.6992C3.06973 11.8447 2.99609 12.0371 2.99609 12.2324V13.2842C2.99609 14.0464 3.28357 14.6866 3.94922 15.1016C4.55822 15.481 5.42799 15.634 6.52539 15.6377C6.41406 15.8155 6.31905 16.0039 6.24121 16.2012C5.00666 16.1611 4.09477 15.8937 3.49023 15.4492C2.85922 14.9852 2.50391 14.2883 2.50391 13.2842V12.2324C2.50391 11.4697 3.08631 10.8945 3.75 10.8945ZM11.9971 8.79102C12.2401 8.79102 12.4823 8.82813 12.7148 8.90234L12.9443 8.98926C13.2452 9.12046 13.52 9.3135 13.7529 9.55859C13.9278 9.74262 14.0763 9.95312 14.1934 10.1836L14.2998 10.4199C14.4272 10.7437 14.4932 11.0916 14.4932 11.4434C14.4931 11.7951 14.4272 12.1431 14.2998 12.4668C14.1724 12.7905 13.9859 13.0829 13.7529 13.3281C13.5782 13.5119 13.3802 13.667 13.165 13.7881L12.9443 13.8975C12.6434 14.0286 12.3211 14.0957 11.9971 14.0957C11.4256 14.0956 10.8706 13.8866 10.4258 13.5029L10.2422 13.3281C9.77116 12.8324 9.50199 12.1549 9.50195 11.4434C9.50195 10.8205 9.70792 10.2236 10.0752 9.75195L10.2422 9.55859C10.7123 9.06387 11.3439 8.79115 11.9971 8.79102ZM11.9971 9.36133C11.7306 9.36139 11.4674 9.41681 11.2227 9.52344C10.9778 9.63016 10.757 9.78605 10.5723 9.98047C10.4337 10.1262 10.3167 10.2913 10.2256 10.4707L10.1436 10.6553C10.045 10.9058 9.99414 11.1736 9.99414 11.4434C9.99415 11.6458 10.0223 11.8473 10.0781 12.041L10.1436 12.2314C10.2422 12.4821 10.3876 12.7119 10.5723 12.9062C10.7108 13.052 10.8699 13.1755 11.0439 13.2734L11.2227 13.3633C11.4673 13.4699 11.7306 13.5253 11.9971 13.5254C12.5368 13.5254 13.0494 13.2992 13.4229 12.9062C13.7955 12.5141 14.0009 11.9874 14.001 11.4434C14.001 10.9673 13.8435 10.5047 13.5547 10.1338L13.4229 9.98047C13.0494 9.58746 12.5369 9.36133 11.9971 9.36133ZM6.49902 3.53027C7.07081 3.5303 7.62632 3.73912 8.07129 4.12305L8.25488 4.29785C8.72582 4.79355 8.99412 5.47114 8.99414 6.18262C8.99414 6.89408 8.72579 7.57168 8.25488 8.06738C7.78468 8.56221 7.15232 8.83493 6.49902 8.83496C5.92722 8.83496 5.37175 8.6261 4.92676 8.24219L4.74316 8.06738C4.27218 7.57166 4.00293 6.89414 4.00293 6.18262C4.00294 5.56008 4.20923 4.96367 4.57617 4.49219L4.74316 4.29785C5.15454 3.86493 5.68988 3.60203 6.25488 3.54297L6.49902 3.53027ZM17.4961 3.53027C18.0679 3.53027 18.6234 3.73917 19.0684 4.12305L19.252 4.29785C19.723 4.79356 19.9922 5.47109 19.9922 6.18262C19.9922 6.89414 19.7229 7.57167 19.252 8.06738C18.7817 8.56224 18.1494 8.83496 17.4961 8.83496C16.8428 8.83493 16.2104 8.56221 15.7402 8.06738C15.2693 7.57168 15.001 6.89409 15.001 6.18262C15.001 5.56013 15.2064 4.96365 15.5732 4.49219L15.7402 4.29785C16.2104 3.80302 16.8428 3.5303 17.4961 3.53027ZM6.49902 4.10059C6.02673 4.10059 5.57532 4.27362 5.21973 4.58008L5.07324 4.71973C4.70063 5.11186 4.49611 5.63858 4.49609 6.18262C4.49609 6.65858 4.65261 7.12127 4.94141 7.49219L5.07324 7.64551C5.44672 8.03854 5.95919 8.26465 6.49902 8.26465C6.97136 8.26462 7.42273 8.0917 7.77832 7.78516L7.9248 7.64551C8.29731 7.25337 8.50195 6.72659 8.50195 6.18262C8.50194 5.70669 8.3454 5.24394 8.05664 4.87305L7.9248 4.71973C7.55136 4.32673 7.03882 4.10062 6.49902 4.10059ZM17.4961 4.10059C17.0238 4.10061 16.5724 4.27357 16.2168 4.58008L16.0703 4.71973C15.6978 5.11185 15.4932 5.63864 15.4932 6.18262C15.4932 6.65854 15.6497 7.12129 15.9385 7.49219L16.0703 7.64551C16.4438 8.03851 16.9563 8.26462 17.4961 8.26465C17.9684 8.26465 18.4198 8.09166 18.7754 7.78516L18.9219 7.64551C19.2945 7.25336 19.499 6.72664 19.499 6.18262C19.499 5.70664 19.3425 5.24396 19.0537 4.87305L18.9219 4.71973C18.5484 4.3267 18.0359 4.10059 17.4961 4.10059Z"
                        stroke="#3C3C3C" stroke-opacity="0.5" stroke-width="1.0073" />
                </svg>
                <span class="pl-3 text-menu">Ở</span>
            </a>
                    <a href="{{ route('groupss.index') }}"
                class="sidemenu-item p-3 {{ request()->routeIs('groupss.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none">
                    <path
                        d="M9.24805 16.1553H14.7471C15.3693 16.1554 15.9201 16.6608 15.9863 17.3525L15.9932 17.4932L15.9922 18.5049V18.5303C16.0437 19.545 15.7175 20.2409 15.1133 20.7031C14.4806 21.187 13.4716 21.4697 12.0645 21.4697C10.6637 21.4697 9.64562 21.1916 8.98926 20.709C8.35825 20.245 8.00195 19.5491 8.00195 18.5449V17.4932C8.00195 16.7305 8.58443 16.1554 9.24805 16.1553ZM9.24805 16.7266C9.06559 16.7266 8.89399 16.7933 8.76074 16.9082L8.70605 16.96C8.5679 17.1055 8.49512 17.298 8.49512 17.4932V18.5449C8.49512 19.307 8.78194 19.9464 9.44727 20.3613C10.0637 20.7456 10.9478 20.8994 12.0645 20.8994C13.1699 20.8994 14.043 20.7523 14.6406 20.3643C14.9514 20.1624 15.185 19.8972 15.3301 19.5693C15.4371 19.3274 15.4893 19.0668 15.501 18.7959L15.5 18.5225V17.4932C15.5 17.3467 15.4589 17.2017 15.3799 17.0771L15.2891 16.96L15.2344 16.9082C15.1011 16.7932 14.9295 16.7266 14.7471 16.7266H9.24805ZM20.2451 10.8945C20.8674 10.8945 21.4181 11.4001 21.4844 12.0918L21.4912 12.2324L21.4902 13.2441V13.2568L21.4912 13.2695C21.5427 14.2844 21.2158 14.9801 20.6113 15.4424C20.0076 15.9041 19.0619 16.1795 17.7539 16.2041C17.6757 16.0053 17.5798 15.8158 17.4678 15.6367C17.4994 15.637 17.5314 15.6387 17.5635 15.6387C18.669 15.6386 19.5421 15.4917 20.1396 15.1035C20.4505 14.9016 20.6841 14.6365 20.8291 14.3086C20.9685 13.9933 21.0131 13.6466 20.998 13.2861H20.999V12.2324C20.999 12.0859 20.9579 11.941 20.8789 11.8164L20.7871 11.6992L20.7324 11.6475C20.5992 11.5327 20.4274 11.4658 20.2451 11.4658H16.5C16.5007 11.2749 16.4909 11.0841 16.4697 10.8945H20.2451ZM3.75 10.8945H7.52539C7.50423 11.0842 7.49419 11.2749 7.49512 11.4658H3.75C3.56769 11.4658 3.39592 11.5327 3.2627 11.6475L3.20801 11.6992C3.06973 11.8447 2.99609 12.0371 2.99609 12.2324V13.2842C2.99609 14.0464 3.28357 14.6866 3.94922 15.1016C4.55822 15.481 5.42799 15.634 6.52539 15.6377C6.41406 15.8155 6.31905 16.0039 6.24121 16.2012C5.00666 16.1611 4.09477 15.8937 3.49023 15.4492C2.85922 14.9852 2.50391 14.2883 2.50391 13.2842V12.2324C2.50391 11.4697 3.08631 10.8945 3.75 10.8945ZM11.9971 8.79102C12.2401 8.79102 12.4823 8.82813 12.7148 8.90234L12.9443 8.98926C13.2452 9.12046 13.52 9.3135 13.7529 9.55859C13.9278 9.74262 14.0763 9.95312 14.1934 10.1836L14.2998 10.4199C14.4272 10.7437 14.4932 11.0916 14.4932 11.4434C14.4931 11.7951 14.4272 12.1431 14.2998 12.4668C14.1724 12.7905 13.9859 13.0829 13.7529 13.3281C13.5782 13.5119 13.3802 13.667 13.165 13.7881L12.9443 13.8975C12.6434 14.0286 12.3211 14.0957 11.9971 14.0957C11.4256 14.0956 10.8706 13.8866 10.4258 13.5029L10.2422 13.3281C9.77116 12.8324 9.50199 12.1549 9.50195 11.4434C9.50195 10.8205 9.70792 10.2236 10.0752 9.75195L10.2422 9.55859C10.7123 9.06387 11.3439 8.79115 11.9971 8.79102ZM11.9971 9.36133C11.7306 9.36139 11.4674 9.41681 11.2227 9.52344C10.9778 9.63016 10.757 9.78605 10.5723 9.98047C10.4337 10.1262 10.3167 10.2913 10.2256 10.4707L10.1436 10.6553C10.045 10.9058 9.99414 11.1736 9.99414 11.4434C9.99415 11.6458 10.0223 11.8473 10.0781 12.041L10.1436 12.2314C10.2422 12.4821 10.3876 12.7119 10.5723 12.9062C10.7108 13.052 10.8699 13.1755 11.0439 13.2734L11.2227 13.3633C11.4673 13.4699 11.7306 13.5253 11.9971 13.5254C12.5368 13.5254 13.0494 13.2992 13.4229 12.9062C13.7955 12.5141 14.0009 11.9874 14.001 11.4434C14.001 10.9673 13.8435 10.5047 13.5547 10.1338L13.4229 9.98047C13.0494 9.58746 12.5369 9.36133 11.9971 9.36133ZM6.49902 3.53027C7.07081 3.5303 7.62632 3.73912 8.07129 4.12305L8.25488 4.29785C8.72582 4.79355 8.99412 5.47114 8.99414 6.18262C8.99414 6.89408 8.72579 7.57168 8.25488 8.06738C7.78468 8.56221 7.15232 8.83493 6.49902 8.83496C5.92722 8.83496 5.37175 8.6261 4.92676 8.24219L4.74316 8.06738C4.27218 7.57166 4.00293 6.89414 4.00293 6.18262C4.00294 5.56008 4.20923 4.96367 4.57617 4.49219L4.74316 4.29785C5.15454 3.86493 5.68988 3.60203 6.25488 3.54297L6.49902 3.53027ZM17.4961 3.53027C18.0679 3.53027 18.6234 3.73917 19.0684 4.12305L19.252 4.29785C19.723 4.79356 19.9922 5.47109 19.9922 6.18262C19.9922 6.89414 19.7229 7.57167 19.252 8.06738C18.7817 8.56224 18.1494 8.83496 17.4961 8.83496C16.8428 8.83493 16.2104 8.56221 15.7402 8.06738C15.2693 7.57168 15.001 6.89409 15.001 6.18262C15.001 5.56013 15.2064 4.96365 15.5732 4.49219L15.7402 4.29785C16.2104 3.80302 16.8428 3.5303 17.4961 3.53027ZM6.49902 4.10059C6.02673 4.10059 5.57532 4.27362 5.21973 4.58008L5.07324 4.71973C4.70063 5.11186 4.49611 5.63858 4.49609 6.18262C4.49609 6.65858 4.65261 7.12127 4.94141 7.49219L5.07324 7.64551C5.44672 8.03854 5.95919 8.26465 6.49902 8.26465C6.97136 8.26462 7.42273 8.0917 7.77832 7.78516L7.9248 7.64551C8.29731 7.25337 8.50195 6.72659 8.50195 6.18262C8.50194 5.70669 8.3454 5.24394 8.05664 4.87305L7.9248 4.71973C7.55136 4.32673 7.03882 4.10062 6.49902 4.10059ZM17.4961 4.10059C17.0238 4.10061 16.5724 4.27357 16.2168 4.58008L16.0703 4.71973C15.6978 5.11185 15.4932 5.63864 15.4932 6.18262C15.4932 6.65854 15.6497 7.12129 15.9385 7.49219L16.0703 7.64551C16.4438 8.03851 16.9563 8.26462 17.4961 8.26465C17.9684 8.26465 18.4198 8.09166 18.7754 7.78516L18.9219 7.64551C19.2945 7.25336 19.499 6.72664 19.499 6.18262C19.499 5.70664 19.3425 5.24396 19.0537 4.87305L18.9219 4.71973C18.5484 4.3267 18.0359 4.10059 17.4961 4.10059Z"
                        stroke="#3C3C3C" stroke-opacity="0.5" stroke-width="1.0073" />
                </svg>
                <span class="pl-3 text-menu">Cộng đồng</span>
            </a>
            <a href="#" class="sidemenu-item p-3">
                        <x-notifications :notifications="auth()->user()->notifications ?? []" />
            </a>
            <a href="#" class="sidemenu-item menu-button p-3">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
                        stroke="#3C3C3C" stroke-opacity="0.5" stroke-width="2" />
                    <path
                        d="M10.5856 14.6146C9.63 14.2805 8.82351 13.619 8.309 12.7472C7.79449 11.8754 7.60517 10.8497 7.77459 9.85166C7.94401 8.85365 8.46122 7.94783 9.23459 7.29468C10.008 6.64152 10.9876 6.2832 11.9999 6.2832C13.0121 6.2832 13.9917 6.64152 14.7651 7.29468C15.5385 7.94783 16.0557 8.85365 16.2251 9.85166C16.3945 10.8497 16.2052 11.8754 15.6907 12.7472C15.1762 13.619 14.3697 14.2805 13.4141 14.6146M12.9641 14.6217H13.4284C16.0641 15.0574 18.2856 16.7003 19.5284 18.9646M4.58557 18.7717C5.21771 17.6832 6.08166 16.7471 7.11612 16.0299C8.15058 15.3127 9.3302 14.8319 10.5713 14.6217H11.0141"
                        stroke="#3C3C3C" stroke-opacity="0.5" stroke-width="2" />
                </svg>
                <span class="pl-3 text-menu">Tôi</span>
            </a>
                    <div class="user-menu">
                        <div class="dropdown-menu" id="userDropdown">
                            @auth
                                <div class="dropdown-section">
                                    <a href="{{ route('profile') }}" class="dropdown-item"><strong>Hồ sơ</strong></a>
                                    <a href="{{ route('trustlist') }}" class="dropdown-item">Danh sách đáng tin cậy</a>
                                </div>
                                <div class="dropdown-section">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Đăng xuất</button>
                                    </form>
                                </div>
                            @else
                                <div class="dropdown-section">
                                    <a href="{{ route('register') }}" class="dropdown-item"><strong>Đăng ký</strong></a>
                                    <a href="{{ route('login') }}" class="dropdown-item">Đăng nhập</a>
                                </div>
                            @endauth
                </div>
            </div>
            <div class="position-absolute bottom-0 w-100">
                <a href="#" class="sidemenu-item p-3">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M10.7143 3.60103L9.42857 3.90492C9.42857 2.90318 9.60716 1.91267 9.95269 0.997945L9.97693 0.933778C10.0134 0.837178 10.1294 0.837178 10.1659 0.933778L10.295 1.27543C10.5714 2.00723 10.7143 2.79962 10.7143 3.60103ZM8.14286 9.98285C8.14286 8.15947 6.42858 6.18415 5.57143 5.42441L14.5714 3.90492L14.6047 3.91799C15.2619 4.17602 16.6373 4.71605 17.1429 7.70363C17.5286 9.98285 16.5 12.7686 15.8571 13.0218L5.57143 15.301C6.42858 14.5412 8.14286 12.2621 8.14286 9.98285ZM3.53717 17.4744C3.2272 17.5355 3 17.8525 3 18.2238V19.0997C3 20.7781 4.15127 22.1386 5.57143 22.1386H13.2857C17.5462 22.1386 21 18.057 21 13.0218V11.5023L20.3571 9.98285C20.7121 9.98285 21 9.6427 21 9.22311C21 8.8035 20.7121 8.46337 20.3571 8.46337H20.2779C19.9467 8.46337 19.658 8.72984 19.5776 9.10968L19.2464 10.6753C18.7497 13.0228 17.1222 14.7986 15.1026 15.1964L3.53717 17.4744Z"
                            fill="#3C3C3C" fill-opacity="0.5" />
                    </svg>
                    <span class="pl-3 text-menu">Về Vangxa</span>
                </a>
                <a href="#" class="sidemenu-item p-3">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 17H19M5 12H19M5 7H19" stroke="#3C3C3C" stroke-opacity="0.5" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span class="pl-3 text-menu">Khác</span>
                </a>
            </div>
        </div>

    <main class="main-content">
        @yield('content')
    </main>
    </div>

    @stack('scripts')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/like-handler.js') }}"></script>
    <script src="{{ asset('js/trustlist-handler.js') }}"></script>
    <script src="{{ asset('js/comment-handler.js') }}"></script>

    <script>
        // Rankings Modal Control
        document.addEventListener('DOMContentLoaded', function() {
            const rankingLink = document.getElementById('rankingLink');
            const rankingsModal = document.getElementById('rankingsModal');
            const closeRankingsBtn = document.getElementById('closeRankingsBtn');

            if (rankingLink && rankingsModal && closeRankingsBtn) {
                rankingLink.addEventListener('click', (e) => {
                    e.preventDefault();
                    rankingsModal.classList.add('show');
                    document.body.style.overflow = 'hidden';
                });

                const closeRankings = () => {
                    rankingsModal.classList.remove('show');
                    document.body.style.overflow = '';
                };

                closeRankingsBtn.addEventListener('click', closeRankings);

                rankingsModal.addEventListener('click', (e) => {
                    if (e.target === rankingsModal) {
                        closeRankings();
                    }
                });

                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape' && rankingsModal.classList.contains('show')) {
                        closeRankings();
                    }
                });
            }
        });

        // Toast notification function
        function showToast(message, type = 'success') {
            // Create toast element
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;

            // Create toast content
            const toastContent = document.createElement('div');
            toastContent.className = 'toast-content';

            // Add icon based on type
            const icon = document.createElement('i');
            if (type === 'success') {
                icon.className = 'fas fa-check-circle';
            } else if (type === 'error') {
                icon.className = 'fas fa-exclamation-circle';
            } else if (type === 'warning') {
                icon.className = 'fas fa-exclamation-triangle';
            } else if (type === 'info') {
                icon.className = 'fas fa-info-circle';
            }
            toastContent.appendChild(icon);

            // Add message
            const messageSpan = document.createElement('span');
            messageSpan.textContent = message;
            toastContent.appendChild(messageSpan);

            toast.appendChild(toastContent);

            // Add close button
            const closeBtn = document.createElement('button');
            closeBtn.className = 'toast-close';
            closeBtn.innerHTML = '<i class="fas fa-times"></i>';
            closeBtn.addEventListener('click', () => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 300);
            });
            toast.appendChild(closeBtn);

            // Add toast to container
            const toastContainer = document.querySelector('.toast-container') || (() => {
                const container = document.createElement('div');
                container.className = 'toast-container';
                document.body.appendChild(container);
                return container;
            })();

            toastContainer.appendChild(toast);

            // Show toast
            setTimeout(() => toast.classList.add('show'), 100);

            // Remove toast after 5 seconds
            const timeoutId = setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 300);
            }, 50000);

            // Cancel timeout if close button is clicked
            closeBtn.addEventListener('click', () => {
                clearTimeout(timeoutId);
            });
        }

        // Hàm gửi sự kiện thăng hạng
        function dispatchTierUpgradeEvent(data) {
            const event = new CustomEvent('tierUpgrade', {
                detail: data
            });
            document.dispatchEvent(event);
        }

        // Override fetch để xử lý thông báo thăng hạng
        const originalFetch = window.fetch;
        window.fetch = async function(...args) {
            const response = await originalFetch(...args);
            const clone = response.clone();

            try {
                const data = await clone.json();
                if (data.tier_upgrade && data.tier_upgrade.upgraded) {
                    dispatchTierUpgradeEvent(data.tier_upgrade);
                }
            } catch (e) {
                console.error('Error parsing JSON:', e);
            }

            return response;
        };

        document.addEventListener('DOMContentLoaded', function() {
            // Kiểm tra thăng hạng từ session
            @if (session('tier_upgrade'))
                showTierUpgradeAnimation(@json(session('tier_upgrade')));
            @endif

            // Hàm hiển thị thông báo thăng hạng
            function showTierUpgradeAnimation(data) {
                // Tạo modal thông báo
                const modal = document.createElement('div');
                modal.className = 'tier-upgrade-modal';
                modal.innerHTML = `
                    <div class="tier-upgrade-content">
                        <div class="tier-upgrade-icon" style="color: ${data.color}">${data.icon}</div>
                        <h3>Chúc mừng!</h3>
                        <p>Bạn đã đạt hạng ${data.new_tier}</p>
                        <p>Với ${data.points} điểm trong tháng này</p>
                        <button class="close-tier-upgrade">Đóng</button>
                    </div>
                `;

                document.body.appendChild(modal);

                // Thêm animation
                setTimeout(() => {
                    modal.classList.add('show');
                }, 100);

                // Xử lý đóng modal
                modal.querySelector('.close-tier-upgrade').addEventListener('click', () => {
                    modal.classList.remove('show');
                    setTimeout(() => {
                        modal.remove();
                    }, 300);
                });
            }

            // Xử lý thông báo thăng hạng từ AJAX response
            document.addEventListener('tierUpgrade', function(e) {
                if (e.detail && e.detail.upgraded) {
                    showTierUpgradeAnimation(e.detail);
                }
            });
        });
    </script>

    @auth
        @if (!auth()->user()->phone)
            <x-register-popup />

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    window.dispatchEvent(new CustomEvent('open-register-popup'));
                });
            </script>
        @endif
    @endauth

    <footer>
        <script src="{{ asset('js/filter.js') }}"></script>
    </footer>
</body>

</html>

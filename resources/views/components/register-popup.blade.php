@props(['show' => false])

<div x-data="registerForm"
     x-show="isOpen"
     @open-register-popup.window="isOpen = true"
     @close-register-popup.window="isOpen = false"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 overflow-y-auto"
     style="z-index: 9999;">

    <div class="flex items-center justify-center min-h-screen px-4">
        <!-- Overlay -->
        <div class="fixed inset-0 bg-black" style="opacity: 0.7; z-index: 9999;"></div>
        <!-- Popup content -->
        <div class="relative bg-white rounded-lg w-full max-w-md p-8" style="z-index: 10000;">
            <div class="popup-header">
                <div class="popup-logo">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-blue-500">
                        <path
                            d="M20.94,15.54a11.74,11.74,0,0,0,.44-3.15c0-.45,0-.89-.07-1.33a1.52,1.52,0,0,0-3-.26h0l-.26,1.67h0l-.14.86a.61.61,0,0,1-.58.5.62.62,0,0,1-.58-.5l-.12-.85h0L16.3,10.8a1.52,1.52,0,0,0-3,.26c0,.44-.06.88-.06,1.33a11.74,11.74,0,0,0,.44,3.15,1.77,1.77,0,0,0,2.44,1.08l1.67-.86,1.67.86A1.77,1.77,0,0,0,20.94,15.54Z"
                            fill="currentColor" />
                        <path
                            d="M14.77,14.12a3.88,3.88,0,0,1-1.65.62,4.19,4.19,0,0,1-.73.06,4.36,4.36,0,0,1-1-.13L5,13.05V21a1,1,0,0,0,1,1H18a1,1,0,0,0,1-1V11.89Z"
                            fill="currentColor" />
                        <path
                            d="M6,12.05l6.3,1.61a2.33,2.33,0,0,0,.54.07,2.42,2.42,0,0,0,1.17-.3l4-2.22V3a1,1,0,0,0-1-1H6A1,1,0,0,0,5,3v9A.34.34,0,0,0,6,12.05Z"
                            fill="currentColor" />
                    </svg>
                    <span class="text-2xl font-bold text-blue-500">Vangxa</span>
                </div>
            </div>

            <p class="text-center text-gray-600 mb-6">
                Bạn là 1 trong 25 người tự tế đầu tiên gia nhập hành trình của Vangxa. Bạn cho Vangxa biết thêm một chút
                về bạn nhé. Vangxa rất cảm ơn bạn.
            </p>

            <form @submit.prevent="submitForm" id="register-popup-form">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Họ và tên <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               x-model="formData.name"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="Cho Vangxa biết Họ và tên của bạn nhé..."
                               required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Số điện thoại / Zalo <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               x-model="formData.phone"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="Cho Vangxa biết Số điện thoại / Zalo của bạn nhé..."
                               required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Làm sao bạn biết đến Vangxa vậy?
                        </label>
                        <input type="text"
                               x-model="formData.referral_source"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="Tụi mình tò mò xíu, bạn biết đến Vangxa từ đâu ha...">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Bạn muốn trải nghiệm điều gì tại Vangxa
                        </label>
                        <textarea
                            x-model="formData.experience_expectation"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Bạn nghĩ Vangxa là đang tìm kiếm trải nghiệm gì đó hay họ phải không? Kể cho tụi mình nghe nhé..."></textarea>
                    </div>
                </div>

                <button type="submit"
                    class="mt-6 w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    TIẾP TỤC
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('registerForm', () => ({
            isOpen: false,
            formData: {
                name: '{{ auth()->user()->name ?? "" }}',
                phone: '',
                referral_source: '',
                experience_expectation: ''
            },
            submitForm() {
                fetch('{{ route('register-popup') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify(this.formData)
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Thành công:', data);
                    this.isOpen = false;
                    showToast('Xác nhận thành công', 'success');
                })
                .catch(error => {
                    console.error('Lỗi:', error);
                    showToast('Có lỗi xảy ra khi thực hiện thao tác này', 'error');
                });
            }
        }))
    });
</script>

<style>
    /* Reset một số style mặc định của Tailwind để phù hợp với thiết kế */
    .fixed.inset-0.z-50.overflow-y-auto {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    }

    /* Style cho overlay */
    .fixed.inset-0.bg-black {
        opacity: 0.7;
    }

    /* Style cho khung popup */
    .relative.bg-white.rounded-lg {
        width: 100%;
        max-width: 520px;
        padding: 25px;
        border-radius: 8px;
        border: 1px solid #1877f2;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    /* Style cho phần header và logo */
    .popup-header {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 15px;
    }

    .popup-logo {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        margin-bottom: 1rem;
    }

    .popup-logo svg {
        width: 40px;
        height: 40px;
        color: #1877f2;
    }

    .popup-logo span {
        font-size: 28px;
        font-weight: bold;
        color: #1877f2;
    }

    /* Style cho đoạn text giới thiệu */
    .text-center.text-gray-600.mb-6 {
        font-size: 15px;
        line-height: 1.4;
        color: #333;
        margin-bottom: 20px;
    }

    /* Style cho form và các input */
    form .space-y-4 {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    /* Style cho label */
    .block.text-sm.font-medium.text-gray-700 {
        display: flex;
        align-items: center;
        font-size: 15px;
        font-weight: 500;
        margin-bottom: 6px;
        color: #333;
    }

    /* Style cho dấu sao bắt buộc */
    .text-red-500 {
        color: #ff4d4f;
        margin-left: 5px;
    }

    /* Style cho input */
    input[type="text"],
    textarea {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #d9d9d9;
        border-radius: 5px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    textarea {
        height: 80px;
        resize: none;
    }

    input[type="text"]:focus,
    textarea:focus {
        outline: none;
        border-color: #1877f2;
        box-shadow: 0 0 0 2px rgba(24, 119, 242, 0.2);
    }

    input[type="text"]::placeholder,
    textarea::placeholder {
        color: #aaa;
    }

    /* Style cho nút submit */
    button[type="submit"] {
        display: block;
        width: 200px;
        margin: 20px auto 0;
        background-color: #1877f2;
        color: white;
        font-size: 15px;
        font-weight: bold;
        padding: 10px 0;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
        text-align: center;
    }

    button[type="submit"]:hover {
        background-color: #166fe5;
    }

    /* Style cho nút đóng popup */
    .absolute.top-4.right-4 {
        background: none;
        border: none;
        cursor: pointer;
        color: #999;
        transition: color 0.3s;
    }

    .absolute.top-4.right-4:hover {
        color: #333;
    }

    /* Responsive styles */
    @media (max-width: 640px) {
        .relative.bg-white.rounded-lg {
            padding: 20px;
        }

        button[type="submit"] {
            width: 100%;
        }
    }
</style>
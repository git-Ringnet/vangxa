// /**
//  * Hiển thị thông báo toast
//  * 
//  * @param {string} message Nội dung thông báo
//  * @param {string} type Loại thông báo: success, error, warning, info
//  * @param {number} duration Thời gian hiển thị (ms)
//  */
// function showToast(message, type = 'success', duration = 3000) {
//     // Tạo style CSS cho toast container nếu chưa có
//     if (!document.getElementById('toast-styles')) {
//         const style = document.createElement('style');
//         style.id = 'toast-styles';
//         style.textContent = `
//             .toast-container {
//                 position: fixed;
//                 top: 20px;
//                 right: 20px;
//                 z-index: 9999;
//                 display: flex;
//                 flex-direction: column;
//                 gap: 10px;
//                 max-width: 350px;
//             }
//             .toast {
//                 padding: 15px;
//                 border-radius: 5px;
//                 color: #fff;
//                 box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
//                 display: flex;
//                 align-items: center;
//                 opacity: 0;
//                 transform: translateX(20px);
//                 transition: all 0.3s ease;
//                 position: relative;
//                 overflow: hidden;
//             }
//             .toast.show {
//                 opacity: 1;
//                 transform: translateX(0);
//             }
//             .toast-success {
//                 background-color: #4caf50;
//             }
//             .toast-error {
//                 background-color: #f44336;
//             }
//             .toast-warning {
//                 background-color: #ff9800;
//             }
//             .toast-info {
//                 background-color: #2196f3;
//             }
//             .toast-message {
//                 flex-grow: 1;
//                 margin-left: 10px;
//                 word-break: break-word;
//             }
//             .toast-close {
//                 cursor: pointer;
//                 margin-left: 10px;
//                 opacity: 0.8;
//             }
//             .toast-close:hover {
//                 opacity: 1;
//             }
//             .toast-progress {
//                 position: absolute;
//                 bottom: 0;
//                 left: 0;
//                 height: 3px;
//                 background-color: rgba(255, 255, 255, 0.4);
//                 width: 100%;
//                 transform-origin: left;
//             }
//         `;
//         document.head.appendChild(style);
//     }
    
//     // Tạo container nếu chưa có
//     let container = document.querySelector('.toast-container');
//     if (!container) {
//         container = document.createElement('div');
//         container.className = 'toast-container';
//         document.body.appendChild(container);
//     }
    
//     // Tạo toast
//     const toast = document.createElement('div');
//     toast.className = `toast toast-${type}`;
    
//     // Icon dựa vào loại
//     let iconSvg = '';
//     switch (type) {
//         case 'success':
//             iconSvg = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>';
//             break;
//         case 'error':
//             iconSvg = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>';
//             break;
//         case 'warning':
//             iconSvg = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>';
//             break;
//         case 'info':
//             iconSvg = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>';
//             break;
//     }
    
//     // Tạo nội dung toast
//     toast.innerHTML = `
//         ${iconSvg}
//         <div class="toast-message">${message}</div>
//         <div class="toast-close">×</div>
//         <div class="toast-progress"></div>
//     `;
    
//     // Thêm vào container
//     container.appendChild(toast);
    
//     // Hiệu ứng hiện toast
//     setTimeout(() => {
//         toast.classList.add('show');
//     }, 10);
    
//     // Animation thanh progress
//     const progress = toast.querySelector('.toast-progress');
//     progress.style.transition = `transform ${duration}ms linear`;
//     progress.style.transform = 'scaleX(0)';
    
//     // Sự kiện đóng toast khi click
//     toast.querySelector('.toast-close').addEventListener('click', () => {
//         removeToast(toast);
//     });
    
//     // Tự động đóng sau khoảng thời gian
//     const timeoutId = setTimeout(() => {
//         removeToast(toast);
//     }, duration);
    
//     // Hàm xóa toast
//     function removeToast(toastElement) {
//         toastElement.classList.remove('show');
//         setTimeout(() => {
//             toastElement.remove();
//             if (container.children.length === 0) {
//                 container.remove();
//             }
//         }, 300);
//     }
    
//     return toast;
// } 
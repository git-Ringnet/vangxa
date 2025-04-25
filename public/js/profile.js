// Avatar cropper functionality
document.addEventListener('DOMContentLoaded', function() {
    // Khởi tạo các biến
    let cropper;
    const avatar = document.getElementById('avatar');
    const cropperImage = document.getElementById('cropperImage');
    const cropContainer = document.querySelector('.crop-container');
    const avatarForm = document.getElementById('avatarForm');
    const croppedAvatarInput = document.getElementById('croppedAvatar');
    const saveAvatarBtn = document.getElementById('saveAvatar');
    const resetFileBtn = document.getElementById('resetFileInput');

    if (!avatar) return; // Tránh lỗi nếu không tìm thấy các phần tử

    // Reset input file
    resetFileBtn.addEventListener('click', function() {
        avatar.value = '';
        if (cropper) {
            cropper.destroy();
            cropper = null;
            cropContainer.style.display = 'none';
            saveAvatarBtn.disabled = true;
        }
    });

    // Sự kiện khi chọn file ảnh
    avatar.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Xóa cropper cũ nếu có
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }

            const reader = new FileReader();
            reader.onload = function(event) {
                cropperImage.src = event.target.result;
                cropContainer.style.display = 'block';
                saveAvatarBtn.disabled = false;

                // Khởi tạo Cropper sau khi ảnh đã load
                cropperImage.onload = function() {
                    const maxWidth = window.innerWidth < 768 ? window.innerWidth - 40 : 800;

                    cropper = new Cropper(cropperImage, {
                        aspectRatio: 1, // Tỷ lệ khung hình 1:1 (hình vuông)
                        viewMode: 1, // Hạn chế khung nhìn bên trong canvas
                        preview: '#avatarPreview', // Hiển thị xem trước
                        dragMode: 'move', // Cho phép di chuyển ảnh
                        autoCropArea: 0.8, // Kích thước ban đầu của vùng cắt (0-1)
                        responsive: true,
                        restore: false,
                        guides: true,
                        center: true,
                        highlight: true,
                        cropBoxMovable: true,
                        cropBoxResizable: true,
                        toggleDragModeOnDblclick: true,
                        minContainerWidth: 250,
                        minContainerHeight: 200,
                        minCropBoxWidth: 100,
                        minCropBoxHeight: 100
                    });
                };
            };
            reader.readAsDataURL(file);
        } else {
            saveAvatarBtn.disabled = true;
            cropContainer.style.display = 'none';
        }
    });

    // Xử lý các nút điều khiển
    document.querySelectorAll('[data-method]').forEach(button => {
        button.addEventListener('click', function() {
            const method = this.getAttribute('data-method');
            const option = this.getAttribute('data-option');

            if (!cropper) return;

            switch (method) {
                case 'rotate':
                    cropper.rotate(Number(option));
                    break;
                case 'zoom':
                    cropper.zoom(Number(option));
                    break;
                case 'reset':
                    cropper.reset();
                    break;
            }
        });
    });

    // Xử lý khi submit form
    avatarForm.addEventListener('submit', function(e) {
        e.preventDefault();

        if (!cropper) {
            alert('Vui lòng chọn ảnh trước');
            return;
        }

        // Hiển thị trạng thái đang xử lý
        saveAvatarBtn.disabled = true;
        saveAvatarBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang xử lý...';

        // Lấy dữ liệu ảnh đã cắt dưới dạng base64
        const canvas = cropper.getCroppedCanvas({
            width: 300, // Độ phân giải ảnh đầu ra
            height: 300,
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high'
        });

        // Lấy CSRF token từ meta tag
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Chuyển đổi sang blob
        canvas.toBlob(function(blob) {
            // Tạo FormData để gửi lên server
            const formData = new FormData(avatarForm);
            formData.delete('avatar'); // Xóa input cũ
            formData.append('avatar', blob, 'avatar.jpg'); // Thêm blob với tên file

            // Gửi ajax request
            fetch(avatarForm.getAttribute('action'), {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Hiển thị thông báo thành công ngắn
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3';
                    alertDiv.setAttribute('role', 'alert');
                    alertDiv.innerHTML = `
                        <i class="fas fa-check-circle me-2"></i> ${data.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    `;
                    document.body.appendChild(alertDiv);

                    // Tự động đóng sau 1 giây
                    setTimeout(() => {
                        window.location.reload(); // Tải lại trang sau khi cập nhật thành công
                    }, 1000);
                } else {
                    saveAvatarBtn.disabled = false;
                    saveAvatarBtn.innerHTML = 'Cập nhật';
                    alert('Đã xảy ra lỗi: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Lỗi:', error);
                saveAvatarBtn.disabled = false;
                saveAvatarBtn.innerHTML = 'Cập nhật';
                alert('Đã xảy ra lỗi khi tải lên ảnh. Vui lòng thử lại.');
            });
        }, 'image/jpeg', 0.95); // Định dạng JPEG với chất lượng 95%
    });

    // Điều chỉnh kích thước cropper khi thay đổi kích thước màn hình
    window.addEventListener('resize', function() {
        if (cropper) {
            cropper.destroy();

            setTimeout(() => {
                cropper = new Cropper(cropperImage, {
                    aspectRatio: 1,
                    viewMode: 1,
                    preview: '#avatarPreview',
                    dragMode: 'move',
                    autoCropArea: 0.8,
                    responsive: true,
                    restore: false,
                    guides: true,
                    center: true,
                    highlight: true,
                    cropBoxMovable: true,
                    cropBoxResizable: true,
                    toggleDragModeOnDblclick: true
                });
            }, 200);
        }
    });
});

// Tab navigation functionality
document.addEventListener('DOMContentLoaded', function() {
    // Toggle comments
    document.querySelectorAll('.comment-toggle').forEach(button => {
        button.addEventListener('click', function() {
            const postId = this.getAttribute('data-post-id');
            const commentForm = document.getElementById(`comment-form-${postId}`);

            if (commentForm && (commentForm.style.display === 'none' || commentForm.style.display === '')) {
                commentForm.style.display = 'block';
            } else if (commentForm) {
                commentForm.style.display = 'none';
            }
        });
    });
});

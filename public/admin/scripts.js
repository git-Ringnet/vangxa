$("#sidebarCollapse").on("click", function () {
    $("#sidebar").toggleClass("active");
});
setTimeout(function () {
    $(".alert").alert("close");
}, 3000);
// Xử lý preview ảnh
$("#images").on("change", function () {
    const files = this.files;
    const preview = $("#image-preview");
    preview.empty();

    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        if (file.type.startsWith("image/")) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.append(`
                <div class="col-md-3 image-preview-item">
                    <img src="${e.target.result}" alt="Preview">
                    <div class="remove-image" data-index="${i}">
                        <i class="fas fa-times"></i>
                    </div>
                </div>
            `);
            };
            reader.readAsDataURL(file);
        }
    }
});

// Xử lý xóa ảnh preview
$(document).on("click", ".remove-image", function () {
    const index = $(this).data("index");
    const dt = new DataTransfer();
    const input = document.getElementById("images");
    const { files } = input;

    for (let i = 0; i < files.length; i++) {
        if (i !== index) {
            dt.items.add(files[i]);
        }
    }

    input.files = dt.files;
    $(this).closest(".image-preview-item").remove();
});

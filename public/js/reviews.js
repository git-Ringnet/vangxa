// Client-side validation
(function() {
    const form = document.getElementById("reviewForm");
    if (!form) return; // Thoát nếu không tìm thấy form

    const foodRatingError = document.getElementById("foodRatingError");
    const satisfactionLevelError = document.getElementById(
        "satisfactionLevelError"
    );
    const commentError = document.getElementById("commentError");
    const generalError = document.getElementById("generalError");

    form.addEventListener("submit", function (e) {
        let isValid = true;

        // Reset error messages
        if (foodRatingError) foodRatingError.textContent = "";
        if (satisfactionLevelError) satisfactionLevelError.textContent = "";
        if (commentError) commentError.textContent = "";
        if (generalError) generalError.textContent = "";

        // Kiểm tra đánh giá sao
        const foodRating = document.querySelector(
            'input[name="food_rating"]:checked'
        );
        let hasFoodRating = false;
        if (foodRating) {
            const ratingValue = parseInt(foodRating.value);
            if (isNaN(ratingValue) || ratingValue < 1 || ratingValue > 5) {
                if (foodRatingError) foodRatingError.textContent = "Đánh giá sao phải từ 1-5";
                isValid = false;
            } else {
                hasFoodRating = true;
            }
        }

        // Kiểm tra mức độ hài lòng
        const satisfactionLevel = document.querySelector(
            'input[name="satisfaction_level"]:checked'
        );
        let hasSatisfactionLevel = false;
        if (satisfactionLevel) {
            const satisfactionValue = parseInt(satisfactionLevel.value);
            if (
                isNaN(satisfactionValue) ||
                satisfactionValue < 1 ||
                satisfactionValue > 5
            ) {
                if (satisfactionLevelError) satisfactionLevelError.textContent = "Mức độ hài lòng phải từ 1-5";
                isValid = false;
            } else {
                hasSatisfactionLevel = true;
            }
        }

        // Kiểm tra nhận xét
        const comment = document.getElementById("comment")?.value.trim() || "";
        let hasComment = false;
        if (comment) {
            if (comment.length < 10) {
                if (commentError) commentError.textContent = "Nhận xét phải có ít nhất 10 ký tự";
                isValid = false;
            } else if (comment.length > 1000) {
                if (commentError) commentError.textContent = "Nhận xét không được vượt quá 1000 ký tự";
                isValid = false;
            } else {
                hasComment = true;
            }
        }

        // Kiểm tra có ít nhất 1 trong 3 loại đánh giá
        if (!hasFoodRating && !hasSatisfactionLevel && !hasComment) {
            if (generalError) {
                generalError.textContent = "Vui lòng nhập ít nhất một loại đánh giá";
            } else if (commentError) {
                commentError.textContent = "Vui lòng nhập ít nhất một loại đánh giá";
            }
            isValid = false;
        }

        // Nếu có lỗi, ngăn form submit
        if (!isValid) {
            e.preventDefault();
        }
    });
})();

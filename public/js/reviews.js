// Client-side validation
(function () {
    const form = document.getElementById("reviewForm");
    if (!form) return; // Thoát nếu không tìm thấy form

    const foodRatingError = document.getElementById("foodRatingError");
    const satisfactionLevelError = document.getElementById(
        "satisfactionLevelError"
    );
    const commentError = document.getElementById("commentError");
    const generalError = document.getElementById("generalError");

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        // Reset error messages
        if (foodRatingError) foodRatingError.textContent = "";
        if (satisfactionLevelError) satisfactionLevelError.textContent = "";
        if (commentError) commentError.textContent = "";
        if (generalError) generalError.textContent = "";

        // Get form values
        const foodRating = document.querySelector(
            'input[name="food_rating"]:checked'
        )?.value;
        const satisfactionLevel = document.querySelector(
            'input[name="satisfaction_level"]:checked'
        )?.value;
        const comment = document.getElementById("comment")?.value.trim();

        // Check if at least one type of rating is provided
        if (!foodRating && !satisfactionLevel && !comment) {
            if (generalError) {
                generalError.textContent =
                    "Vui lòng chọn ít nhất một loại đánh giá (sao, biểu tượng hoặc nhận xét)";
            }
            return;
        }

        // If comment is provided, validate its length
        if (comment) {
            if (comment.length < 10) {
                if (commentError)
                    commentError.textContent = "Nhận xét phải có ít nhất 10 ký tự";
                return;
            }
            if (comment.length > 1000) {
                if (commentError) {
                    commentError.textContent = "Nhận xét không được vượt quá 1000 ký tự";
                    return;
                }
            }
        }

        // If we get here, the form is valid
        this.submit();
    });
})();

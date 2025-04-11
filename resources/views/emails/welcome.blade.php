<!DOCTYPE html>
<html>
<head>
    <title>Chào mừng đến với Vangxa</title>
</head>
<body>
    <h2>Chào mừng bạn đến với Vangxa!</h2>
    <p>Xin chào {{ $user->name }},</p>
    <p>Cảm ơn bạn đã đăng ký tài khoản tại Vangxa. Để hoàn tất việc đăng ký, vui lòng xác thực email của bạn bằng cách nhập mã dưới đây:</p>

    <div style="background-color: #f8f9fa; padding: 15px; margin: 20px 0; text-align: center;">
        <h3 style="margin: 0; color: #333;">Mã xác thực của bạn:</h3>
        <p style="font-size: 24px; font-weight: bold; margin: 10px 0; color: #007bff;">{{ $verificationCode }}</p>
        <p style="font-size: 12px; color: #666;">Mã này sẽ hết hạn sau 15 phút.</p>
    </div>

    <p>Nếu bạn không yêu cầu mã này, vui lòng bỏ qua email này.</p>
    <p>Trân trọng,</p>
    <p>Đội ngũ Vangxa</p>
</body>
</html>

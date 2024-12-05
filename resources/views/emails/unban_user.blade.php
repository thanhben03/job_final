<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tài khoản đã được mở khóa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .email-container {
            width: 100%;
            padding: 20px;
            background-color: #ffffff;
            margin: 0 auto;
            max-width: 600px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background-color: #4CAF50;
            padding: 20px;
            color: #ffffff;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .email-header h1 {
            margin: 0;
        }
        .email-body {
            padding: 20px;
            text-align: left;
        }
        .email-body p {
            font-size: 16px;
            line-height: 1.6;
        }
        .email-footer {
            padding: 10px;
            background-color: #f1f1f1;
            text-align: center;
            font-size: 14px;
            color: #888;
            border-radius: 0 0 8px 8px;
        }
        .button {
            background-color: #4CAF50;
            color: #ffffff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 16px;
            display: inline-block;
            margin-top: 20px;
        }
        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="email-container">
    <div class="email-header">
        <h1>Tài khoản của bạn đã được mở khóa</h1>
    </div>

    <div class="email-body">
        <p>Xin chào <strong>{{ $data['candidate_name'] }}</strong>,</p>
        <p>Chúng tôi muốn thông báo rằng tài khoản của bạn đã được mở khóa thành công trên <strong>{{ config('app.name') }}</strong>. Bạn có thể đăng nhập lại và tiếp tục sử dụng tất cả các dịch vụ mà chúng tôi cung cấp.</p>
        <p>Nếu bạn gặp bất kỳ vấn đề gì hoặc cần trợ giúp, vui lòng liên hệ với chúng tôi qua email hoặc số điện thoại hỗ trợ dưới đây.</p>

    </div>

    <div class="email-footer">
        <p>Cảm ơn bạn đã sử dụng dịch vụ của <strong>{{ config('app.name') }}</strong>.</p>
        <p>Trân trọng,</p>
        <p><strong>Đội ngũ quản lý</strong></p>
    </div>
</div>

</body>
</html>

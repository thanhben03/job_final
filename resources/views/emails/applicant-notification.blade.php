<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }

        .email-header {
            background-color: #4caf50;
            color: white;
            text-align: center;
            padding: 20px;
        }

        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }

        .email-body {
            padding: 20px;
            line-height: 1.6;
        }

        .email-body h2 {
            color: #4caf50;
            font-size: 20px;
            margin-bottom: 10px;
        }

        .email-body p {
            margin: 10px 0;
        }

        .email-body ul {
            padding-left: 20px;
            margin: 10px 0;
        }

        .email-body ul li {
            margin-bottom: 10px;
        }

        .email-footer {
            background-color: #f9f9f9;
            text-align: center;
            padding: 10px;
            font-size: 14px;
            color: #777;
        }

        .email-footer a {
            color: #4caf50;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="email-container">
    <div class="email-header">
        <h1>Thông Tin Ứng Viên Mới</h1>
    </div>
    <div class="email-body">
        <h2>Xin chào Nhà Tuyển Dụng,</h2>
        <p>Bạn vừa nhận được thông tin ứng viên mới cho công việc. Dưới đây là chi tiết:</p>
        <ul>
            <li><strong>Tên ứng viên:</strong> {{ $applicantInfo['name'] }}</li>
            <li><strong>Email:</strong> {{ $applicantInfo['email'] }}</li>
            <li><strong>Số điện thoại:</strong> {{ $applicantInfo['phone'] }}</li>
        </ul>
        @if(isset($applicantInfo['letter']) && $applicantInfo['letter'] != '')
            {!! $applicantInfo['letter'] !!}
        @endif
        <p><strong>Hồ sơ ứng viên</strong> đã được đính kèm trong email này. Hãy kiểm tra và liên hệ ngay để không bỏ lỡ ứng viên tiềm năng!</p>
    </div>
    <div class="email-footer">
        <p>Cảm ơn bạn đã sử dụng <strong>{{ config('app.name') }}</strong>.</p>
        <p><a href="{{ url('/') }}">Truy cập hệ thống</a></p>
    </div>
</div>
</body>
</html>

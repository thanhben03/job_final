<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title}}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #007bff;
            padding: 10px 20px;
            color: #fff;
            border-radius: 8px 8px 0 0;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            margin: 20px 0;
            line-height: 1.6;
        }
        .button {
            text-align: center;
            margin-top: 20px;
        }
        .button a {
            background-color: #28a745;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }
        .button a:hover {
            background-color: #218838;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Thư Mời Phỏng Vấn</h1>
    </div>
    <div class="content">
        <p>Xin chào <strong>[{{$body['user']->fullname}}]</strong>,</p>
        <p>Chúng tôi rất vui mừng thông báo rằng bạn đã được chọn vào vòng phỏng vấn cho vị trí <strong>[{{$body['position']}}]</strong> tại công ty <strong>[{{$body['company_name']}}]</strong>.</p>
        <p>Thời gian phỏng vấn: <strong>{{$body['time']}}</strong><br>
            Địa điểm: <strong>{{$body['location']}}</strong></p>
        <p>Vui lòng xác nhận sự tham gia của bạn bằng cách nhấn vào nút dưới đây.</p>
        <div class="button">
            <a href="/invite-interview?code={{$body['code']}}" target="_blank">Xác Nhận Phỏng Vấn</a>
        </div>
        <p>Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ với chúng tôi qua email <strong>{{$body['email']}}</strong> hoặc số điện thoại <strong>{{$body['phone']}}</strong>.</p>
        <p>Chúng tôi mong sớm gặp bạn!</p>
        <p>Trân trọng,<br>
            <strong>{{$body['company_name']}}</strong></p>
    </div>
    <div class="footer">
        <p>&copy; 2024 {{$body['company_name']}}. All Rights Reserved.</p>
    </div>
</div>
</body>
</html>

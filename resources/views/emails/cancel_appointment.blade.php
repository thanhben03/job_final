<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lý Do Hủy Lịch Hẹn</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background-color: #4CAF50;
            color: #ffffff;
            text-align: center;
            padding: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 20px;
            color: #333333;
        }
        .content p {
            margin: 0 0 15px;
            line-height: 1.6;
        }
        .footer {
            background-color: #f1f1f1;
            text-align: center;
            padding: 15px;
            font-size: 14px;
            color: #555555;
        }
    </style>
</head>
<body>
<div class="email-container">
    <div class="header">
        <h1>Thông Báo Hủy Lịch Hẹn Phỏng Vấn</h1>
    </div>
    <div class="content">
        <p>Chào <strong>{{$data['candidate_name']}}</strong>,</p>
        <p>Chúng tôi rất tiếc phải thông báo rằng lịch hẹn phỏng vấn dự kiến diễn ra vào <strong>{{$data['date_time']}}</strong> đã bị hủy vì lý do sau:</p>
        <p><em>Lý do hủy lịch hẹn: </em></p>
        <p>{{$data['reason']}}</p>
        <p>Chúng tôi xin lỗi vì sự bất tiện này và sẽ liên hệ lại với bạn để sắp xếp một lịch hẹn mới nếu có thể.</p>
        <p>Trân trọng,</p>
        <p><strong>{{$data['company_name']}}</strong></p>
    </div>
    <div class="footer">
        <p>Vui lòng không trả lời email này. Nếu có thắc mắc, hãy liên hệ qua {{$data['email']}}.</p>
    </div>
</div>
</body>
</html>

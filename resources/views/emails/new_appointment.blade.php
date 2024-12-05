<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Báo Lịch Hẹn Phỏng Vấn</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
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
            background-color: #007BFF;
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
        .content .details {
            background-color: #f1f1f1;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
        .content .details p {
            margin: 0;
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
        <h1>Thông Báo Lịch Hẹn Phỏng Vấn Mới</h1>
    </div>
    <div class="content">
        <p>Chào <strong>{{ $data['candidate_name'] }}</strong>,</p>
        <p>Chúng tôi rất vui mừng thông báo rằng bạn đã được chọn tham gia một buổi phỏng vấn tại công ty của chúng tôi. Dưới đây là thông tin chi tiết:</p>
        <div class="details">
            <p><strong>Công việc: </strong> {{$data['title']}}</p>
            <p><strong>Ngày:</strong> {{ $data['date_time'] }}</p>
            @if($data['note'])
                <p><strong>Ghi chú:</strong> {{ $data['note'] }}</p>
            @endif
        </div>
        <p>Vui lòng xác nhận lịch hẹn này và liên hệ với chúng tôi nếu bạn có bất kỳ thắc mắc nào.</p>
        <p>Chúng tôi rất mong được gặp bạn!</p>
        <p>Trân trọng,</p>
        <p><strong>{{$data['email']}}</strong></p>
    </div>
    <div class="footer">
        <p>Đây là email tự động. Vui lòng không trả lời email này.</p>
    </div>
</div>
</body>
</html>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thay Đổi Lịch Hẹn Phỏng Vấn</title>
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
        <h1>Thông Báo Thay Đổi Lịch Hẹn Phỏng Vấn</h1>
    </div>
    <div class="content">
        <p>Chào <strong>{{ $data['candidate_name'] }}</strong>,</p>
        <p>Chúng tôi xin thông báo rằng lịch hẹn phỏng vấn của bạn đã được thay đổi. Dưới đây là thông tin lịch hẹn mới:</p>
        <div class="details">
            <p><strong>Ngày và Giờ Mới:</strong> {{ $data['new_date_time'] }}</p>
        </div>
        <p>Chúng tôi xin lỗi vì sự thay đổi đột ngột và rất mong bạn có thể sắp xếp để tham gia theo lịch mới.</p>
        @if($data['reason'])
            <span><strong>Lý do: </strong></span>
            <p>{{$data['reason']}}</p>
        @endif
        <p>Xin vui lòng liên hệ với chúng tôi qua email: <strong>{{$data['email']}}</strong> nếu bạn có bất kỳ câu hỏi nào.</p>
        <p>Trân trọng,</p>
        <p><strong>[{{$data['company_name']}}]</strong></p>
    </div>
    <div class="footer">
        <p>Đây là email tự động. Vui lòng không trả lời email này.</p>
    </div>
</div>
</body>
</html>

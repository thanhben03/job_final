<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông báo khóa tài khoản</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6;">
<div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; background-color: #f9f9f9;">
    <h2 style="color: #333;">Thông báo khóa tài khoản</h2>
    <p>Xin chào <strong>{{ $data['candidate_name'] }}</strong>,</p>
    <p>Chúng tôi phát hiện tài khoản của bạn đã vi phạm
        <strong>chính sách sử dụng</strong> của hệ thống. Vì vậy, tài khoản của bạn sẽ bị khóa tạm thời/kéo dài đến khi vấn đề được giải quyết.</p>
    @if($data['reason'])
        <strong>Lý do: </strong>
        <p>{{$data['reason']}}</p>
    @endif
    <p>Vui lòng liên hệ với chúng tôi qua email <a href="mailto:support@example.com">support@example.com</a> để biết thêm thông tin chi tiết hoặc giải quyết vấn đề.</p>
    <p>Chúng tôi rất tiếc vì sự bất tiện này, và hy vọng bạn sẽ sớm khắc phục các vi phạm để tiếp tục sử dụng dịch vụ.</p>
    <p>Trân trọng,</p>
    <p><strong>Đội ngũ quản lý</strong></p>
</div>
</body>
</html>

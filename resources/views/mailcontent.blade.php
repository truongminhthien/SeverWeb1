<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Mã Xác Thực</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 30px;
            color: #333;
        }

        .email-container {
            background: #ffffff;
            max-width: 600px;
            margin: auto;
            padding: 25px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        h2 {
            color: #007BFF;
            text-align: center;
        }

        .code-box {
            margin: 25px auto;
            padding: 15px 25px;
            background-color: #f1f9ff;
            border: 2px dashed #007BFF;
            border-radius: 8px;
            font-size: 28px;
            font-weight: bold;
            text-align: center;
            letter-spacing: 4px;
            color: #007BFF;
        }

        p {
            font-size: 15px;
            line-height: 1.6;
        }

        .footer {
            margin-top: 30px;
            font-size: 13px;
            color: #777;
        }

        a {
            color: #007BFF;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <h2>MÃ XÁC THỰC CỦA BẠN</h2>
        <p>Xin chào <strong>{{ $user }}</strong>,</p>
        <p>Bạn vừa yêu cầu xác minh tài khoản trên hệ thống <strong>CHANEL</strong>.
            Vui lòng sử dụng mã xác thực bên dưới để hoàn tất quá trình đăng nhập/đăng ký:</p>

        <div class="code-box">{{ $code }}</div>

        <p><strong>Lưu ý:</strong> Mã xác thực có hiệu lực trong vòng <strong>1 phút</strong>.
            Vui lòng không chia sẻ mã này với bất kỳ ai để bảo mật tài khoản.</p>

        <div class="footer">
            <p>Nếu bạn không thực hiện yêu cầu này, hãy bỏ qua email.</p>
            <p>Trân trọng,<br><strong>CHANEL</strong></p>
        </div>
    </div>
</body>

</html>
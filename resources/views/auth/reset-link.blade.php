<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password - VIRTULIST</title>
    <style>
        body {
            font-family: "Lora", serif;
            background-color: #f4f4f4;
            padding: 30px;
            color: #333;
        }

        .email-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            max-width: 600px;
            margin: auto;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .email-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 15px;
            text-align: center;
            color: #000;
        }

        .email-body {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .reset-link {
            display: inline-block;
            background-color: #000;
            color: #fff !important;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: bold;
        }

        .fallback {
            margin-top: 25px;
            font-size: 14px;
            color: #666;
            word-break: break-word;
        }

        .footer {
            margin-top: 30px;
            font-size: 13px;
            text-align: center;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-title">Reset Your Password - VIRTULIST</div>
        <div class="email-body">
            <p>Hello,</p>
            <p>You have requested to reset your account password.</p>
            <p>Please click the button below to reset your password:</p>
            <p style="text-align: center;">
                <a href="{{ $link }}" class="reset-link">Reset Password</a>
            </p>
            <div class="fallback">
                <p>If the button above doesn't work, copy and paste this link into your browser:</p>
                <p>{{ $link }}</p>
            </div>
        </div>
        <div class="footer">
            If you did not request a password reset, please ignore this email.
        </div>
    </div>
</body>
</html>

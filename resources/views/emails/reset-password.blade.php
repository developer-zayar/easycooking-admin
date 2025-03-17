<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password OTP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .email-container {
            max-width: 400px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .logo {
            width: 50px;
            border-radius: 10px;
        }

        .otp-box {
            display: inline-block;
            background: #f03363;
            color: #fff;
            font-size: 24px;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 8px;
            margin: 10px 0;
        }

        .footer {
            margin-top: 10px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Logo -->
        <div style="display: flex; flex-direction: column; align-items: center;">
            <img src="https://cdn6.aptoide.com/imgs/1/8/e/18e6fd961faaed74e8afd21452635ca8_icon.png" alt="EasyCookingMM Logo" class="logo">
            <h3 style="margin: 5px 10px; font-family: Arial, sans-serif; color: #333;">EasyCookingMM</h3>
        </div>

        <h2>Reset Your Password</h2>
        <p>Use the One-Time Password (OTP) below to verify your request:</p>

        <!-- OTP Box -->
        <div class="otp-box">{{ $otp }}</div>

        <p>This OTP is valid for a limited time. Please do not share it with anyone.</p>

        <div class="footer">
            <p>&copy; {{ date('Y') }} EasyCookingMM. All rights reserved.</p>
        </div>
    </div>
</body>

</html>

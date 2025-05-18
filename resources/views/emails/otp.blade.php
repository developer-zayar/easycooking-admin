<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verify Your Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
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
            text-align: left;
        }

        .logo {
            width: 50px;
            border-radius: 10px;
        }

        .otp-box {
            display: inline-block;
            background: #f03363;
            color: #fff;
            font-size: 18px;
            font-weight: bold;
            padding: 10px 10px;
            border-radius: 8px;
            margin: 10px 0;
        }

        .footer {
            margin-top: 10px;
            font-size: 12px;
            color: #777;
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Logo -->
        <div style="display: flex; flex-direction: column; align-items: center;">
            <img src="https://cdn6.aptoide.com/imgs/1/8/e/18e6fd961faaed74e8afd21452635ca8_icon.png"
                alt="EasyCookingMM Logo" class="logo">
            {{-- <h3 style="margin: 5px 10px; font-family: Arial, sans-serif; color: #333;">EasyCookingMM</h3> --}}
        </div>
        <br>

        <h2>Verify Your Email</h2>
        <p>Your One-Time Password (OTP) is:</p>

        <!-- OTP Box -->
        <div class="otp-box">
            {{ $otp }}
        </div>

        <p>This OTP expires in 10 minutes.</p>

    </div>

    <p class="footer">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>

</body>

</html>

{{-- <x-mail::message>
# Verify Your Email

Your One-Time Password (OTP) code is:

<x-mail::button :url="''">
    {{ $otp }}
</x-mail::button>

This OTP expires in 10 minutes.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message> --}}

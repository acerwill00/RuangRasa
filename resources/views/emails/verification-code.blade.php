<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Your Verification Code</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f7f6; margin: 0; padding: 40px 0;">
    <table align="center" width="600" style="background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin: 0 auto; border-spacing: 0;">
        <tr>
            <td style="padding: 40px; text-align: center;">
                <h1 style="color: #00263E; margin-bottom: 10px; font-size: 24px;">Verify Your Email Address</h1>
                <p style="color: #555555; line-height: 1.6; margin-bottom: 30px;">
                    Thank you for registering at Ruang Rasa. To complete your registration and secure your account, please enter the following 6-digit verification code:
                </p>
                <div style="background-color: #f0f4f8; border: 2px dashed #B18FE4; border-radius: 12px; padding: 20px; margin-bottom: 30px;">
                    <h2 style="margin: 0; font-size: 36px; color: #B18FE4; letter-spacing: 5px;">{{ $code }}</h2>
                </div>
                <p style="color: #888888; font-size: 13px;">
                    This code will expire in 15 minutes. If you did not request this, please ignore this email.
                </p>
            </td>
        </tr>
    </table>
</body>
</html>

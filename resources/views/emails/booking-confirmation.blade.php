<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Confirmation</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f7f6; margin: 0; padding: 40px 0;">
    <table align="center" width="600" style="background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin: 0 auto; border-spacing: 0;">
        <tr>
            <td style="padding: 40px; text-align: left;">
                <h1 style="color: #00263E; margin-bottom: 20px; font-size: 24px;">Booking Confirmed!</h1>
                <p style="color: #555555; line-height: 1.6; margin-bottom: 20px;">
                    Hi {{ $appointment->user->name }},
                </p>
                <p style="color: #555555; line-height: 1.6; margin-bottom: 30px;">
                    Your booking with <strong>{{ $appointment->psychologist->name }}</strong> has been successfully confirmed. Below are your session details:
                </p>
                
                <table width="100%" style="background-color: #f0f4f8; border-radius: 12px; padding: 20px; margin-bottom: 30px;">
                    <tr>
                        <td style="padding: 5px 0; color: #555; font-weight: bold;" width="120">Service:</td>
                        <td style="padding: 5px 0; color: #333;">{{ ucwords(str_replace('_', ' ', $appointment->service_type)) }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 5px 0; color: #555; font-weight: bold;">Date:</td>
                        <td style="padding: 5px 0; color: #333;">{{ \Carbon\Carbon::parse($appointment->schedule_date)->format('l, j F Y') }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 5px 0; color: #555; font-weight: bold;">Time:</td>
                        <td style="padding: 5px 0; color: #333;">{{ substr($appointment->schedule_time, 0, 5) }} WIB</td>
                    </tr>
                </table>

                <p style="color: #555555; line-height: 1.6; margin-bottom: 20px;">
                    Please join the session using the Google Meet link below at the scheduled time:
                </p>

                <div style="text-align: center; margin-top: 30px; margin-bottom: 30px;">
                    <a href="https://meet.google.com/kkm-wjfm-gyc" style="background-color: #B18FE4; color: #ffffff; text-decoration: none; padding: 14px 28px; border-radius: 8px; font-weight: bold; font-size: 16px; display: inline-block;">
                        Join Google Meet
                    </a>
                </div>
                
                <p style="color: #888888; font-size: 13px; text-align: center; margin-top: 40px; border-top: 1px solid #eeeeee; padding-top: 20px;">
                    Need help or need to cancel? You can manage your appointments directly from your <a href="{{ url('/dashboard') }}" style="color: #B18FE4; text-decoration: underline;">patient dashboard</a>.
                </p>
            </td>
        </tr>
    </table>
</body>
</html>

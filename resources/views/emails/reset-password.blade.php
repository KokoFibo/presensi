<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
</head>

<body style="margin:0; padding:0; background:#f3f4f6; font-family:Arial, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="padding:20px 0;">
        <tr>
            <td align="center">

                <table width="100%" max-width="500px"
                    style="background:#ffffff; border-radius:12px; overflow:hidden; box-shadow:0 5px 20px rgba(0,0,0,0.05);">

                    <!-- Header -->
                    <tr>
                        <td
                            style="background:#4f46e5; padding:20px; text-align:center; color:#ffffff; font-size:20px; font-weight:bold;">
                            Attendance System
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding:30px; color:#111827;">

                            <h2 style="margin-top:0;">Reset Password</h2>

                            <p>Halo <strong>{{ $user->name }}</strong>,</p>

                            <p>
                                Kami menerima permintaan untuk mereset password akun Anda.
                                Klik tombol di bawah untuk melanjutkan:
                            </p>

                            <div style="text-align:center; margin:30px 0;">
                                <a href="{{ $url }}"
                                    style="background:#4f46e5; color:#ffffff; padding:12px 24px; text-decoration:none; border-radius:8px; display:inline-block; font-weight:bold;">
                                    Reset Password
                                </a>
                            </div>

                            <p style="font-size:14px; color:#6b7280;">
                                Link ini hanya berlaku selama 60 menit.
                            </p>

                            <p style="font-size:14px; color:#6b7280;">
                                Jika Anda tidak meminta reset password, abaikan email ini.
                            </p>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding:20px; text-align:center; font-size:12px; color:#9ca3af;">
                            © {{ date('Y') }} Attendance System. All rights reserved. All rights reserved.
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>

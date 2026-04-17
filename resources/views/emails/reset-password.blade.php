<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
</head>

<body style="margin:0; padding:0; background:#f9fafb; font-family:Arial, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="padding:20px 0;">
        <tr>
            <td align="center">

                <!-- Card -->
                <table width="100%"
                    style="max-width:500px; background:#ffffff; border-radius:16px; overflow:hidden; border:1px solid #f1f1f1; box-shadow:0 10px 25px rgba(0,0,0,0.05);">

                    <!-- Header -->
                    <tr>
                        <td style="padding:24px; text-align:center; border-bottom:1px solid #f1f1f1;">
                            <h1 style="margin:0; font-size:20px; color:#1a1c1e;">
                                Attendance System
                            </h1>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding:30px; color:#111827;">

                            <h2 style="margin-top:0; font-size:18px;">
                                Reset Password
                            </h2>

                            <p style="margin:10px 0;">
                                Halo <strong>{{ $user->name }}</strong>,
                            </p>

                            <p style="margin:10px 0; color:#374151;">
                                Kami menerima permintaan untuk mereset password akun Anda.
                                Klik tombol di bawah untuk melanjutkan:
                            </p>

                            <!-- Button -->
                            <div style="text-align:center; margin:30px 0;">
                                <a href="{{ $url }}"
                                    style="background:#1a1c1e; color:#ffffff; padding:12px 24px; text-decoration:none; border-radius:12px; display:inline-block; font-weight:bold;">
                                    RESET PASSWORD
                                </a>
                            </div>

                            <p style="font-size:13px; color:#6b7280;">
                                Link ini hanya berlaku selama 60 menit.
                            </p>

                            <p style="font-size:13px; color:#6b7280;">
                                Jika Anda tidak meminta reset password, abaikan email ini.
                            </p>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td
                            style="padding:20px; text-align:center; font-size:11px; color:#9ca3af; border-top:1px solid #f1f1f1;">
                            © {{ date('Y') }} Attendance System
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>

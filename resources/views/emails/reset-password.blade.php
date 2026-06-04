@extends('emails.layout')

@section('content')
    <p style="margin:0 0 8px; font-size:18px; font-weight:600; color:#18181b; letter-spacing:-0.01em;">
        Reset Password
    </p>
    <p style="margin:0 0 16px; font-size:13px; color:#71717a; line-height:1.7;">
        Halo {{ $user->name }}, kami menerima permintaan untuk mereset password akun kamu.
        Klik tombol di bawah untuk melanjutkan.
    </p>
    <p style="margin:0 0 24px; font-size:13px; color:#71717a; line-height:1.7;">
        Link ini akan kadaluarsa dalam <strong style="color:#18181b;">60 menit</strong>.
    </p>

    <!-- Button -->
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin-bottom:24px;">
        <tr>
            <td style="background-color:#010101; border-radius:8px;">
                <a href="{{ $url }}"
                    style="display:inline-block; padding:10px 20px; font-size:13px; font-weight:500; color:#ffffff; text-decoration:none;">
                    Reset Password →
                </a>
            </td>
        </tr>
    </table>

    <!-- Divider -->
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin-bottom:16px;">
        <tr>
            <td style="border-top:1px solid #e4e4e7;"></td>
        </tr>
    </table>

    <p style="margin:0 0 8px; font-size:12px; color:#a1a1aa; line-height:1.6;">
        Jika kamu tidak merasa meminta reset password, abaikan email ini.
        Password kamu tidak akan berubah.
    </p>

    <!-- URL fallback -->
    <p style="margin:8px 0 0; font-size:11px; color:#a1a1aa;">
        Jika tombol tidak berfungsi, copy link berikut ke browser kamu:
    </p>
    <p style="margin:4px 0 0; font-size:11px; color:#71717a; word-break:break-all;">
        {{ $url }}
    </p>
@endsection

@extends('emails.layout')

@section('content')
    <p style="margin:0 0 8px; font-size:18px; font-weight:600; color:#18181b; letter-spacing:-0.01em;">
        Konfirmasi Email Baru
    </p>
    <p style="margin:0 0 16px; font-size:13px; color:#71717a; line-height:1.7;">
        Halo {{ $name }}, kamu baru saja meminta perubahan email di Delix Studio.
        Klik tombol di bawah untuk mengkonfirmasi email baru kamu.
    </p>
    <p style="margin:0 0 24px; font-size:13px; color:#71717a; line-height:1.7;">
        Link ini akan kadaluarsa dalam <strong style="color:#18181b;">60 menit</strong>.
        Jika kamu tidak meminta perubahan ini, abaikan email ini.
    </p>

    <!-- Button -->
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin-bottom:24px;">
        <tr>
            <td style="background-color:#010101; border-radius:8px;">
                <a href="{{ $verificationUrl }}"
                    style="display:inline-block; padding:10px 20px; font-size:13px; font-weight:500; color:#ffffff; text-decoration:none;">
                    Konfirmasi Email Baru →
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

    <!-- Info -->
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
        <tr>
            <td style="padding:8px 0; border-bottom:1px solid #f4f4f5;">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                        <td style="font-size:12px; color:#a1a1aa;">Email Lama</td>
                        <td align="right" style="font-size:12px; font-weight:500; color:#18181b;">{{ $oldEmail }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="padding:8px 0;">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                        <td style="font-size:12px; color:#a1a1aa;">Email Baru</td>
                        <td align="right" style="font-size:12px; font-weight:500; color:#18181b;">
                            {{ $newEmail }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <p style="margin:16px 0 0; font-size:11px; color:#a1a1aa;">
        Jika tombol tidak berfungsi, copy link berikut ke browser:
    </p>
    <p style="margin:4px 0 0; font-size:11px; color:#71717a; word-break:break-all;">
        {{ $verificationUrl }}
    </p>
@endsection

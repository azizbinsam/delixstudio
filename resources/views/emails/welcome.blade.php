@extends('emails.layout')

@section('content')
    <p style="margin:0 0 8px; font-size:18px; font-weight:600; color:#18181b; letter-spacing:-0.01em;">
        Selamat datang, {{ $user->name }}! 🎉
    </p>
    <p style="margin:0 0 16px; font-size:13px; color:#71717a; line-height:1.7;">
        Terima kasih sudah bergabung di Delix Studio. Akun kamu sudah aktif dan siap digunakan.
    </p>
    <p style="margin:0 0 24px; font-size:13px; color:#71717a; line-height:1.7;">
        Mulai jelajahi kelas dan produk WordPress premium kami untuk meningkatkan skill dan bisnis kamu.
    </p>

    <!-- Button -->
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin-bottom:24px;">
        <tr>
            <td style="background-color:#010101; border-radius:8px;">
                <a href="{{ route('courses.index') }}"
                    style="display:inline-block; padding:10px 20px; font-size:13px; font-weight:500; color:#ffffff; text-decoration:none;">
                    Jelajahi Kelas →
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

    <!-- Info Rows -->
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
        <tr>
            <td style="padding:8px 0; border-bottom:1px solid #f4f4f5;">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                        <td style="font-size:12px; color:#a1a1aa;">Nama</td>
                        <td align="right" style="font-size:12px; font-weight:500; color:#18181b;">{{ $user->name }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="padding:8px 0; border-bottom:1px solid #f4f4f5;">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                        <td style="font-size:12px; color:#a1a1aa;">Email</td>
                        <td align="right" style="font-size:12px; font-weight:500; color:#18181b;">{{ $user->email }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="padding:8px 0;">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                        <td style="font-size:12px; color:#a1a1aa;">Bergabung</td>
                        <td align="right" style="font-size:12px; font-weight:500; color:#18181b;">{{ $user->created_at->format('d M Y') }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
@endsection
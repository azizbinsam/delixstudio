@extends('emails.layout')

@section('content')
    <p style="margin:0 0 8px; font-size:18px; font-weight:600; color:#18181b; letter-spacing:-0.01em;">
        Email Kamu Telah Diubah
    </p>
    <p style="margin:0 0 16px; font-size:13px; color:#71717a; line-height:1.7;">
        Halo {{ $user->name }}, email akun Delix Studio kamu baru saja diubah.
    </p>

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
                        <td align="right" style="font-size:12px; font-weight:500; color:#18181b;">{{ $newEmail }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <p style="margin:16px 0 0; font-size:13px; color:#71717a; line-height:1.7;">
        Jika kamu tidak melakukan perubahan ini, segera hubungi kami.
    </p>

    <!-- Button -->
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin-top:16px;">
        <tr>
            <td style="background-color:#ef4444; border-radius:8px;">
                <a href="{{ route('login') }}"
                    style="display:inline-block; padding:10px 20px; font-size:13px; font-weight:500; color:#ffffff; text-decoration:none;">
                    Amankan Akun →
                </a>
            </td>
            @if ($whatsappUrl)
                <td style="width:8px;"></td>
                <td style="background-color:#16a34a; border-radius:8px;">
                    <a href="{{ $whatsappUrl }}"
                        style="display:inline-block; padding:10px 20px; font-size:13px; font-weight:500; color:#ffffff; text-decoration:none;">
                        Hubungi Kami →
                    </a>
                </td>
            @endif
        </tr>
    </table>
@endsection

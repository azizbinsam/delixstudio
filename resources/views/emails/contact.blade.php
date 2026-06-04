@extends('emails.layout')

@section('content')
    <p style="margin:0 0 8px; font-size:18px; font-weight:600; color:#18181b; letter-spacing:-0.01em;">
        Pesan Baru dari Website
    </p>
    <p style="margin:0 0 24px; font-size:13px; color:#71717a; line-height:1.7;">
        Kamu menerima pesan baru melalui form kontak Delix Studio.
    </p>

    <!-- Divider -->
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin-bottom:16px;">
        <tr>
            <td style="border-top:1px solid #e4e4e7;"></td>
        </tr>
    </table>

    <!-- Info Rows -->
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin-bottom:24px;">
        <tr>
            <td style="padding:8px 0; border-bottom:1px solid #f4f4f5;">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                        <td style="font-size:12px; color:#a1a1aa;">Nama</td>
                        <td align="right" style="font-size:12px; font-weight:500; color:#18181b;">{{ $name }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="padding:8px 0; border-bottom:1px solid #f4f4f5;">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                        <td style="font-size:12px; color:#a1a1aa;">Email</td>
                        <td align="right" style="font-size:12px; font-weight:500; color:#18181b;">
                            <a href="mailto:{{ $email }}" style="color:#18181b;">{{ $email }}</a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="padding:8px 0; border-bottom:1px solid #f4f4f5;">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                        <td style="font-size:12px; color:#a1a1aa;">Subjek</td>
                        <td align="right" style="font-size:12px; font-weight:500; color:#18181b;">{{ $subject }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="padding:8px 0;">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                        <td style="font-size:12px; color:#a1a1aa;">Dikirim</td>
                        <td align="right" style="font-size:12px; font-weight:500; color:#18181b;">
                            {{ now()->format('d M Y, H:i') }} WIB
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- Divider -->
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin-bottom:16px;">
        <tr>
            <td style="border-top:1px solid #e4e4e7;"></td>
        </tr>
    </table>

    <!-- Pesan -->
    <p style="margin:0 0 8px; font-size:12px; color:#a1a1aa;">Pesan</p>
    <p style="margin:0 0 24px; font-size:13px; color:#18181b; line-height:1.7; white-space:pre-line;">{{ $messageContent }}
    </p>

    <!-- Reply Button -->
    <table role="presentation" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td style="background-color:#010101; border-radius:8px;">
                <a href="mailto:{{ $email }}?subject=Re: {{ $subject }}"
                    style="display:inline-block; padding:10px 20px; font-size:13px; font-weight:500; color:#ffffff; text-decoration:none;">
                    Balas Pesan →
                </a>
            </td>
        </tr>
    </table>
@endsection

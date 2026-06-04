@extends('emails.layout')

@section('content')
    <p style="margin:0 0 8px; font-size:18px; font-weight:600; color:#18181b; letter-spacing:-0.01em;">
        Pembayaran Dikonfirmasi ✅
    </p>
    <p style="margin:0 0 16px; font-size:13px; color:#71717a; line-height:1.7;">
        Halo {{ $order->user->name }}, pembayaran untuk pesanan
        <strong style="color:#18181b;">{{ $order->invoice_number }}</strong>
        sudah dikonfirmasi. Kamu sekarang bisa mengakses semua konten yang sudah dibeli.
    </p>

    <!-- Button -->
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin-bottom:24px;">
        <tr>
            <td style="background-color:#010101; border-radius:8px;">
                <a href="{{ route('user.orders.show', $order->invoice_number) }}"
                    style="display:inline-block; padding:10px 20px; font-size:13px; font-weight:500; color:#ffffff; text-decoration:none;">
                    Lihat Pesanan →
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

    <!-- Items -->
    @foreach ($order->items as $item)
        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
            <tr>
                <td style="padding:12px 0; border-bottom:1px solid #f4f4f5;">
                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                        <tr>
                            <td>
                                <p style="margin:0 0 2px; font-size:13px; font-weight:500; color:#18181b;">
                                    {{ $item->item_name }}</p>
                                <p style="margin:0; font-size:11px; color:#a1a1aa;">
                                    {{ class_basename($item->itemable_type) === 'Course' ? 'Kelas' : 'Produk' }}
                                </p>
                            </td>
                            <td align="right" style="font-size:13px; font-weight:600; color:#18181b; white-space:nowrap;">
                                Rp {{ number_format($item->price, 0, ',', '.') }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    @endforeach

    <!-- Total -->
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin-top:16px;">
        <tr>
            <td style="font-size:14px; font-weight:600; color:#18181b;">Total</td>
            <td align="right" style="font-size:16px; font-weight:700; color:#18181b;">
                Rp {{ number_format($order->total, 0, ',', '.') }}
            </td>
        </tr>
    </table>

    <!-- Divider -->
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin:24px 0 16px;">
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
                        <td style="font-size:12px; color:#a1a1aa;">Invoice</td>
                        <td align="right" style="font-size:12px; font-weight:500; color:#18181b; font-family:monospace;">
                            {{ $order->invoice_number }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="padding:8px 0; border-bottom:1px solid #f4f4f5;">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                        <td style="font-size:12px; color:#a1a1aa;">Status</td>
                        <td align="right">
                            <span
                                style="display:inline-block; padding:2px 8px; border-radius:100px; font-size:11px; font-weight:500; background:#f0fdf4; color:#16a34a; border:1px solid #bbf7d0;">
                                Paid
                            </span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="padding:8px 0;">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                        <td style="font-size:12px; color:#a1a1aa;">Dibayar pada</td>
                        <td align="right" style="font-size:12px; font-weight:500; color:#18181b;">
                            {{ $order->paid_at?->format('d M Y, H:i') }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
@endsection

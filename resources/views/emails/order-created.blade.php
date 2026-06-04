@extends('emails.layout')

@section('content')
    <p style="margin:0 0 8px; font-size:18px; font-weight:600; color:#18181b; letter-spacing:-0.01em;">
        Pesanan Berhasil Dibuat
    </p>
    <p style="margin:0 0 16px; font-size:13px; color:#71717a; line-height:1.7;">
        Halo {{ $order->user->name }}, pesanan kamu dengan nomor invoice
        <strong style="color:#18181b;">{{ $order->invoice_number }}</strong> sudah berhasil dibuat.
    </p>

    @if($order->payment_method === 'manual_transfer')
        <p style="margin:0 0 16px; font-size:13px; color:#71717a; line-height:1.7;">
            Silakan lakukan transfer ke rekening kami dan upload bukti pembayaran untuk memproses pesanan kamu.
        </p>
        <!-- Button -->
        <table role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin-bottom:24px;">
            <tr>
                <td style="background-color:#010101; border-radius:8px;">
                    <a href="{{ route('user.payment.confirm', $order->invoice_number) }}"
                        style="display:inline-block; padding:10px 20px; font-size:13px; font-weight:500; color:#ffffff; text-decoration:none;">
                        Konfirmasi Pembayaran →
                    </a>
                </td>
            </tr>
        </table>
    @endif

    <!-- Divider -->
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin-bottom:16px;">
        <tr><td style="border-top:1px solid #e4e4e7;"></td></tr>
    </table>

    <!-- Items -->
    @foreach($order->items as $item)
        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
            <tr>
                <td style="padding:12px 0; border-bottom:1px solid #f4f4f5;">
                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                        <tr>
                            <td>
                                <p style="margin:0 0 2px; font-size:13px; font-weight:500; color:#18181b;">{{ $item->item_name }}</p>
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

    @if($order->discount > 0)
        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
            <tr>
                <td style="padding:12px 0; border-bottom:1px solid #f4f4f5;">
                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                        <tr>
                            <td>
                                <p style="margin:0 0 2px; font-size:13px; font-weight:500; color:#16a34a;">Diskon</p>
                                @if($order->promoCode)
                                    <p style="margin:0; font-size:11px; color:#a1a1aa;">{{ $order->promoCode->code }}</p>
                                @endif
                            </td>
                            <td align="right" style="font-size:13px; font-weight:600; color:#16a34a; white-space:nowrap;">
                                - Rp {{ number_format($order->discount, 0, ',', '.') }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    @endif

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
        <tr><td style="border-top:1px solid #e4e4e7;"></td></tr>
    </table>

    <!-- Info -->
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
        <tr>
            <td style="padding:8px 0; border-bottom:1px solid #f4f4f5;">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                        <td style="font-size:12px; color:#a1a1aa;">Invoice</td>
                        <td align="right" style="font-size:12px; font-weight:500; color:#18181b; font-family:monospace;">{{ $order->invoice_number }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="padding:8px 0; border-bottom:1px solid #f4f4f5;">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                        <td style="font-size:12px; color:#a1a1aa;">Metode</td>
                        <td align="right" style="font-size:12px; font-weight:500; color:#18181b;">
                            {{ str_replace('_', ' ', ucfirst($order->payment_method)) }}
                        </td>
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
                            <span style="display:inline-block; padding:2px 8px; border-radius:100px; font-size:11px; font-weight:500; background:#fefce8; color:#ca8a04; border:1px solid #fef08a;">
                                Pending
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
                        <td style="font-size:12px; color:#a1a1aa;">Tanggal</td>
                        <td align="right" style="font-size:12px; font-weight:500; color:#18181b;">
                            {{ $order->created_at->format('d M Y, H:i') }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
@endsection
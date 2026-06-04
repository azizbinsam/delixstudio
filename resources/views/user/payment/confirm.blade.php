@extends('layouts.app')

@section('title', 'Konfirmasi Pembayaran')

@section('content')
    <div class="pt-10 pb-20">
        <div class="max-w-lg mx-auto px-6">

            {{-- Header --}}
            <div class="mb-8">
                <p class="section-label">Pembayaran</p>
                <h1 class="text-2xl font-semibold tracking-tight text-white">Konfirmasi Transfer</h1>
            </div>

            {{-- Info Rekening --}}
            <div class="card p-5 mb-6">
                <p class="text-xs font-medium text-white/40 uppercase tracking-widest mb-4">
                    Transfer ke Rekening
                </p>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-white/30">Bank</span>
                        <span class="text-sm font-semibold text-white">{{ $paymentSetting->bank_name }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-white/30">Nomor Rekening</span>
                        <div class="flex items-center gap-2" x-data="{ copied: false }"
                            @click="
                            const el = document.createElement('textarea');
                            el.value = '{{ $paymentSetting->bank_account_number }}';
                            document.body.appendChild(el);
                            el.select();
                            document.execCommand('copy');
                            document.body.removeChild(el);
                            copied = true;
                            setTimeout(() => copied = false, 2000);
                        ">
                            <span
                                class="text-sm font-mono font-semibold text-white cursor-pointer hover:text-white/70 transition-colors">
                                {{ $paymentSetting->bank_account_number }}
                            </span>
                            <span x-show="!copied" class="text-white/20 cursor-pointer hover:text-white transition-colors">
                                <i class="fas fa-copy text-xs"></i>
                            </span>
                            <span x-show="copied" class="text-green-400 text-xs">
                                <i class="fas fa-check"></i> Disalin!
                            </span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-white/30">Atas Nama</span>
                        <span class="text-sm font-semibold text-white">{{ $paymentSetting->bank_account_name }}</span>
                    </div>
                    <div class="border-t border-white/5 pt-3 flex items-center justify-between">
                        <span class="text-xs text-white/30">Total Transfer</span>
                        <span class="text-lg font-semibold text-white">
                            Rp {{ number_format($order->total, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Form Upload --}}
            <form action="{{ route('user.payment.submit', $order->invoice_number) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="card p-5">
                    <p class="text-xs font-medium text-white/40 uppercase tracking-widest mb-4">
                        Upload Bukti Transfer
                    </p>

                    <div x-data="{ preview: null }">
                        <label class="label">Foto Bukti Transfer</label>

                        <div class="border border-white/10 border-dashed rounded-xl p-8 text-center
                        hover:border-white/20 transition-colors cursor-pointer"
                            @click="$refs.fileInput.click()">

                            <template x-if="!preview">
                                <div>
                                    <i class="fas fa-cloud-upload-alt text-2xl text-white/20 mb-2 block"></i>
                                    <p class="text-xs text-white/30">Klik untuk upload bukti transfer</p>
                                    <p class="text-[11px] text-white/20 mt-1">JPG, PNG maksimal 5MB</p>
                                </div>
                            </template>

                            <template x-if="preview">
                                <div class="relative">
                                    <img :src="preview" class="max-h-48 mx-auto rounded-lg object-contain">
                                    <p class="text-[11px] text-white/30 mt-2">Klik untuk ganti gambar</p>
                                </div>
                            </template>
                        </div>

                        <input type="file" name="payment_proof" accept="image/*" class="hidden" x-ref="fileInput"
                            @change="preview = URL.createObjectURL($event.target.files[0])">

                        @error('payment_proof')
                            <p class="text-xs text-red-400 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <x-btn type="submit" class="w-full justify-center mt-4">
                        <i class="fab fa-whatsapp"></i>
                        Kirim Konfirmasi via WhatsApp
                    </x-btn>

                    <p class="text-[11px] text-white/20 text-center mt-3 leading-relaxed">
                        Setelah submit, kamu akan diarahkan ke WhatsApp untuk konfirmasi ke admin.
                    </p>
                </div>
            </form>
        </div>
    </div>
@endsection

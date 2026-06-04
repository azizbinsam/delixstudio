@extends('layouts.admin')

@section('title', 'Kode Promo')

@section('content')
    <div x-data="{ showCreate: false, showEdit: false, editData: {} }">

        <div class="page-header">
            <div>
                <h1 class="page-title">Kode Promo</h1>
                <p class="page-desc">Kelola diskon dan promo</p>
            </div>
            <x-btn @click="showCreate = true">
                <i class="fas fa-plus"></i> Tambah Promo
            </x-btn>
        </div>

        <livewire:admin.promo-code-table />

        {{-- Modal Create --}}
        <x-modal show="showCreate" title="Tambah Kode Promo">
            <form action="{{ route('admin.promo-codes.store') }}" method="POST" class="space-y-3" x-data="{ scope: 'all' }">
                @csrf

                <x-form.input name="code" label="Kode Promo" class="uppercase" placeholder="PROMO10"
                    hint="Akan otomatis diubah ke huruf kapital" required />

                <div class="grid grid-cols-2 gap-3 items-end">
                    <x-form.select name="type" label="Tipe" :options="['percentage' => 'Persentase (%)', 'fixed' => 'Fixed (Rp)']" />
                    <x-form.input name="value" label="Nilai" type="number" placeholder="10" required />
                </div>

                <x-form.input name="minimum_purchase" label="Min. Pembelian (Rp)" type="number" placeholder="0" />

                <div class="grid grid-cols-2 gap-3">
                    <x-form.input name="max_usage" label="Maks. Pemakaian" type="number" placeholder="∞"
                        hint="Kosongkan untuk unlimited" />
                    <x-form.input name="expired_at" label="Expired" type="date" />
                </div>

                {{-- Scope --}}
                <x-form.select name="scope" label="Berlaku Untuk" x-model="scope" :options="[
                    'all' => 'Semua Produk & Kelas',
                    'all_courses' => 'Semua Kelas',
                    'all_products' => 'Semua Produk',
                    'specific' => 'Kelas & Produk Tertentu',
                ]" />

                {{-- Item Tertentu --}}
                <div x-show="scope === 'specific'" x-cloak>
                    <x-form.multiselect-search name="item_ids" label="Pilih Kelas & Produk" :items="$selectorItems" />
                </div>

                <x-form.toggle name="is_active" label="Aktif" hint="Promo akan langsung aktif setelah disimpan"
                    :checked="true" />

                <x-form.toggle name="show_in_banner" label="Tampilkan di Banner"
                    hint="Hanya satu promo yang bisa tampil di banner sekaligus" :checked="$promoCode->show_in_banner ?? false" />

                <div class="flex gap-2 pt-2">
                    <x-btn variant="outline" class="flex-1" @click="showCreate = false">Batal</x-btn>
                    <x-btn type="submit" class="flex-1">Simpan</x-btn>
                </div>
            </form>
        </x-modal>

        {{-- Modal Edit --}}
        <x-modal show="showEdit" title="Edit Kode Promo">
            <form :action="`/admin/promo-codes/${editData.id}`" method="POST" class="space-y-3">
                @csrf
                @method('PUT')

                <x-form.input name="code" label="Kode Promo" placeholder="Kode promo" x-bind:value="editData.code"
                    class="uppercase" required />

                <div class="grid grid-cols-2 gap-3 items-end">
                    <x-form.select name="type" label="Tipe">
                        <option value="percentage" :selected="editData.type === 'percentage'">
                            Persentase (%)
                        </option>
                        <option value="fixed" :selected="editData.type === 'fixed'">
                            Fixed (Rp)
                        </option>
                    </x-form.select>

                    <x-form.input name="value" label="Nilai" type="number" x-bind:value="editData.value" min="0"
                        required />
                </div>

                <x-form.input name="minimum_purchase" label="Min. Pembelian (Rp)" type="number"
                    x-bind:value="editData.minimum_purchase" min="0" />

                <div class="grid grid-cols-2 gap-3">
                    <x-form.input name="max_usage" label="Maks. Pemakaian" type="number" x-bind:value="editData.max_usage"
                        min="1" hint="Kosongkan untuk unlimited" />

                    <x-form.input name="expired_at" label="Expired" type="date"
                        x-bind:value="editData.expired_at ?
                            editData.expired_at.substring(0, 10) :
                            ''" />
                </div>

                {{-- Scope --}}
                <x-form.select name="scope" label="Berlaku Untuk" :options="[
                    'all' => 'Semua Produk & Kelas',
                    'all_courses' => 'Semua Kelas',
                    'all_products' => 'Semua Produk',
                    'specific' => 'Kelas & Produk Tertentu',
                ]" x-model="editData.scope" />

                {{-- Item Tertentu --}}
                <div x-show="editData.scope === 'specific'" x-cloak>
                    <x-form.multiselect-search name="item_ids" label="Pilih Kelas & Produk" :items="$selectorItems"
                        alpine-selected="editData.item_ids" />
                </div>


                <x-form.toggle name="is_active" label="Aktif" x-bind:checked="editData.is_active" />

                <x-form.toggle name="show_in_banner" label="Tampilkan di Banner"
                    hint="Hanya satu promo yang bisa tampil di banner sekaligus" :checked="$promoCode->show_in_banner ?? false" />

                <div class="flex gap-2 pt-2">
                    <x-btn variant="outline" class="flex-1" @click="showEdit = false">
                        Batal
                    </x-btn>

                    <x-btn type="submit" class="flex-1">
                        Simpan
                    </x-btn>
                </div>
            </form>
        </x-modal>

    </div>
@endsection

<div x-data="confirmDialog()" x-cloak @confirm.window="open($event.detail)" x-show="show"
    x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-100"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-[500] flex items-center justify-center p-4">

    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="cancel()"></div>

    <div class="relative w-full max-w-sm card p-6 z-10 flex flex-col items-center" @click.stop
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 scale-95 translate-y-2"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0">

        <div class="w-10 h-10 rounded-full flex items-center justify-center mb-4"
            :class="type === 'danger' ? 'bg-red-500/10' : 'bg-white/5'">
            <i class="text-sm"
                :class="type === 'danger' ? 'fas fa-trash text-red-400' : 'fas fa-exclamation text-white/50'"></i>
        </div>

        <p class="text-sm font-semibold text-white mb-1" x-text="title"></p>
        <p class="text-xs text-white/40 leading-relaxed mb-5 text-center" x-text="message"></p>

        <div class="flex gap-2">
            <button @click="cancel()" class="btn-outline btn flex-1 whitespace-nowrap">Batal</button>
            <button @click="confirm()" :class="type === 'danger' ? 'btn-destructive' : 'btn-primary'"
                class="btn flex-1 whitespace-nowrap" x-text="confirmText">
            </button>
        </div>
    </div>
</div>

<script>
    if (typeof confirmDialog === 'undefined') {
        function confirmDialog() {
            return {
                show: false,
                title: '',
                message: '',
                confirmText: 'Hapus',
                type: 'danger',
                resolveCallback: null,

                open(detail) {
                    this.title = detail.title || 'Konfirmasi';
                    this.message = detail.message || 'Apakah kamu yakin?';
                    this.confirmText = detail.confirmText || 'Hapus';
                    this.type = detail.type || 'danger';
                    this.resolveCallback = detail.callback;
                    this.show = true;
                },

                confirm() {
                    console.log('confirm called');
                    this.show = false;
                    if (this.resolveCallback) this.resolveCallback(true);
                    this.resolveCallback = null;
                },

                cancel() {
                    console.log('cancel called');
                    this.show = false;
                    if (this.resolveCallback) this.resolveCallback(false);
                    this.resolveCallback = null;
                }
            }
        }

        function confirmAction(options) {
            return new Promise((resolve) => {
                window.dispatchEvent(new CustomEvent('confirm', {
                    detail: {
                        ...options,
                        callback: resolve
                    }
                }));
            });
        }
    }
</script>

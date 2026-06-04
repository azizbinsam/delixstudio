@props(['name', 'label' => null, 'items' => [], 'selected' => [], 'alpineSelected' => null])

<div x-data="{
    search: '',
    items: {{ Js::from($items) }},
    selected: {{ Js::from($selected) }},

    get filtered() {
        if (!this.search.trim()) return [];

        return this.items.filter(item =>
            item.title.toLowerCase().includes(this.search.toLowerCase()) &&
            !this.selected.includes(item.id)
        ).slice(0, 10);
    },

    add(id) {
        if (!this.selected.includes(id)) {
            this.selected.push(id);
        }

        this.search = '';
    },

    remove(id) {
        this.selected = this.selected.filter(i => i !== id);
    },

    item(id) {
        return this.items.find(i => i.id === id);
    }
}" @if ($alpineSelected)
    x-init="$watch('{{ $alpineSelected }}', value => { selected = Array.isArray(value) ? value : [] });"
    @endif
    class="space-y-3"
    >

    @if ($label)
        <label class="label">
            {{ $label }}
        </label>
    @endif

    <div class="relative">

        <input type="text" x-model="search" placeholder="Cari..." class="input">

        <div x-show="filtered.length" x-transition class="absolute z-50 mt-2 w-full card overflow-hidden">
            <template x-for="item in filtered" :key="item.id">

                <button type="button" @click="add(item.id)"
                    class="w-full px-3 py-2 text-left text-sm text-white/70 hover:bg-white/5 flex items-center gap-2">
                    <i :class="item.type === 'course' ? 'fas fa-graduation-cap' : 'fas fa-box'"></i>

                    <span x-text="item.title"></span>

                </button>

            </template>
        </div>

    </div>

    <div x-show="selected.length" class="flex flex-wrap gap-2">

        <template x-for="id in selected" :key="id">

            <div
                class="inline-flex items-center gap-2 px-2 py-1 rounded-md bg-white/10 border border-white/10 text-xs text-white">

                <i :class="item(id)?.type === 'course' ? 'fas fa-graduation-cap' : 'fas fa-box'"></i>

                <span x-text="item(id)?.title"></span>

                <button type="button" @click="remove(id)" class="text-white/40 hover:text-red-400">
                    ×
                </button>

                <input type="hidden" :name="'{{ $name }}[]'" :value="id">

            </div>

        </template>

    </div>

</div>

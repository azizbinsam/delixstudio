Alpine.data('searchModal', () => ({
    open: false,
    query: '',
    results: {},
    loading: false,
    activeIndex: -1,
    flatResults: [],

    init() {
        window.addEventListener('keydown', (e) => {
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                this.openModal();
            }
            if (e.key === 'Escape') this.close();
            if (e.key === 'ArrowDown') { e.preventDefault(); this.moveDown(); }
            if (e.key === 'ArrowUp') { e.preventDefault(); this.moveUp(); }
            if (e.key === 'Enter' && this.activeIndex >= 0) this.goToActive();
        });

        window.addEventListener('open-search', () => this.openModal());
    },

    openModal() {
        this.open = true;
        this.query = '';
        this.results = {};
        this.flatResults = [];
        this.activeIndex = -1;
        this.$nextTick(() => this.$refs.input?.focus());
    },

    close() {
        this.open = false;
        this.query = '';
        this.results = {};
        this.activeIndex = -1;
    },

    async search() {
        if (this.query.trim().length < 2) {
            this.results = {};
            this.flatResults = [];
            this.activeIndex = -1;
            return;
        }
        this.loading = true;
        const res = await fetch('/search?q=' + encodeURIComponent(this.query), {
            headers: { 'Accept': 'application/json' }
        });
        const data = await res.json();
        this.results = data;
        this.flatResults = Object.values(data).flat();
        this.activeIndex = -1;
        this.loading = false;
    },

    moveDown() {
        if (this.flatResults.length === 0) return;
        this.activeIndex = (this.activeIndex + 1) % this.flatResults.length;
        this.scrollToActive();
    },

    moveUp() {
        if (this.flatResults.length === 0) return;
        this.activeIndex = (this.activeIndex - 1 + this.flatResults.length) % this.flatResults.length;
        this.scrollToActive();
    },

    scrollToActive() {
        this.$nextTick(() => {
            const el = this.$refs.resultList?.querySelector('[data-active="true"]');
            el?.scrollIntoView({ block: 'nearest' });
        });
    },

    goToActive() {
        const item = this.flatResults[this.activeIndex];
        if (item?.url) window.location.href = item.url;
    },

    get hasResults() {
        return Object.values(this.results).some(group => group.length > 0);
    },

    get totalResults() {
        return Object.values(this.results).reduce((acc, group) => acc + group.length, 0);
    },

    globalIndex(groupKey, itemIndex) {
        const keys = Object.keys(this.results);
        let count = 0;
        for (const key of keys) {
            if (key === groupKey) return count + itemIndex;
            count += this.results[key].length;
        }
        return -1;
    }
}));
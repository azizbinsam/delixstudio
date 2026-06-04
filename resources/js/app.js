// resources/js/app.js
import './bootstrap';
import './search-modal';
import initAnimations from './animations';
import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';
import Collapse from '@alpinejs/collapse'

Alpine.plugin(Collapse)

window.flatpickr = flatpickr;

// Flatpickr init
function initFlatpickr() {
    document.querySelectorAll('input[type="date"].input').forEach(el => {
        if (el._flatpickr) return;
        flatpickr(el, {
            dateFormat: 'd-m-Y',
            allowInput: true,
            disableMobile: true,
        });
    });
}

window.initFlatpickr = initFlatpickr;

// Animations init
function initAnimController() {
    if (window._animController) window._animController.abort();
    window._animController = new AbortController();

    initAnimations();

    document.addEventListener('livewire:navigated', () => {
        initAnimations();
    }, { signal: window._animController.signal });
}

document.addEventListener('DOMContentLoaded', () => {
    initFlatpickr();
    initAnimController();
});

document.addEventListener('livewire:navigated', initFlatpickr);

// Tutup dropdown saat wire:navigate
document.addEventListener('livewire:navigate', () => {
    document.querySelectorAll('[x-data]').forEach(el => {
        if (el._x_dataStack) {
            el._x_dataStack.forEach(data => {
                if ('open' in data) data.open = false;
                if ('mobileOpen' in data) data.mobileOpen = false;
            });
        }
    });
});
// resources/js/admin.js
import Choices from 'choices.js';
import 'choices.js/public/assets/styles/choices.min.css';

// ================================
// Choices.js Init
// ================================
function initChoices() {
    document.querySelectorAll('select.input').forEach(el => {
        if (el.closest('[wire\\:id]')) return;

        if (el.options.length <= 5) return;
        
        if (el.choicesInstance) {
            el.choicesInstance.destroy();
            el.choicesInstance = null;
        }
        el.choicesInstance = new Choices(el, {
            searchEnabled: true,
            itemSelectText: '',
            searchPlaceholderValue: 'Cari...',
            shouldSort: false,
        });
    });
}

document.addEventListener('DOMContentLoaded', initChoices);
document.addEventListener('livewire:navigated', initChoices);
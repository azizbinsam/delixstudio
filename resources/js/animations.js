// resources/js/animations.js
function initAnimations() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.anim').forEach(el => {
        el.classList.remove('animate-in');
        observer.observe(el);
    });
}

export default initAnimations;
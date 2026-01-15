import './bootstrap';

import Alpine from 'alpinejs';

// Plugin para animaciones de scroll
Alpine.data('scrollReveal', (delay = 0) => ({
    show: false,
    init() {
        // Verificar si el elemento ya está visible al cargar
        const checkVisibility = () => {
            const rect = this.$el.getBoundingClientRect();
            const isVisible = rect.top < window.innerHeight && rect.bottom > 0;
            
            if (isVisible) {
                setTimeout(() => {
                    this.show = true;
                }, delay);
                return true;
            }
            return false;
        };
        
        // Si ya está visible, mostrarlo inmediatamente
        if (checkVisibility()) {
            return;
        }
        
        // Si no, usar IntersectionObserver
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        this.show = true;
                    }, delay);
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });
        
        observer.observe(this.$el);
        
        // También verificar después de un pequeño delay por si acaso
        setTimeout(() => {
            if (!this.show) {
                checkVisibility();
            }
        }, 100);
    }
}));

window.Alpine = Alpine;

Alpine.start();

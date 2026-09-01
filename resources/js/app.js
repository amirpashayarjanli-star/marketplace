import Alpine from 'alpinejs';
import './phone-validation.js';

/*
 | اسلایدر هیرو
 | ---------------------------------------------------------------
 | خودش می‌چرخه، با hover مکث می‌کنه، و اگر کاربر تنظیم «کاهش
 | حرکت» رو روشن کرده باشه اصلاً چرخش خودکار نداره.
 */
Alpine.data('heroSlider', (count = 0) => ({

    current: 0,
    timer: null,

    go(i) {
        this.current = i;
        this.restart();
    },

    next() {
        if (count > 1) {
            this.current = (this.current + 1) % count;
        }
    },

    start() {
        if (count < 2) return;
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

        this.timer = setInterval(() => this.next(), 5000);
    },

    stop() {
        if (this.timer) {
            clearInterval(this.timer);
            this.timer = null;
        }
    },

    restart() {
        this.stop();
        this.start();
    },
}));

window.Alpine = Alpine;

Alpine.start();

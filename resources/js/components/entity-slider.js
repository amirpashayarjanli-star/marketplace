class EntitySlider {

    constructor(section) {

        this.section = section;
        this.track = section.querySelector('.entity-track');
        this.cards = [...this.track.children];

        if (!this.cards.length) return;

        this.prev = section.querySelector('.slider-prev');
        this.next = section.querySelector('.slider-next');
        this.pagination = section.querySelector('.slider-pagination');

        this.index = 0;

        this.visible = this.getVisible();

        this.cardWidth = 0;

        this.startX = 0;
        this.currentX = 0;
        this.dragging = false;

        this.update();

        this.events();

        this.createPagination();

        this.autoPlay();

    }

    getVisible() {

        if (window.innerWidth <= 576) return 1;

        if (window.innerWidth <= 768) return 2;

        if (window.innerWidth <= 1200) return 4;

        return 6;

    }

    update() {

        this.visible = this.getVisible();

        this.cardWidth = this.cards[0].offsetWidth + 24;

        this.go(this.index, false);

    }

    maxIndex() {

        return Math.max(this.cards.length - this.visible, 0);

    }

    go(index, animate = true) {

        if (index > this.maxIndex()) index = 0;

        if (index < 0) index = this.maxIndex();

        this.index = index;

        this.track.style.transition = animate ? '.45s ease' : 'none';

        this.track.style.transform =
            `translateX(-${this.index * this.cardWidth}px)`;

        this.updatePagination();

    }

    nextSlide() {

        this.go(this.index + 1);

    }

    prevSlide() {

        this.go(this.index - 1);

    }

    createPagination() {

        this.pagination.innerHTML = '';

        for (let i = 0; i <= this.maxIndex(); i++) {

            const dot = document.createElement('button');

            if (i === 0) dot.classList.add('active');

            dot.addEventListener('click', () => this.go(i));

            this.pagination.appendChild(dot);

        }

    }

    updatePagination() {

        [...this.pagination.children].forEach((dot, i) => {

            dot.classList.toggle('active', i === this.index);

        });

    }

    autoPlay() {

        setInterval(() => {

            this.nextSlide();

        }, 4500);

    }

    events() {

        this.next.addEventListener('click', () => this.nextSlide());

        this.prev.addEventListener('click', () => this.prevSlide());

        window.addEventListener('resize', () => {

            this.update();

            this.createPagination();

        });

        this.track.addEventListener('touchstart', e => {

            this.startX = e.touches[0].clientX;

        });

        this.track.addEventListener('touchend', e => {

            this.currentX = e.changedTouches[0].clientX;

            if (this.startX - this.currentX > 60) this.nextSlide();

            if (this.currentX - this.startX > 60) this.prevSlide();

        });

        document.addEventListener('keydown', e => {

            if (e.key === 'ArrowLeft') this.nextSlide();

            if (e.key === 'ArrowRight') this.prevSlide();

        });

    }

}

document.addEventListener('DOMContentLoaded', () => {

    document
        .querySelectorAll('.entity-slider-section')
        .forEach(section => new EntitySlider(section));

});
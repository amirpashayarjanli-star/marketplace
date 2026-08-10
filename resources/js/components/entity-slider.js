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


        this.isDragging = false;
        this.startX = 0;
        this.currentTranslate = 0;
        this.prevTranslate = 0;


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

        return Math.max(
            this.cards.length - this.visible,
            0
        );

    }



    go(index, animate = true) {


        if (index > this.maxIndex())
            index = 0;


        if (index < 0)
            index = this.maxIndex();



        this.index = index;



        this.track.style.transition = animate
            ? 'transform .45s ease'
            : 'none';



        this.currentTranslate =
            this.index * this.cardWidth;



        this.prevTranslate =
            this.currentTranslate;



        this.track.style.transform =
            `translateX(${this.currentTranslate}px)`;


        this.updatePagination();

    }





    nextSlide() {

        this.go(this.index + 1);

    }




    prevSlide() {

        this.go(this.index - 1);

    }






    createPagination() {


        this.pagination.innerHTML = "";


        for(
            let i = 0;
            i <= this.maxIndex();
            i++
        ){


            let dot = document.createElement('button');


            if(i === 0)
                dot.classList.add('active');



            dot.onclick = () => this.go(i);


            this.pagination.appendChild(dot);

        }


    }





    updatePagination(){

        [
            ...this.pagination.children
        ].forEach((dot,i)=>{

            dot.classList.toggle(
                'active',
                i === this.index
            );

        });

    }







    events(){



        this.next.onclick =
            ()=> this.nextSlide();



        this.prev.onclick =
            ()=> this.prevSlide();





        window.addEventListener(
            'resize',
            ()=>{
                this.update();
                this.createPagination();
            }
        );





        // Mouse Drag

        this.track.addEventListener(
            'mousedown',
            e=>{


                this.isDragging = true;


                this.startX = e.clientX;


                this.track.style.transition='none';


                this.section.classList.add(
                    'dragging'
                );


            }
        );





        window.addEventListener(
            'mouseup',
            ()=>{


                if(!this.isDragging)
                    return;


                this.isDragging=false;


                this.section.classList.remove(
                    'dragging'
                );


                let moved =
                    this.currentTranslate -
                    this.prevTranslate;



                if(moved > 80)
                    this.nextSlide();



                if(moved < -80)
                    this.prevSlide();



                else
                    this.go(this.index);


            }
        );







        window.addEventListener(
            'mousemove',
            e=>{


                if(!this.isDragging)
                    return;



                let diff =
                    e.clientX -
                    this.startX;



                this.track.style.transform =
                    `translateX(${this.currentTranslate + diff}px)`;


            }
        );






        // Touch

        this.track.addEventListener(
            'touchstart',
            e=>{

                this.startX =
                    e.touches[0].clientX;

            }
        );



        this.track.addEventListener(
            'touchend',
            e=>{


                let endX =
                    e.changedTouches[0].clientX;



                if(this.startX - endX > 60)
                    this.nextSlide();



                if(endX - this.startX > 60)
                    this.prevSlide();



            }
        );


    }







    autoPlay(){

        setInterval(
            ()=>this.nextSlide(),
            5000
        );

    }


}





document.addEventListener(
    'DOMContentLoaded',
    ()=>{


        document
        .querySelectorAll('.entity-slider-section')
        .forEach(
            section=>new EntitySlider(section)
        );


    }
);

/**
 * Topbar Slider js
 *
 * @package woostify
 */

'use strict';

function TopbarMarqueeSlider() {
    // Play with this value to change the speed
    let tickerSpeed = 1;
    let flickity = null;
    let isPaused = false;
    const slideshowEl = document.querySelector('.topbar-slider .slider');

    if ( !slideshowEl && slideshowEl.length == 0 ) {
        return;
    }

    const slideshowElItem = slideshowEl.querySelectorAll('.slider-item');
    let slideshowElItemLength = slideshowElItem.length;
    slideshowElItem.forEach(ele => {
        ele.style.minWidth = (100 / slideshowElItemLength) + '%';
    });
    
    //   Functions
    const update = () => {
        if (isPaused) return;
        if (flickity.slides) {
            flickity.x -= tickerSpeed;
            flickity.selectedIndex = flickity.dragEndRestingSelect();
            flickity.updateSelectedSlide();
            flickity.settle(flickity.x);
        }
        window.requestAnimationFrame(update);
    };

    const pause = () => {
        isPaused = true;
    };

    const play = () => {
        if (isPaused) {
            isPaused = false;
            window.requestAnimationFrame(update);
        }
    };

    if (slideshowEl) {
        //   Create Flickity
        flickity = new Flickity('.topbar-slider .slider', {
            autoPlay: false,
            prevNextButtons: false,
            pageDots: false,
            draggable: true,
            wrapAround: true,
            selectedAttraction: 0.01,
            friction: 0.25,
            freeScroll: true,
            resize: true,
            cellAlign: 'left'
        });
        flickity.x = 0;

        // Pause on hover/focus
        slideshowEl.addEventListener('mouseenter', () => pause());

        // Unpause on mouse out / defocus
        slideshowEl.addEventListener('mouseleave', () => play());

        flickity.on('dragStart', () => {
            isPaused = true;
        });

        //   Start Ticker
        update();
    }

    window.dispatchEvent(new Event('resize'));
}

window.addEventListener('load', function() {
    TopbarMarqueeSlider();
});

document.addEventListener('DOMContentLoaded', function () {  
    
});

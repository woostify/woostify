/**
 * Topbar Slider js
 *
 * @package woostify
 */

'use strict';

var TopbarSliderMarquee = function() {
    // Play with this value to change the speed
    let tickerSpeed = 1;
    let flickity = null;
    let isPaused = false;
    var slideshowEl = document.querySelector('.topbar-slider .slider');

    if ( !slideshowEl && slideshowEl.length == 0 ) {
        return;
    }

    var slideshowElItem = slideshowEl.querySelectorAll('.slider-item');
    let slideshowElItemLength = slideshowElItem.length;
    slideshowElItem.forEach(ele => {
        ele.style.minWidth = (100 / slideshowElItemLength) + '%';
    });
    
    //   Functions
    const dupliateItem = (flickity, index) => {
        var slider = document.querySelector('.topbar-slider .slider .flickity-slider');
        var itemToClone = slider.children[index];
        var clone = itemToClone.cloneNode(true);
        slider.appendChild(clone);
        flickity.append(clone); // Update Flickity
    }

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

        for (let index = 0; index < slideshowElItemLength; index++) {
            dupliateItem(flickity,index);
        }

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
    TopbarSliderMarquee();
});

document.addEventListener('DOMContentLoaded', function () {  
    
});

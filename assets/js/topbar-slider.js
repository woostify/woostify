/**
 * Topbar Slider js
 *
 * @package woostify
 */

'use strict';


var TopbarSlider = function() {  

    var topbarSlider = document.querySelector('.topbar-slider');

    if ( !topbarSlider && topbarSlider.length == 0 ) {
        return;
    }

    var slideshowEl = topbarSlider.querySelector('.slider');

    if ( !slideshowEl && slideshowEl.length == 0 ) {
        return;
    }

    var flickityOptions = {
        // autoPlay: true,
        prevNextButtons: false,
        pageDots: false,
        wrapAround: true,
    }

    var flickitySlider = new Flickity(slideshowEl, flickityOptions);
}

document.addEventListener('DOMContentLoaded', function () {  
    TopbarSlider();
});

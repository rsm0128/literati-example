/**
 * Use this file for JavaScript code that you want to run in the front-end
 * on posts/pages that contain this block.
 *
 * When this file is defined as the value of the `viewScript` property
 * in `block.json` it will be enqueued on the front end of the site.
 *
 * Example:
 *
 * ```js
 * {
 *   "viewScript": "file:./view.js"
 * }
 * ```
 *
 * If you're not making any changes to this file because your project doesn't need any
 * JavaScript running in the front-end, then you should delete this file and remove
 * the `viewScript` property from `block.json`.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-metadata/#view-script
 */
import { Swiper } from 'swiper';
import { Autoplay, Navigation } from 'swiper/modules';

document.addEventListener( 'DOMContentLoaded', () => {

    const containers = document.querySelectorAll( '.carousel-items' );

	// Return early, and often.
	if ( ! containers.length ) {
		return;
	}

	// Loop through all sliders and assign Swiper object.
	containers.forEach( ( slider ) => {
		// We could pass in some unique options here.
		let options = {};
        
		try {
            options = JSON.parse( slider.dataset.swiper );
		} catch ( e ) {
			// eslint-disable-next-line no-console
			console.error( e );
			return;
		}

        const slideWrapper = slider.querySelector('.swiper-wrapper');
        const slideItems = slider.querySelectorAll('.carousel-item');
        
        // If slide counts is smaller than 2, set slidesPerView 1.
        let slidesPerView = 2;
        if ( slideItems.length < 2 ) {
            slidesPerView = 1;
        }

        // Fix slide count is smaller than double of slidesPerView.
        if ( slidesPerView * 2 > slideItems.length ) {
            slideItems.forEach(item => {
                const clonedItem = item.cloneNode(true);
                slideWrapper.appendChild(clonedItem)
            })
        }

		// Slider
		new Swiper( '.carousel-items', {
            autoplay: {
                delay: options.autoplay.delay ?? 3000,
                disableOnInteraction: false,
            },
            centeredSlides: true,
            grabCursor: true,
            loop: true,
            modules: [ Autoplay, Navigation ],
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev"
            },
            slidesPerView: 1,
            breakpoints: {
                768: {
                    slidesPerView,
                }
            }
        });
	} );
} );

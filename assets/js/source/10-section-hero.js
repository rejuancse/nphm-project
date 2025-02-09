/**
 * Section: Hero
 */


(function (){
	'use strict';

	document.addEventListener('DOMContentLoaded', function (){
		if ( document.querySelectorAll('.section-hero__slider').length>0 ){
			document.querySelectorAll('.section-hero__slider').forEach(function (item){
				let heroSlider = new Splide(item, {
					perPage: 1,
					type: 'loop',
					breakpoints: {
						781: {
							arrows: false,
						},
					}
				});

				heroSlider.mount();
			});
		}
	});

})();
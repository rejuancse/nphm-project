/**
 * Block / Highlight Cards
 */

(function (){
	'use strict';

	document.addEventListener('DOMContentLoaded', function (){
		if ( document.querySelectorAll('.block-highlight-cards.splide').length>0 ){
			document.querySelectorAll('.block-highlight-cards.splide').forEach(function (item){
				let perPage = ( item.dataset.perpage ) ? item.dataset.perpage : 3.5;
				let args = {
					gap: '2.5rem',
					pagination: false,
					perPage: perPage,
					type: 'slide',
					breakpoints: {
						1024: {
							gap: '1.25rem'
						},
						781: {
							arrows: false,
							perPage: 2
						},
						550: {
							perPage: 1
						}
					}
				};
				let highlightCards = new Splide(item, args);
				let highlightCards_progressBar = highlightCards.root.querySelector('.splide__progress-bar');

				highlightCards.on('mounted move', function (){
					let end  = highlightCards.Components.Controller.getEnd() + 1;
					let rate = Math.min((highlightCards.index + 1) / end, 1);

					highlightCards_progressBar.style.width = String(100 * rate) + '%';
				});

				highlightCards.mount();
			});
		}
	});

})();
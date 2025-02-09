/**
 * Block / Layered caption gallery
 */

(function (){
	'use strict';

	document.addEventListener('DOMContentLoaded', function (){
		if ( document.querySelectorAll('.block-layered-caption-gallery').length>0 ){
			document.querySelectorAll('.block-layered-caption-gallery').forEach(function (item){
				let layeredCaptionGallery = new Masonry(item, {
					itemSelector: '.block-layered-caption-gallery__item',
					columnWidth: '.block-layered-caption-gallery__grid-sizer',
					percentPosition: true
				});

				imagesLoaded(item).on('progress', function(){
					layeredCaptionGallery.layout();
				});
				imagesLoaded(item).on('done', function(){
					layeredCaptionGallery.layout();
					setTimeout(function(){
						layeredCaptionGallery.layout();
					}, 1500);
					setTimeout(function(){
						layeredCaptionGallery.layout();
					}, 3000);
					setTimeout(function(){
						layeredCaptionGallery.layout();
					}, 5000);
				});
			});
		}
	});

})();
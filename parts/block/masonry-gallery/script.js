/**
 * Block / Masonry gallery
 */

(function (){
	'use strict';

	document.addEventListener('DOMContentLoaded', function (){
		if ( document.querySelectorAll('.block-masonry-gallery').length>0 ){
			document.querySelectorAll('.block-masonry-gallery').forEach(function (item){
				let masonryGallery = new Masonry(item, {
					itemSelector: '.block-masonry-gallery__item',
					percentPosition: true
				});

				imagesLoaded(item).on('progress', function(){
					masonryGallery.layout();
				});
				imagesLoaded(item).on('done', function(){
					masonryGallery.layout();
					setTimeout(function(){
						masonryGallery.layout();
					}, 1500);
					setTimeout(function(){
						masonryGallery.layout();
					}, 3000);
					setTimeout(function(){
						masonryGallery.layout();
					}, 5000);
				});
			});
		}
	});

})();
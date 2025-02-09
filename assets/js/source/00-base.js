/**
 * Base
 */

(function (){
	'use strict';

	/*** Header ***/
	document.addEventListener('DOMContentLoaded', function (){
		document.getElementById('navbar-toggle').addEventListener('click', function (e){
			document.body.classList.toggle('is-menu-active');
		});
	});

	// Check if scrolled
	function isScrolled(){
		const scrollpos = window.scrollY;
	
		if ( scrollpos>10 ){
			document.body.classList.add('is-scrolled');
		}
		else {
			document.body.classList.remove('is-scrolled');
		}
	}
	document.addEventListener('DOMContentLoaded', isScrolled);
	window.addEventListener('scroll', isScrolled);

	// Mobile menu
	document.addEventListener('DOMContentLoaded', function (){
		if ( document.querySelectorAll('.sub-menu-toggle').length>0 ){
			[].forEach.call(document.querySelectorAll('.sub-menu-toggle'), function (item){
				item.addEventListener('click', function (e){
					e.preventDefault();

					if ( document.querySelectorAll('.primary-menu .menu-item.is-open').length>0 ){ console.log('2');
						if ( document.querySelector('.primary-menu .menu-item.is-open .sub-menu-toggle')!==item ){ console.log('3');
							document.querySelector('.primary-menu .menu-item.is-open').classList.remove('is-open');
							item.closest('.menu-item').classList.add('is-open');
						} else { console.log('4');
							document.querySelector('.primary-menu .menu-item.is-open').classList.remove('is-open');
							item.closest('.primary-menu').classList.remove('is-sub-menu-open');
						}
					} else { console.log('1'); console.log(document.querySelector('.primary-menu'));
						item.closest('.menu-item').classList.add('is-open');
						item.closest('.primary-menu').classList.add('is-sub-menu-open');
					}
				});
			});
		}
	});

	
	// Search panel
	document.addEventListener("DOMContentLoaded", function(){
		[].forEach.call(document.querySelectorAll('.site-header__search-toggle'), function (item){
			item.addEventListener('click', function (e){
				e.preventDefault();

				document.body.classList.toggle('is-search-active');
			});
		});
	});


	/*** Slide to section on anchor ***/
	document.addEventListener('DOMContentLoaded', function (){
		if ( document.querySelectorAll('a[href^="#slide-"]').length>0 ){
			[].forEach.call(document.querySelectorAll('a[href^="#slide-"]'), function (item){
				item.addEventListener('click', function (e){
					e.preventDefault();

					if ( document.getElementById( item.getAttribute('href').replace('#', '') ) ){
						let targetId = item.getAttribute('href').replace('#', '');
						let targetOffsetTop = document.getElementById(targetId).getBoundingClientRect().top + window.scrollY - document.getElementById('header').offsetHeight;

						if ( document.querySelectorAll('#wpadminbar').length>0 ){
							targetOffsetTop -= document.getElementById('wpadminbar').offsetHeight;
						}

						window.scroll({
							top: targetOffsetTop,
							behavior: 'smooth'
						});
					}
				});
			});
		}
	});

})();
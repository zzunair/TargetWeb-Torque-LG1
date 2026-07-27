/**
 * Site-wide header/footer behavior: sticky header shadow, mobile menu
 * toggle, and the footer copyright year.
 */
( function () {
	'use strict';

	// Sticky header shadow on scroll.
	var header = document.getElementById( 'siteHeader' );
	if ( header ) {
		var onScroll = function () {
			header.classList.toggle( 'scrolled', window.scrollY > 12 );
		};
		document.addEventListener( 'scroll', onScroll, { passive: true } );
		onScroll();
	}

	// Mobile menu toggle.
	var toggle = document.getElementById( 'menuToggle' );
	var mobileNav = document.getElementById( 'mobileNav' );
	if ( toggle && mobileNav ) {
		toggle.addEventListener( 'click', function () {
			var open = toggle.getAttribute( 'aria-expanded' ) === 'true';
			toggle.setAttribute( 'aria-expanded', String( ! open ) );
			mobileNav.hidden = open;
		} );
		mobileNav.querySelectorAll( 'a' ).forEach( function ( a ) {
			a.addEventListener( 'click', function () {
				toggle.setAttribute( 'aria-expanded', 'false' );
				mobileNav.hidden = true;
			} );
		} );
	}

	// Footer year.
	var year = document.getElementById( 'year' );
	if ( year ) {
		year.textContent = new Date().getFullYear();
	}

	// Reveal-on-scroll: any element with the ".reveal" class fades/slides
	// into view once it enters the viewport. Shared across all section
	// blocks (stats, cards, etc.) rather than duplicated per block.
	if ( 'IntersectionObserver' in window ) {
		var revealObserver = new IntersectionObserver(
			function ( entries ) {
				entries.forEach( function ( entry ) {
					if ( entry.isIntersecting ) {
						entry.target.classList.add( 'in-view' );
						revealObserver.unobserve( entry.target );
					}
				} );
			},
			{ threshold: 0.15 }
		);
		document.querySelectorAll( '.reveal' ).forEach( function ( el ) {
			revealObserver.observe( el );
		} );
	}
} )();

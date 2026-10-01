/* global wp, jQuery */
/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Brand colours. Each picker writes straight to the design token it owns,
	// so every rule built on that token updates without a preview reload.

	// Kept in sync with power_equipment_leads_contrast_ink() in inc/colors.php.
	const contrastInk = ( hex ) => {
		const channels = String( hex ).replace( '#', '' ).match( /^(\w\w)(\w\w)(\w\w)$/ );

		if ( ! channels ) {
			return '#0b0d10';
		}

		const luminance = [ 0.2126, 0.7152, 0.0722 ].reduce( ( total, weight, index ) => {
			const channel = parseInt( channels[ index + 1 ], 16 ) / 255;
			const linear = channel <= 0.04045 ? channel / 12.92 : Math.pow( ( channel + 0.055 ) / 1.055, 2.4 );

			return total + ( weight * linear );
		}, 0 );

		return luminance > 0.179 ? '#0b0d10' : '#ffffff';
	};

	const brandColors = {
		pel_color_primary: { property: '--primary', inkProperty: '--primary-foreground' },
		pel_color_secondary: { property: '--ember' },
	};

	Object.keys( brandColors ).forEach( ( setting ) => {
		const token = brandColors[ setting ];

		wp.customize( setting, ( value ) => {
			value.bind( ( to ) => {
				document.documentElement.style.setProperty( token.property, to );

				if ( token.inkProperty ) {
					document.documentElement.style.setProperty( token.inkProperty, contrastInk( to ) );
				}
			} );
		} );
	} );
}( jQuery ) );

<?php
/**
 * Brand Ticker section — a scrolling marquee of brand names.
 *
 * Content editable via Appearance > Customize > Homepage Sections > 3. Brand Ticker.
 *
 * @package Power_Equipment_Leads
 */

if ( ! power_equipment_leads_get_ticker_setting( 'show' ) ) {
	return;
}

$brands = power_equipment_leads_get_ticker_brands();

if ( ! $brands ) {
	return;
}

// Duplicate the list so the CSS marquee (-50%) loops seamlessly.
$brands = array_merge( $brands, $brands );
?>
<div class="ticker" aria-hidden="true">
	<div class="ticker__track animate-ticker">
		<?php foreach ( $brands as $brand ) : ?>
			<span class="ticker__item"><?php echo esc_html( $brand ); ?> <span class="ticker__dot">+</span></span>
		<?php endforeach; ?>
	</div>
</div>

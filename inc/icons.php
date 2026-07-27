<?php
/**
 * Minimal inline-SVG icon set used across the homepage sections, so we don't
 * need an icon font or extra HTTP requests. Markup/paths follow the Lucide
 * (MIT licensed) icon shapes at a 24x24 viewBox, stroke-based style.
 *
 * @package Power_Equipment_Leads
 */

/**
 * Returns (or echoes) an inline SVG icon.
 *
 * @param string $name  Icon slug, see $icons keys below.
 * @param string $class Extra CSS class(es) for the <svg>.
 * @param bool   $echo  Whether to echo (default) or return the markup.
 * @return string|void
 */
function power_equipment_leads_icon( $name, $class = '', $echo = true ) {
	$icons = array(
		'flame'        => '<path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"/>',
		'shield'       => '<path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.8 17 5 19 5a1 1 0 0 1 1 1z"/>',
		'truck'        => '<path d="M14 18V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h1"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/>',
		'award'        => '<circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/>',
		'wrench'       => '<path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94z"/>',
		'cart'         => '<circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 2-1.58l1.65-7.42H5.12"/>',
		'cog'          => '<path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/>',
		'package'      => '<path d="M11 21.73a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73z"/><path d="M12 22V12"/><path d="M3.3 7 12 12l8.7-5"/><path d="m7.5 4.27 9 5.15"/>',
		'credit-card'  => '<rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/>',
		'star'         => '<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>',
		'plus'         => '<path d="M5 12h14"/><path d="M12 5v14"/>',
		'minus'        => '<path d="M5 12h14"/>',
		'chevron-right'=> '<path d="m9 18 6-6-6-6"/>',
		'arrow-right'  => '<path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>',
		'map-pin'      => '<path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/>',
		'clock'        => '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>',
		'phone'        => '<path d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.804 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384"/>',
		'mail'         => '<rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>',
		'menu'         => '<line x1="4" y1="6" x2="20" y2="6"/><line x1="4" y1="12" x2="20" y2="12"/><line x1="4" y1="18" x2="20" y2="18"/>',
	);

	if ( ! isset( $icons[ $name ] ) ) {
		return '';
	}

	$markup = sprintf(
		'<svg class="icon %s" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">%s</svg>',
		esc_attr( $class ),
		$icons[ $name ] // phpcs:ignore -- fixed, hand-written SVG path data, no user input.
	);

	if ( ! $echo ) {
		return $markup;
	}

	echo $markup; // phpcs:ignore WordPress.Security.EscapeOutput -- fixed markup built above.
}

/**
 * Choices for Customizer "select an icon" controls (Services section).
 *
 * @return array<string,string>
 */
function power_equipment_leads_icon_choices() {
	return array(
		'cart'        => esc_html__( 'Shopping Cart', 'power-equipment-leads' ),
		'wrench'      => esc_html__( 'Wrench', 'power-equipment-leads' ),
		'cog'         => esc_html__( 'Gear / Cog', 'power-equipment-leads' ),
		'package'     => esc_html__( 'Package / Parts', 'power-equipment-leads' ),
		'credit-card' => esc_html__( 'Credit Card', 'power-equipment-leads' ),
		'shield'      => esc_html__( 'Shield', 'power-equipment-leads' ),
		'truck'       => esc_html__( 'Truck', 'power-equipment-leads' ),
		'award'       => esc_html__( 'Award', 'power-equipment-leads' ),
		'star'        => esc_html__( 'Star', 'power-equipment-leads' ),
		'flame'       => esc_html__( 'Flame', 'power-equipment-leads' ),
		'clock'       => esc_html__( 'Clock', 'power-equipment-leads' ),
		'phone'       => esc_html__( 'Phone', 'power-equipment-leads' ),
		'mail'        => esc_html__( 'Mail', 'power-equipment-leads' ),
		'map-pin'     => esc_html__( 'Map Pin', 'power-equipment-leads' ),
	);
}

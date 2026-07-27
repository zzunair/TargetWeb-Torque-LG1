<?php
/**
 * Field definitions for the scrolling Brand Ticker section.
 *
 * @package Power_Equipment_Leads
 */

/**
 * @return array
 */
function power_equipment_leads_ticker_field_defs() {
	return array(
		'show'   => array(
			'label'    => esc_html__( 'Show Brand Ticker Section', 'power-equipment-leads' ),
			'type'     => 'checkbox',
			'default'  => true,
			'sanitize' => 'power_equipment_leads_sanitize_checkbox',
		),
		'brands' => array(
			'label'   => esc_html__( 'Brand Names (comma separated)', 'power-equipment-leads' ),
			'type'    => 'textarea',
			'default' => 'TORO, KUBOTA, STIHL, HUSQVARNA, CUB CADET, GRAVELY, GENERAC, ARIENS, ECHO, HONDA',
		),
	);
}

/**
 * Reads a Brand Ticker section setting.
 *
 * @param string $key Field key, see power_equipment_leads_ticker_field_defs().
 * @return mixed
 */
function power_equipment_leads_get_ticker_setting( $key ) {
	return power_equipment_leads_get_section_setting( power_equipment_leads_ticker_field_defs(), 'pel_ticker_', $key );
}

/**
 * Returns the ticker brand names as a clean array.
 *
 * @return string[]
 */
function power_equipment_leads_get_ticker_brands() {
	$raw = power_equipment_leads_get_ticker_setting( 'brands' );
	$list = array_map( 'trim', explode( ',', (string) $raw ) );
	return array_values( array_filter( $list ) );
}

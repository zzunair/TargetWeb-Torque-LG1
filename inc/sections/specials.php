<?php
/**
 * Field definitions for the Specials section (3 fixed offer cards).
 *
 * @package Power_Equipment_Leads
 */

/**
 * @return array
 */
function power_equipment_leads_specials_field_defs() {
	$defs = array(
		'show'       => array(
			'label'    => esc_html__( 'Show Specials Section', 'power-equipment-leads' ),
			'type'     => 'checkbox',
			'default'  => true,
			'sanitize' => 'power_equipment_leads_sanitize_checkbox',
		),
		'section_id' => array(
			'label'   => esc_html__( 'Anchor id (no #)', 'power-equipment-leads' ),
			'default' => 'specials',
		),
		'eyebrow'    => array(
			'label'   => esc_html__( 'Eyebrow', 'power-equipment-leads' ),
			'default' => 'This Month',
		),
		'heading'    => array(
			'label'   => esc_html__( 'Heading', 'power-equipment-leads' ),
			'default' => 'Current Specials.',
		),
		'copy'       => array(
			'label'   => esc_html__( 'Intro Copy', 'power-equipment-leads' ),
			'type'    => 'textarea',
			'default' => "Real inventory, real markdowns. Updated weekly, gone when they're gone.",
		),
		'cta_text'   => array(
			'label'   => esc_html__( '"See All Deals" Button Text', 'power-equipment-leads' ),
			'default' => 'See All Deals',
		),
		'cta_link'   => array(
			'label'   => esc_html__( '"See All Deals" Button Link', 'power-equipment-leads' ),
			'default' => '#quote',
		),
	);

	$defaults = array(
		1 => array(
			'label' => 'SAVE $800',
			'title' => 'Titan 60" Zero-Turn',
			'price' => '$6,499',
			'was'   => '$7,299',
			'tag'   => 'In stock — 4 units',
		),
		2 => array(
			'label' => '0% APR / 48 MO',
			'title' => 'Compact Utility Tractor Package',
			'price' => '$0 Down',
			'was'   => 'Financing',
			'tag'   => 'Includes loader & bucket',
		),
		3 => array(
			'label' => 'SEASONAL',
			'title' => 'Chainsaw + Chain Bundle',
			'price' => '$429',
			'was'   => '$519',
			'tag'   => 'Free bar oil for a year',
		),
	);

	foreach ( $defaults as $i => $special ) {
		foreach ( $special as $field => $default ) {
			$defs[ "special{$i}_{$field}" ] = array(
				/* translators: 1: special number, 1-3. 2: field name, e.g. "label". */
				'label'   => sprintf( esc_html__( 'Special %1$d — %2$s', 'power-equipment-leads' ), $i, ucfirst( $field ) ),
				'default' => $default,
			);
		}
	}

	return $defs;
}

/**
 * Reads a Specials section setting.
 *
 * @param string $key Field key, see power_equipment_leads_specials_field_defs().
 * @return mixed
 */
function power_equipment_leads_get_specials_setting( $key ) {
	return power_equipment_leads_get_section_setting( power_equipment_leads_specials_field_defs(), 'pel_specials_', $key );
}

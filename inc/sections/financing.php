<?php
/**
 * Field definitions for the Financing Banner section.
 *
 * @package Power_Equipment_Leads
 */

/**
 * @return array
 */
function power_equipment_leads_financing_field_defs() {
	$defs = array(
		'show'                  => array(
			'label'    => esc_html__( 'Show Financing Banner Section', 'power-equipment-leads' ),
			'type'     => 'checkbox',
			'default'  => true,
			'sanitize' => 'power_equipment_leads_sanitize_checkbox',
		),
		'section_id'            => array(
			'label'   => esc_html__( 'Anchor id (no #)', 'power-equipment-leads' ),
			'default' => 'financing',
		),
		'background_image'      => array(
			'label'    => esc_html__( 'Background Image', 'power-equipment-leads' ),
			'type'     => 'image',
			'default'  => '',
			'sanitize' => 'esc_url_raw',
		),
		'eyebrow'               => array(
			'label'   => esc_html__( 'Eyebrow', 'power-equipment-leads' ),
			'default' => 'Financing',
		),
		'heading_line1'         => array(
			'label'   => esc_html__( 'Heading Line 1', 'power-equipment-leads' ),
			'default' => '0% APR',
		),
		'heading_line2'         => array(
			'label'   => esc_html__( 'Heading Line 2 (accent color)', 'power-equipment-leads' ),
			'default' => '48 MONTHS.',
		),
		'copy'                  => array(
			'label'   => esc_html__( 'Copy', 'power-equipment-leads' ),
			'type'    => 'textarea',
			'default' => 'No games, no gimmicks. Get pre-approved in under three minutes with a soft credit check. Ride out the same day with the equipment you actually need.',
		),
		'primary_button_text'   => array(
			'label'   => esc_html__( 'Primary Button Text', 'power-equipment-leads' ),
			'default' => 'Pre-Qualify Now',
		),
		'primary_button_link'   => array(
			'label'   => esc_html__( 'Primary Button Link', 'power-equipment-leads' ),
			'default' => '#quote',
		),
		'secondary_button_text' => array(
			'label'   => esc_html__( 'Secondary Button Text', 'power-equipment-leads' ),
			'default' => 'Talk to Finance',
		),
	);

	$defaults = array(
		1 => array( 'value' => '3 MIN', 'label' => 'Application' ),
		2 => array( 'value' => '$0', 'label' => 'Down payment' ),
		3 => array( 'value' => '48 MO', 'label' => 'Terms available' ),
		4 => array( 'value' => '0%', 'label' => 'APR qualified' ),
	);

	foreach ( $defaults as $i => $stat ) {
		$defs[ "fact{$i}_value" ] = array(
			/* translators: %d: fact number, 1-4. */
			'label'   => sprintf( esc_html__( 'Fact %d Value', 'power-equipment-leads' ), $i ),
			'default' => $stat['value'],
		);
		$defs[ "fact{$i}_label" ] = array(
			/* translators: %d: fact number, 1-4. */
			'label'   => sprintf( esc_html__( 'Fact %d Label', 'power-equipment-leads' ), $i ),
			'default' => $stat['label'],
		);
	}

	return $defs;
}

/**
 * Reads a Financing Banner section setting.
 *
 * @param string $key Field key, see power_equipment_leads_financing_field_defs().
 * @return mixed
 */
function power_equipment_leads_get_financing_setting( $key ) {
	return power_equipment_leads_get_section_setting( power_equipment_leads_financing_field_defs(), 'pel_financing_', $key );
}

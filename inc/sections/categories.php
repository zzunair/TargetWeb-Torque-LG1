<?php
/**
 * Field definitions for the Equipment Categories section (6 fixed cards).
 *
 * @package Power_Equipment_Leads
 */

/**
 * @return array
 */
function power_equipment_leads_categories_field_defs() {
	$defs = array(
		'show'        => array(
			'label'    => esc_html__( 'Show Categories Section', 'power-equipment-leads' ),
			'type'     => 'checkbox',
			'default'  => true,
			'sanitize' => 'power_equipment_leads_sanitize_checkbox',
		),
		'section_id'  => array(
			'label'   => esc_html__( 'Anchor id (no #)', 'power-equipment-leads' ),
			'default' => 'equipment',
		),
		'eyebrow'     => array(
			'label'   => esc_html__( 'Eyebrow', 'power-equipment-leads' ),
			'default' => 'The Inventory',
		),
		'heading'     => array(
			'label'   => esc_html__( 'Heading', 'power-equipment-leads' ),
			'default' => 'Equipment Categories',
		),
		'heading_accent' => array(
			'label'   => esc_html__( 'Heading Accent Word (colored, appended after Heading)', 'power-equipment-leads' ),
			'default' => '',
		),
		'copy'        => array(
			'label'   => esc_html__( 'Intro Copy', 'power-equipment-leads' ),
			'type'    => 'textarea',
			'default' => "Six aisles. Sixteen hundred machines. Every one tested, prepped, and ready to work the day it leaves the lot.",
		),
		'link'        => array(
			'label'   => esc_html__( 'Card Link (all cards link here)', 'power-equipment-leads' ),
			'default' => '#quote',
		),
	);

	$defaults = array(
		1 => array( 'name' => 'Zero-Turn Mowers', 'tag' => '01 / Cutting', 'count' => '42 models' ),
		2 => array( 'name' => 'Chainsaws & Saws', 'tag' => '02 / Handheld', 'count' => '68 models' ),
		3 => array( 'name' => 'Compact Tractors', 'tag' => '03 / Utility', 'count' => '24 models' ),
		4 => array( 'name' => 'Blowers & Trimmers', 'tag' => '04 / Turf care', 'count' => '51 models' ),
		5 => array( 'name' => 'Generators', 'tag' => '05 / Power', 'count' => '18 models' ),
		6 => array( 'name' => 'Snow Blowers', 'tag' => '06 / Winter', 'count' => '14 models' ),
	);

	foreach ( $defaults as $i => $cat ) {
		$defs[ "cat{$i}_image" ] = array(
			/* translators: %d: category number, 1-6. */
			'label'    => sprintf( esc_html__( 'Category %d Image', 'power-equipment-leads' ), $i ),
			'type'     => 'image',
			'default'  => '',
			'sanitize' => 'esc_url_raw',
		);
		$defs[ "cat{$i}_name" ] = array(
			/* translators: %d: category number, 1-6. */
			'label'   => sprintf( esc_html__( 'Category %d Name', 'power-equipment-leads' ), $i ),
			'default' => $cat['name'],
		);
		$defs[ "cat{$i}_tag" ] = array(
			/* translators: %d: category number, 1-6. */
			'label'   => sprintf( esc_html__( 'Category %d Tag', 'power-equipment-leads' ), $i ),
			'default' => $cat['tag'],
		);
		$defs[ "cat{$i}_count" ] = array(
			/* translators: %d: category number, 1-6. */
			'label'   => sprintf( esc_html__( 'Category %d Count', 'power-equipment-leads' ), $i ),
			'default' => $cat['count'],
		);
	}

	return $defs;
}

/**
 * Reads a Categories section setting.
 *
 * @param string $key Field key, see power_equipment_leads_categories_field_defs().
 * @return mixed
 */
function power_equipment_leads_get_categories_setting( $key ) {
	return power_equipment_leads_get_section_setting( power_equipment_leads_categories_field_defs(), 'pel_categories_', $key );
}

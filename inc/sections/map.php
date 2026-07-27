<?php
/**
 * Field definitions for the "Visit Us" map section. Phone / email / address
 * / hours are pulled from the Business Info section (Appearance > Customize
 * > Business Info) so that contact info only needs to be entered once.
 *
 * @package Power_Equipment_Leads
 */

/**
 * @return array
 */
function power_equipment_leads_map_field_defs() {
	return array(
		'show'             => array(
			'label'    => esc_html__( 'Show Visit Us / Map Section', 'power-equipment-leads' ),
			'type'     => 'checkbox',
			'default'  => true,
			'sanitize' => 'power_equipment_leads_sanitize_checkbox',
		),
		'section_id'       => array(
			'label'   => esc_html__( 'Anchor id (no #)', 'power-equipment-leads' ),
			'default' => 'contact',
		),
		'eyebrow'          => array(
			'label'   => esc_html__( 'Eyebrow', 'power-equipment-leads' ),
			'default' => 'Come See Us',
		),
		'heading_line1'    => array(
			'label'   => esc_html__( 'Heading Line 1', 'power-equipment-leads' ),
			'default' => 'Six acres of',
		),
		'heading_line2'    => array(
			'label'   => esc_html__( 'Heading Line 2 (accent color)', 'power-equipment-leads' ),
			'default' => 'showroom.',
		),
		'directions_text'  => array(
			'label'   => esc_html__( '"Get Directions" Button Text', 'power-equipment-leads' ),
			'default' => 'Get Directions',
		),
		'directions_link'  => array(
			'label'   => esc_html__( '"Get Directions" Button Link (e.g. a Google Maps URL)', 'power-equipment-leads' ),
			'default' => 'https://maps.google.com',
		),
		'map_embed_url'    => array(
			'label'    => esc_html__( 'Map Embed URL (from a map provider\'s "embed" / iframe option)', 'power-equipment-leads' ),
			'default'  => '',
			'sanitize' => 'esc_url_raw',
		),
	);
}

/**
 * Reads a Map section setting.
 *
 * @param string $key Field key, see power_equipment_leads_map_field_defs().
 * @return mixed
 */
function power_equipment_leads_get_map_setting( $key ) {
	return power_equipment_leads_get_section_setting( power_equipment_leads_map_field_defs(), 'pel_map_', $key );
}

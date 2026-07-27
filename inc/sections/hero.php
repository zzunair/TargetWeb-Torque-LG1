<?php
/**
 * Field definitions for the Hero section.
 *
 * @package Power_Equipment_Leads
 */

/**
 * @return array
 */
function power_equipment_leads_hero_field_defs() {
	return array(
		'show'                => array(
			'label'    => esc_html__( 'Show Hero Section', 'power-equipment-leads' ),
			'type'     => 'checkbox',
			'default'  => true,
			'sanitize' => 'power_equipment_leads_sanitize_checkbox',
		),
		'background_image'    => array(
			'label'    => esc_html__( 'Background Image', 'power-equipment-leads' ),
			'type'     => 'image',
			'default'  => '',
			'sanitize' => 'esc_url_raw',
		),
		'eyebrow_text'        => array(
			'label'   => esc_html__( 'Eyebrow Text', 'power-equipment-leads' ),
			'default' => 'Est. 1978 · Family owned',
		),
		'heading_line1'       => array(
			'label'   => esc_html__( 'Heading Line 1', 'power-equipment-leads' ),
			'default' => 'GET YOUR',
		),
		'heading_line2'       => array(
			'label'   => esc_html__( 'Heading Line 2 (accent color)', 'power-equipment-leads' ),
			'default' => 'EQUIPMENT',
		),
		'heading_line3'       => array(
			'label'   => esc_html__( 'Heading Line 3', 'power-equipment-leads' ),
			'default' => 'TODAY.',
		),
		'lede_text'           => array(
			'label'   => esc_html__( 'Lede Text', 'power-equipment-leads' ),
			'type'    => 'textarea',
			'default' => 'Six acres of showroom. Forty-seven years serving contractors, farms, and homeowners who demand machines that outlast the warranty.',
		),
		'primary_button_text' => array(
			'label'   => esc_html__( 'Primary Button Text', 'power-equipment-leads' ),
			'default' => 'Request a Quote',
		),
		'primary_button_link' => array(
			'label'   => esc_html__( 'Primary Button Link', 'power-equipment-leads' ),
			'default' => '#quote',
		),
		'secondary_button_text' => array(
			'label'   => esc_html__( 'Secondary Button Text', 'power-equipment-leads' ),
			'default' => 'Apply for Financing',
		),
		'secondary_button_link' => array(
			'label'   => esc_html__( 'Secondary Button Link', 'power-equipment-leads' ),
			'default' => '#financing',
		),
		'badge1_icon'         => array(
			'label'    => esc_html__( 'Badge 1 Icon', 'power-equipment-leads' ),
			'type'     => 'select',
			'default'  => 'shield',
			'choices'  => power_equipment_leads_icon_choices(),
		),
		'badge1_text'         => array(
			'label'   => esc_html__( 'Badge 1 Text', 'power-equipment-leads' ),
			'default' => 'Warranty support',
		),
		'badge2_icon'         => array(
			'label'    => esc_html__( 'Badge 2 Icon', 'power-equipment-leads' ),
			'type'     => 'select',
			'default'  => 'truck',
			'choices'  => power_equipment_leads_icon_choices(),
		),
		'badge2_text'         => array(
			'label'   => esc_html__( 'Badge 2 Text', 'power-equipment-leads' ),
			'default' => 'Free 40mi delivery',
		),
		'watermark_text'      => array(
			'label'   => esc_html__( 'Decorative Watermark (e.g. founding year)', 'power-equipment-leads' ),
			'default' => '78',
		),
	);
}

/**
 * Reads a Hero section setting.
 *
 * @param string $key Field key, see power_equipment_leads_hero_field_defs().
 * @return mixed
 */
function power_equipment_leads_get_hero_setting( $key ) {
	return power_equipment_leads_get_section_setting( power_equipment_leads_hero_field_defs(), 'pel_hero_', $key );
}

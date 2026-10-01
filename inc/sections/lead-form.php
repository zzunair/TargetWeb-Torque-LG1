<?php
/**
 * Field definitions for the Lead Form section.
 *
 * @package Power_Equipment_Leads
 */

/**
 * @return array
 */
function power_equipment_leads_lead_form_field_defs() {
	return array(
		'show'                => array(
			'label'    => esc_html__( 'Show Lead Form Section', 'power-equipment-leads' ),
			'type'     => 'checkbox',
			'default'  => true,
			'sanitize' => 'power_equipment_leads_sanitize_checkbox',
		),
		'anchor_id'           => array(
			'label'   => esc_html__( 'Anchor id (no #)', 'power-equipment-leads' ),
			'default' => 'quote',
		),
		'form_id'             => array(
			'label'   => esc_html__( 'Form ID (for the Leads list)', 'power-equipment-leads' ),
			'default' => 'quote',
		),
		'eyebrow'             => array(
			'label'   => esc_html__( 'Eyebrow', 'power-equipment-leads' ),
			'default' => 'Get a Quote',
		),
		'heading_line1'       => array(
			'label'   => esc_html__( 'Heading Line 1', 'power-equipment-leads' ),
			'default' => 'Tell us what',
		),
		'heading_line2'       => array(
			'label'   => esc_html__( 'Heading Line 2 (accent color)', 'power-equipment-leads' ),
			'default' => 'you need.',
		),
		'copy'                => array(
			'label'   => esc_html__( 'Copy', 'power-equipment-leads' ),
			'type'    => 'textarea',
			'default' => 'No email autoresponders. A real person from the sales floor will call you back within two business hours with pricing, availability, and financing options.',
		),
		'badge1_icon'         => array(
			'label'   => esc_html__( 'Badge 1 Icon', 'power-equipment-leads' ),
			'type'    => 'select',
			'default' => 'award',
			'choices' => power_equipment_leads_icon_choices(),
		),
		'badge1_key'          => array(
			'label'   => esc_html__( 'Badge 1 Bold Text', 'power-equipment-leads' ),
			'default' => '47 Years',
		),
		'badge1_value'        => array(
			'label'   => esc_html__( 'Badge 1 Description', 'power-equipment-leads' ),
			'default' => 'of dealer expertise',
		),
		'badge2_icon'         => array(
			'label'   => esc_html__( 'Badge 2 Icon', 'power-equipment-leads' ),
			'type'    => 'select',
			'default' => 'shield',
			'choices' => power_equipment_leads_icon_choices(),
		),
		'badge2_key'          => array(
			'label'   => esc_html__( 'Badge 2 Bold Text', 'power-equipment-leads' ),
			'default' => 'Warranty',
		),
		'badge2_value'        => array(
			'label'   => esc_html__( 'Badge 2 Description', 'power-equipment-leads' ),
			'default' => 'authorized service center',
		),
		'badge3_icon'         => array(
			'label'   => esc_html__( 'Badge 3 Icon', 'power-equipment-leads' ),
			'type'    => 'select',
			'default' => 'truck',
			'choices' => power_equipment_leads_icon_choices(),
		),
		'badge3_key'          => array(
			'label'   => esc_html__( 'Badge 3 Bold Text', 'power-equipment-leads' ),
			'default' => 'Delivery',
		),
		'badge3_value'        => array(
			'label'   => esc_html__( 'Badge 3 Description', 'power-equipment-leads' ),
			'default' => 'included within 40 miles',
		),
		'button_text'         => array(
			'label'   => esc_html__( 'Button Text', 'power-equipment-leads' ),
			'default' => 'Request Quote',
		),
		'disclaimer'          => array(
			'label'   => esc_html__( 'Disclaimer Text', 'power-equipment-leads' ),
			'default' => 'We call back within 2 business hours. No spam, ever.',
		),
		'show_message_field' => array(
			'label'    => esc_html__( 'Show Message Field', 'power-equipment-leads' ),
			'type'     => 'checkbox',
			'default'  => true,
			'sanitize' => 'power_equipment_leads_sanitize_checkbox',
		),
		'success_heading'     => array(
			'label'   => esc_html__( 'Success Heading', 'power-equipment-leads' ),
			'default' => 'Request Received.',
		),
		'success_text'        => array(
			'label'   => esc_html__( 'Success Text', 'power-equipment-leads' ),
			'type'    => 'textarea',
			'default' => 'A member of our sales team will reach out within 2 business hours. For urgent requests, call us directly.',
		),
	);
}

/**
 * Reads a Lead Form section setting.
 *
 * @param string $key Field key, see power_equipment_leads_lead_form_field_defs().
 * @return mixed
 */
function power_equipment_leads_get_lead_form_setting( $key ) {
	return power_equipment_leads_get_section_setting( power_equipment_leads_lead_form_field_defs(), 'pel_lead_form_', $key );
}

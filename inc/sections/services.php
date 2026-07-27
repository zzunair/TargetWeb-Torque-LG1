<?php
/**
 * Field definitions for the Services section (5 fixed items).
 *
 * @package Power_Equipment_Leads
 */

/**
 * @return array
 */
function power_equipment_leads_services_field_defs() {
	$defs = array(
		'show'       => array(
			'label'    => esc_html__( 'Show Services Section', 'power-equipment-leads' ),
			'type'     => 'checkbox',
			'default'  => true,
			'sanitize' => 'power_equipment_leads_sanitize_checkbox',
		),
		'section_id' => array(
			'label'   => esc_html__( 'Anchor id (no #)', 'power-equipment-leads' ),
			'default' => 'services',
		),
		'eyebrow'    => array(
			'label'   => esc_html__( 'Eyebrow', 'power-equipment-leads' ),
			'default' => 'What We Do',
		),
		'heading'    => array(
			'label'   => esc_html__( 'Heading', 'power-equipment-leads' ),
			'default' => 'More Than Sales.',
		),
		'copy'       => array(
			'label'   => esc_html__( 'Intro Copy', 'power-equipment-leads' ),
			'type'    => 'textarea',
			'default' => 'A dealership without a service department is just a warehouse. Ours has been the difference for four decades.',
		),
	);

	$defaults = array(
		1 => array(
			'icon'  => 'cart',
			'name'  => 'Sales',
			'desc'  => 'New & certified pre-owned equipment from the brands that built the industry.',
		),
		2 => array(
			'icon'  => 'wrench',
			'name'  => 'Repairs',
			'desc'  => 'Factory-trained technicians. Warranty work on all major brands, 48-hour turnaround.',
		),
		3 => array(
			'icon'  => 'cog',
			'name'  => 'Maintenance',
			'desc'  => 'Seasonal tune-ups, blade sharpening, oil service. Pickup & delivery available.',
		),
		4 => array(
			'icon'  => 'package',
			'name'  => 'Parts',
			'desc'  => 'OEM parts inventory of 12,000+ SKUs. Same-day pickup, next-day shipping.',
		),
		5 => array(
			'icon'  => 'credit-card',
			'name'  => 'Financing',
			'desc'  => '0% APR programs up to 48 months. Approvals in minutes, right on the showroom floor.',
		),
	);

	foreach ( $defaults as $i => $svc ) {
		$defs[ "svc{$i}_icon" ] = array(
			/* translators: %d: service number, 1-5. */
			'label'   => sprintf( esc_html__( 'Service %d Icon', 'power-equipment-leads' ), $i ),
			'type'    => 'select',
			'default' => $svc['icon'],
			'choices' => power_equipment_leads_icon_choices(),
		);
		$defs[ "svc{$i}_name" ] = array(
			/* translators: %d: service number, 1-5. */
			'label'   => sprintf( esc_html__( 'Service %d Name', 'power-equipment-leads' ), $i ),
			'default' => $svc['name'],
		);
		$defs[ "svc{$i}_desc" ] = array(
			/* translators: %d: service number, 1-5. */
			'label'   => sprintf( esc_html__( 'Service %d Description', 'power-equipment-leads' ), $i ),
			'type'    => 'textarea',
			'default' => $svc['desc'],
		);
	}

	return $defs;
}

/**
 * Reads a Services section setting.
 *
 * @param string $key Field key, see power_equipment_leads_services_field_defs().
 * @return mixed
 */
function power_equipment_leads_get_services_setting( $key ) {
	return power_equipment_leads_get_section_setting( power_equipment_leads_services_field_defs(), 'pel_services_', $key );
}

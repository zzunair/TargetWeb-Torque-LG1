<?php
/**
 * Field definitions for the Testimonials section (3 fixed quotes).
 *
 * @package Power_Equipment_Leads
 */

/**
 * @return array
 */
function power_equipment_leads_testimonials_field_defs() {
	$defs = array(
		'show'    => array(
			'label'    => esc_html__( 'Show Testimonials Section', 'power-equipment-leads' ),
			'type'     => 'checkbox',
			'default'  => true,
			'sanitize' => 'power_equipment_leads_sanitize_checkbox',
		),
		'eyebrow' => array(
			'label'   => esc_html__( 'Eyebrow', 'power-equipment-leads' ),
			'default' => 'The Owners',
		),
		'heading' => array(
			'label'   => esc_html__( 'Heading', 'power-equipment-leads' ),
			'default' => 'Words From The Field.',
		),
		'copy'    => array(
			'label'   => esc_html__( 'Intro Copy', 'power-equipment-leads' ),
			'type'    => 'textarea',
			'default' => "Forty-seven years, eighteen thousand customers. Here's what a few of them have to say.",
		),
	);

	$defaults = array(
		1 => array(
			'quote' => "I've been buying mowers here for 17 years. Their service department has kept my whole fleet running through three seasons of hard commercial use.",
			'name'  => 'Marcus Reilly',
			'role'  => 'Reilly Landscape, Est. 2004',
		),
		2 => array(
			'quote' => 'Walked in for a chainsaw, walked out with a tractor at 0% APR. No pressure, straight answers. This is how equipment should be sold.',
			'name'  => 'Danielle Hoffman',
			'role'  => 'Property Owner, 40 acres',
		),
		3 => array(
			'quote' => "Broke down on a Friday. They had a loaner in my truck by noon and my machine back Monday morning. That's what dealer support means.",
			'name'  => 'Bill Yoder',
			'role'  => 'Yoder Farms',
		),
	);

	foreach ( $defaults as $i => $t ) {
		$defs[ "t{$i}_quote" ] = array(
			/* translators: %d: testimonial number, 1-3. */
			'label'   => sprintf( esc_html__( 'Testimonial %d Quote', 'power-equipment-leads' ), $i ),
			'type'    => 'textarea',
			'default' => $t['quote'],
		);
		$defs[ "t{$i}_name" ] = array(
			/* translators: %d: testimonial number, 1-3. */
			'label'   => sprintf( esc_html__( 'Testimonial %d Name', 'power-equipment-leads' ), $i ),
			'default' => $t['name'],
		);
		$defs[ "t{$i}_role" ] = array(
			/* translators: %d: testimonial number, 1-3. */
			'label'   => sprintf( esc_html__( 'Testimonial %d Role', 'power-equipment-leads' ), $i ),
			'default' => $t['role'],
		);
	}

	return $defs;
}

/**
 * Reads a Testimonials section setting.
 *
 * @param string $key Field key, see power_equipment_leads_testimonials_field_defs().
 * @return mixed
 */
function power_equipment_leads_get_testimonials_setting( $key ) {
	return power_equipment_leads_get_section_setting( power_equipment_leads_testimonials_field_defs(), 'pel_testimonials_', $key );
}

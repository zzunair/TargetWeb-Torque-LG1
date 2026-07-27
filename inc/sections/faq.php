<?php
/**
 * Field definitions for the FAQ section (5 fixed Q&A pairs).
 *
 * @package Power_Equipment_Leads
 */

/**
 * @return array
 */
function power_equipment_leads_faq_field_defs() {
	$defs = array(
		'show'    => array(
			'label'    => esc_html__( 'Show FAQ Section', 'power-equipment-leads' ),
			'type'     => 'checkbox',
			'default'  => true,
			'sanitize' => 'power_equipment_leads_sanitize_checkbox',
		),
		'eyebrow' => array(
			'label'   => esc_html__( 'Eyebrow', 'power-equipment-leads' ),
			'default' => 'Straight Answers',
		),
		'heading' => array(
			'label'   => esc_html__( 'Heading', 'power-equipment-leads' ),
			'default' => 'Frequently Asked.',
		),
	);

	$defaults = array(
		1 => array(
			'q' => 'Do you finance commercial buyers?',
			'a' => 'Yes. We work with Sheffield, Synchrony, and our own in-house program. Commercial fleet buyers get dedicated terms with 90-day deferred payment options during the season.',
		),
		2 => array(
			'q' => 'How fast can you turn around a repair?',
			'a' => 'Standard repairs go out in 48–72 hours. Warranty work depends on the manufacturer, but we stock 90% of common wear parts on-site.',
		),
		3 => array(
			'q' => 'Do you deliver?',
			'a' => 'Free delivery within 40 miles on any purchase over $2,500. Freight quotes available for anything outside that radius — call us with your ZIP.',
		),
		4 => array(
			'q' => 'What brands do you carry?',
			'a' => "Toro, Kubota, STIHL, Husqvarna, Cub Cadet, Gravely, Generac, Ariens, Echo, and more. If we don't stock it, we can source it.",
		),
		5 => array(
			'q' => 'Do you buy used equipment?',
			'a' => 'Absolutely. Bring it in for a free evaluation. Cash offers, or higher-value trade-in credit toward a new purchase.',
		),
	);

	foreach ( $defaults as $i => $faq ) {
		$defs[ "faq{$i}_q" ] = array(
			/* translators: %d: FAQ number, 1-5. */
			'label'   => sprintf( esc_html__( 'Question %d', 'power-equipment-leads' ), $i ),
			'default' => $faq['q'],
		);
		$defs[ "faq{$i}_a" ] = array(
			/* translators: %d: FAQ number, 1-5. */
			'label'   => sprintf( esc_html__( 'Answer %d', 'power-equipment-leads' ), $i ),
			'type'    => 'textarea',
			'default' => $faq['a'],
		);
	}

	return $defs;
}

/**
 * Reads an FAQ section setting.
 *
 * @param string $key Field key, see power_equipment_leads_faq_field_defs().
 * @return mixed
 */
function power_equipment_leads_get_faq_setting( $key ) {
	return power_equipment_leads_get_section_setting( power_equipment_leads_faq_field_defs(), 'pel_faq_', $key );
}

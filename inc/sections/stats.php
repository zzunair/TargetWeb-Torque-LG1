<?php
/**
 * Field definitions for the Quick Stats section (a fixed set of 4 stats).
 *
 * @package Power_Equipment_Leads
 */

/**
 * @return array
 */
function power_equipment_leads_stats_field_defs() {
	$defs = array(
		'show'       => array(
			'label'    => esc_html__( 'Show Quick Stats Section', 'power-equipment-leads' ),
			'type'     => 'checkbox',
			'default'  => true,
			'sanitize' => 'power_equipment_leads_sanitize_checkbox',
		),
		'section_id' => array(
			'label'   => esc_html__( 'Anchor id (no #)', 'power-equipment-leads' ),
			'default' => 'stats',
		),
	);

	$defaults = array(
		1 => array( 'value' => '47', 'suffix' => '', 'label' => 'In Business' ),
		2 => array( 'value' => '22', 'suffix' => '+', 'label' => 'Brands Carried' ),
		3 => array( 'value' => '1,400', 'suffix' => '+', 'label' => 'Units in Stock' ),
		4 => array( 'value' => '18k', 'suffix' => '+', 'label' => 'Happy Customers' ),
	);

	foreach ( $defaults as $i => $stat ) {
		$defs[ "stat{$i}_value" ]  = array(
			/* translators: %d: stat number, 1-4. */
			'label'   => sprintf( esc_html__( 'Stat %d Value', 'power-equipment-leads' ), $i ),
			'default' => $stat['value'],
		);
		$defs[ "stat{$i}_suffix" ] = array(
			/* translators: %d: stat number, 1-4. */
			'label'   => sprintf( esc_html__( 'Stat %d Suffix', 'power-equipment-leads' ), $i ),
			'default' => $stat['suffix'],
		);
		$defs[ "stat{$i}_label" ]  = array(
			/* translators: %d: stat number, 1-4. */
			'label'   => sprintf( esc_html__( 'Stat %d Label', 'power-equipment-leads' ), $i ),
			'default' => $stat['label'],
		);
	}

	return $defs;
}

/**
 * Reads a Quick Stats section setting.
 *
 * @param string $key Field key, see power_equipment_leads_stats_field_defs().
 * @return mixed
 */
function power_equipment_leads_get_stats_setting( $key ) {
	return power_equipment_leads_get_section_setting( power_equipment_leads_stats_field_defs(), 'pel_stats_', $key );
}

<?php
/**
 * Quick Stats section.
 *
 * Content editable via Appearance > Customize > Homepage Sections > Quick Stats.
 *
 * @package Power_Equipment_Leads
 */

if ( ! power_equipment_leads_get_stats_setting( 'show' ) ) {
	return;
}

$section_id = power_equipment_leads_get_stats_setting( 'section_id' );

$stats = array();
for ( $i = 1; $i <= 4; $i++ ) {
	$stats[] = array(
		'value'  => power_equipment_leads_get_stats_setting( "stat{$i}_value" ),
		'suffix' => power_equipment_leads_get_stats_setting( "stat{$i}_suffix" ),
		'label'  => power_equipment_leads_get_stats_setting( "stat{$i}_label" ),
	);
}
?>
<section id="<?php echo esc_attr( $section_id ); ?>" class="stats bg-diamond" aria-label="<?php esc_attr_e( 'By the numbers', 'power-equipment-leads' ); ?>">
	<div class="container">
		<div class="stats__grid">
			<?php foreach ( $stats as $index => $stat ) : ?>
				<?php if ( empty( $stat['value'] ) && empty( $stat['label'] ) ) { continue; } ?>
				<div class="stat reveal" style="animation-delay: <?php echo esc_attr( $index * 0.1 ); ?>s">
					<div class="stat__num">
						<?php echo esc_html( $stat['value'] ); ?>
						<?php if ( $stat['suffix'] ) : ?>
							<span><?php echo esc_html( $stat['suffix'] ); ?></span>
						<?php endif; ?>
					</div>
					<div class="stat__label"><?php echo esc_html( $stat['label'] ); ?></div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

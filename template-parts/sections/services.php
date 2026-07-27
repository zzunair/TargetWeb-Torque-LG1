<?php
/**
 * Services section.
 *
 * Content editable via Appearance > Customize > Homepage Sections > 5. Services.
 *
 * @package Power_Equipment_Leads
 */

if ( ! power_equipment_leads_get_services_setting( 'show' ) ) {
	return;
}

$section_id = power_equipment_leads_get_services_setting( 'section_id' );

$services = array();
for ( $i = 1; $i <= 5; $i++ ) {
	$services[] = array(
		'icon' => power_equipment_leads_get_services_setting( "svc{$i}_icon" ),
		'name' => power_equipment_leads_get_services_setting( "svc{$i}_name" ),
		'desc' => power_equipment_leads_get_services_setting( "svc{$i}_desc" ),
	);
}
?>
<section id="<?php echo esc_attr( $section_id ); ?>" class="services bg-diamond" aria-label="<?php esc_attr_e( 'Services', 'power-equipment-leads' ); ?>">
	<div class="container">
		<?php
		power_equipment_leads_section_head(
			power_equipment_leads_get_services_setting( 'eyebrow' ),
			power_equipment_leads_get_services_setting( 'heading' ),
			'',
			power_equipment_leads_get_services_setting( 'copy' )
		);
		?>

		<div class="services__grid">
			<?php foreach ( $services as $index => $svc ) : ?>
				<?php if ( empty( $svc['name'] ) ) { continue; } ?>
				<div class="service-card reveal" style="animation-delay: <?php echo esc_attr( $index * 0.05 ); ?>s">
					<div class="service-card__top">
						<div class="service-card__icon"><?php power_equipment_leads_icon( $svc['icon'] ?: 'cog' ); ?></div>
						<span class="service-card__index">0<?php echo esc_html( $index + 1 ); ?></span>
					</div>
					<h3 class="service-card__name"><?php echo esc_html( $svc['name'] ); ?></h3>
					<?php if ( $svc['desc'] ) : ?>
						<p class="service-card__desc"><?php echo esc_html( $svc['desc'] ); ?></p>
					<?php endif; ?>
					<div class="service-card__bar"></div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

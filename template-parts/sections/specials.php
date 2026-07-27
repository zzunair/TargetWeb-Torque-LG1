<?php
/**
 * Specials section.
 *
 * Content editable via Appearance > Customize > Homepage Sections > 6. Specials.
 *
 * @package Power_Equipment_Leads
 */

if ( ! power_equipment_leads_get_specials_setting( 'show' ) ) {
	return;
}

$section_id = power_equipment_leads_get_specials_setting( 'section_id' );
$cta_text   = power_equipment_leads_get_specials_setting( 'cta_text' );
$cta_link   = power_equipment_leads_get_specials_setting( 'cta_link' );

$specials = array();
for ( $i = 1; $i <= 3; $i++ ) {
	$specials[] = array(
		'label' => power_equipment_leads_get_specials_setting( "special{$i}_label" ),
		'title' => power_equipment_leads_get_specials_setting( "special{$i}_title" ),
		'price' => power_equipment_leads_get_specials_setting( "special{$i}_price" ),
		'was'   => power_equipment_leads_get_specials_setting( "special{$i}_was" ),
		'tag'   => power_equipment_leads_get_specials_setting( "special{$i}_tag" ),
	);
}
?>
<section id="<?php echo esc_attr( $section_id ); ?>" class="specials" aria-label="<?php esc_attr_e( 'Current Specials', 'power-equipment-leads' ); ?>">
	<div class="container">
		<div class="specials__head">
			<?php
			power_equipment_leads_section_head(
				power_equipment_leads_get_specials_setting( 'eyebrow' ),
				power_equipment_leads_get_specials_setting( 'heading' ),
				'',
				power_equipment_leads_get_specials_setting( 'copy' ),
				'left'
			);
			?>
			<?php if ( $cta_text ) : ?>
				<a href="<?php echo esc_url( $cta_link ); ?>" class="btn btn--steel"><?php echo esc_html( $cta_text ); ?></a>
			<?php endif; ?>
		</div>

		<div class="specials__grid">
			<?php foreach ( $specials as $index => $special ) : ?>
				<?php if ( empty( $special['title'] ) ) { continue; } ?>
				<div class="special-card reveal" style="animation-delay: <?php echo esc_attr( $index * 0.08 ); ?>s">
					<?php if ( $special['label'] ) : ?>
						<div class="special-card__label"><?php echo esc_html( $special['label'] ); ?></div>
					<?php endif; ?>
					<h3 class="special-card__title"><?php echo esc_html( $special['title'] ); ?></h3>
					<div class="special-card__price-row">
						<span class="special-card__price"><?php echo esc_html( $special['price'] ); ?></span>
						<?php if ( $special['was'] ) : ?>
							<span class="special-card__was"><?php echo esc_html( $special['was'] ); ?></span>
						<?php endif; ?>
					</div>
					<?php if ( $special['tag'] ) : ?>
						<div class="special-card__tag"><?php power_equipment_leads_icon( 'clock' ); ?> <?php echo esc_html( $special['tag'] ); ?></div>
					<?php endif; ?>
					<a href="<?php echo esc_url( $cta_link ); ?>" class="special-card__link">
						<?php esc_html_e( 'Claim This Deal', 'power-equipment-leads' ); ?>
						<?php power_equipment_leads_icon( 'arrow-right' ); ?>
					</a>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

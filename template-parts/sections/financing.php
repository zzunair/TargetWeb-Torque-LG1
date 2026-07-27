<?php
/**
 * Financing Banner section.
 *
 * Content editable via Appearance > Customize > Homepage Sections > 7. Financing Banner.
 *
 * @package Power_Equipment_Leads
 */

if ( ! power_equipment_leads_get_financing_setting( 'show' ) ) {
	return;
}

$section_id      = power_equipment_leads_get_financing_setting( 'section_id' );
$background_url  = power_equipment_leads_get_financing_setting( 'background_image' );
$copy            = power_equipment_leads_get_financing_setting( 'copy' );
$primary_text    = power_equipment_leads_get_financing_setting( 'primary_button_text' );
$secondary_text  = power_equipment_leads_get_financing_setting( 'secondary_button_text' );
$phone           = power_equipment_leads_get_theme_setting( 'phone' );

$facts = array();
for ( $i = 1; $i <= 4; $i++ ) {
	$facts[] = array(
		'value' => power_equipment_leads_get_financing_setting( "fact{$i}_value" ),
		'label' => power_equipment_leads_get_financing_setting( "fact{$i}_label" ),
	);
}
?>
<section id="<?php echo esc_attr( $section_id ); ?>" class="financing clip-diagonal-both" aria-label="<?php esc_attr_e( 'Financing', 'power-equipment-leads' ); ?>">
	<?php if ( $background_url ) : ?>
		<div class="financing__media">
			<img src="<?php echo esc_url( $background_url ); ?>" alt="" />
			<div class="financing__scrim"></div>
		</div>
	<?php endif; ?>

	<div class="container financing__inner">
		<div class="financing__copy">
			<?php $eyebrow = power_equipment_leads_get_financing_setting( 'eyebrow' ); ?>
			<?php if ( $eyebrow ) : ?>
				<span class="eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
			<?php endif; ?>
			<h2 class="financing__title">
				<?php echo esc_html( power_equipment_leads_get_financing_setting( 'heading_line1' ) ); ?><br />
				<span class="accent"><?php echo esc_html( power_equipment_leads_get_financing_setting( 'heading_line2' ) ); ?></span>
			</h2>
			<?php if ( $copy ) : ?>
				<p class="financing__lede"><?php echo esc_html( $copy ); ?></p>
			<?php endif; ?>
			<div class="financing__cta">
				<?php if ( $primary_text ) : ?>
					<a href="<?php echo esc_url( power_equipment_leads_get_financing_setting( 'primary_button_link' ) ); ?>" class="btn btn--industrial btn--lg"><?php echo esc_html( $primary_text ); ?></a>
				<?php endif; ?>
				<?php if ( $secondary_text && $phone ) : ?>
					<a href="tel:<?php echo esc_attr( power_equipment_leads_phone_href( $phone ) ); ?>" class="btn btn--steel btn--lg"><?php echo esc_html( $secondary_text ); ?></a>
				<?php endif; ?>
			</div>
		</div>

		<div class="financing__facts">
			<?php foreach ( $facts as $fact ) : ?>
				<?php if ( empty( $fact['value'] ) && empty( $fact['label'] ) ) { continue; } ?>
				<div class="financing-fact">
					<div class="financing-fact__value"><?php echo esc_html( $fact['value'] ); ?></div>
					<div class="financing-fact__label"><?php echo esc_html( $fact['label'] ); ?></div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

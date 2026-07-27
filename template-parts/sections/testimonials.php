<?php
/**
 * Testimonials section.
 *
 * Content editable via Appearance > Customize > Homepage Sections > 8. Testimonials.
 *
 * @package Power_Equipment_Leads
 */

if ( ! power_equipment_leads_get_testimonials_setting( 'show' ) ) {
	return;
}

$testimonials = array();
for ( $i = 1; $i <= 3; $i++ ) {
	$testimonials[] = array(
		'quote' => power_equipment_leads_get_testimonials_setting( "t{$i}_quote" ),
		'name'  => power_equipment_leads_get_testimonials_setting( "t{$i}_name" ),
		'role'  => power_equipment_leads_get_testimonials_setting( "t{$i}_role" ),
	);
}
?>
<section class="testimonials" aria-label="<?php esc_attr_e( 'Testimonials', 'power-equipment-leads' ); ?>">
	<div class="container">
		<?php
		power_equipment_leads_section_head(
			power_equipment_leads_get_testimonials_setting( 'eyebrow' ),
			power_equipment_leads_get_testimonials_setting( 'heading' ),
			'',
			power_equipment_leads_get_testimonials_setting( 'copy' )
		);
		?>

		<div class="testimonials__grid">
			<?php foreach ( $testimonials as $index => $t ) : ?>
				<?php if ( empty( $t['quote'] ) ) { continue; } ?>
				<figure class="testimonial-card reveal" style="animation-delay: <?php echo esc_attr( $index * 0.08 ); ?>s">
					<div class="testimonial-card__badge"><?php echo esc_html( str_pad( (string) ( $index + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></div>
					<div class="testimonial-card__stars">
						<?php for ( $s = 0; $s < 5; $s++ ) : ?>
							<?php power_equipment_leads_icon( 'star' ); ?>
						<?php endfor; ?>
					</div>
					<blockquote>&ldquo;<?php echo esc_html( $t['quote'] ); ?>&rdquo;</blockquote>
					<figcaption>
						<div class="testimonial-card__name"><?php echo esc_html( $t['name'] ); ?></div>
						<?php if ( $t['role'] ) : ?>
							<div class="testimonial-card__role"><?php echo esc_html( $t['role'] ); ?></div>
						<?php endif; ?>
					</figcaption>
				</figure>
			<?php endforeach; ?>
		</div>
	</div>
</section>

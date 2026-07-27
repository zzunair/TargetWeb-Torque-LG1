<?php
/**
 * FAQ section. Uses native <details>/<summary> for an accessible accordion
 * with no extra JavaScript.
 *
 * Content editable via Appearance > Customize > Homepage Sections > 9. FAQ.
 *
 * @package Power_Equipment_Leads
 */

if ( ! power_equipment_leads_get_faq_setting( 'show' ) ) {
	return;
}

$faqs = array();
for ( $i = 1; $i <= 5; $i++ ) {
	$faqs[] = array(
		'q' => power_equipment_leads_get_faq_setting( "faq{$i}_q" ),
		'a' => power_equipment_leads_get_faq_setting( "faq{$i}_a" ),
	);
}
?>
<section class="faq bg-diamond" aria-label="<?php esc_attr_e( 'Frequently Asked Questions', 'power-equipment-leads' ); ?>">
	<div class="container container--narrow">
		<?php
		power_equipment_leads_section_head(
			power_equipment_leads_get_faq_setting( 'eyebrow' ),
			power_equipment_leads_get_faq_setting( 'heading' )
		);
		?>

		<div class="faq__list">
			<?php foreach ( $faqs as $index => $faq ) : ?>
				<?php if ( empty( $faq['q'] ) ) { continue; } ?>
				<details class="faq-item reveal" style="animation-delay: <?php echo esc_attr( $index * 0.04 ); ?>s" <?php echo 0 === $index ? 'open' : ''; ?>>
					<summary class="faq-item__question">
						<span class="faq-item__index"><?php echo esc_html( str_pad( (string) ( $index + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
						<span class="faq-item__text"><?php echo esc_html( $faq['q'] ); ?></span>
						<span class="faq-item__toggle">
							<?php power_equipment_leads_icon( 'plus', 'faq-item__icon-plus' ); ?>
							<?php power_equipment_leads_icon( 'minus', 'faq-item__icon-minus' ); ?>
						</span>
					</summary>
					<div class="faq-item__answer"><?php echo esc_html( $faq['a'] ); ?></div>
				</details>
			<?php endforeach; ?>
		</div>
	</div>
</section>

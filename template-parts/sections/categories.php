<?php
/**
 * Equipment Categories section.
 *
 * Content editable via Appearance > Customize > Homepage Sections > 4. Equipment Categories.
 *
 * @package Power_Equipment_Leads
 */

if ( ! power_equipment_leads_get_categories_setting( 'show' ) ) {
	return;
}

$section_id = power_equipment_leads_get_categories_setting( 'section_id' );
$link       = power_equipment_leads_get_categories_setting( 'link' );

$categories = array();
for ( $i = 1; $i <= 6; $i++ ) {
	$categories[] = array(
		'image' => power_equipment_leads_get_categories_setting( "cat{$i}_image" ),
		'name'  => power_equipment_leads_get_categories_setting( "cat{$i}_name" ),
		'tag'   => power_equipment_leads_get_categories_setting( "cat{$i}_tag" ),
		'count' => power_equipment_leads_get_categories_setting( "cat{$i}_count" ),
	);
}
?>
<section id="<?php echo esc_attr( $section_id ); ?>" class="categories" aria-label="<?php esc_attr_e( 'Equipment Categories', 'power-equipment-leads' ); ?>">
	<div class="container">
		<?php
		power_equipment_leads_section_head(
			power_equipment_leads_get_categories_setting( 'eyebrow' ),
			power_equipment_leads_get_categories_setting( 'heading' ),
			power_equipment_leads_get_categories_setting( 'heading_accent' ),
			power_equipment_leads_get_categories_setting( 'copy' )
		);
		?>

		<div class="categories__grid">
			<?php foreach ( $categories as $index => $cat ) : ?>
				<?php if ( empty( $cat['name'] ) ) { continue; } ?>
				<a href="<?php echo esc_url( $link ); ?>" class="category-card reveal" style="animation-delay: <?php echo esc_attr( $index * 0.06 ); ?>s">
					<?php if ( $cat['image'] ) : ?>
						<img src="<?php echo esc_url( $cat['image'] ); ?>" alt="<?php echo esc_attr( $cat['name'] ); ?>" loading="lazy" />
					<?php endif; ?>
					<div class="category-card__scrim"></div>
					<?php if ( $cat['tag'] ) : ?>
						<div class="category-card__tag"><?php echo esc_html( $cat['tag'] ); ?></div>
					<?php endif; ?>
					<div class="category-card__body">
						<?php if ( $cat['count'] ) : ?>
							<div class="category-card__count"><?php echo esc_html( $cat['count'] ); ?></div>
						<?php endif; ?>
						<h3 class="category-card__name"><?php echo esc_html( $cat['name'] ); ?></h3>
						<div class="category-card__link">
							<?php esc_html_e( 'Browse Inventory', 'power-equipment-leads' ); ?>
							<?php power_equipment_leads_icon( 'chevron-right' ); ?>
						</div>
					</div>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php
/**
 * "Visit Us" / Map section. Phone, email, address and hours come from the
 * Business Info settings (Appearance > Customize > Business Info) so
 * contact details only need to be entered in one place.
 *
 * Section-specific fields editable via Appearance > Customize >
 * Homepage Sections > 11. Visit Us / Map.
 *
 * @package Power_Equipment_Leads
 */

if ( ! power_equipment_leads_get_map_setting( 'show' ) ) {
	return;
}

$section_id      = power_equipment_leads_get_map_setting( 'section_id' );
$directions_text = power_equipment_leads_get_map_setting( 'directions_text' );
$directions_link = power_equipment_leads_get_map_setting( 'directions_link' );
$map_embed_url   = power_equipment_leads_get_map_setting( 'map_embed_url' );

$address1 = power_equipment_leads_get_theme_setting( 'address_line1' );
$address2 = power_equipment_leads_get_theme_setting( 'address_line2' );
$hours    = power_equipment_leads_get_theme_setting( 'hours' );
$phone    = power_equipment_leads_get_theme_setting( 'phone' );
$email    = power_equipment_leads_get_theme_setting( 'email' );

$rows = array();
if ( $address1 || $address2 ) {
	$rows[] = array(
		'icon'  => 'map-pin',
		'title' => __( 'Location', 'power-equipment-leads' ),
		'lines' => array_filter( array( $address1, $address2 ) ),
	);
}
if ( $hours ) {
	$rows[] = array(
		'icon'  => 'clock',
		'title' => __( 'Hours', 'power-equipment-leads' ),
		'lines' => array( $hours ),
	);
}
if ( $phone ) {
	$rows[] = array(
		'icon'  => 'phone',
		'title' => __( 'Phone', 'power-equipment-leads' ),
		'lines' => array( $phone ),
	);
}
if ( $email ) {
	$rows[] = array(
		'icon'  => 'mail',
		'title' => __( 'Email', 'power-equipment-leads' ),
		'lines' => array( $email ),
	);
}
?>
<section id="<?php echo esc_attr( $section_id ); ?>" class="visit-us" aria-label="<?php esc_attr_e( 'Visit Us', 'power-equipment-leads' ); ?>">
	<div class="container visit-us__inner">
		<div class="reveal">
			<?php $eyebrow = power_equipment_leads_get_map_setting( 'eyebrow' ); ?>
			<?php if ( $eyebrow ) : ?>
				<span class="eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
			<?php endif; ?>
			<h2 class="visit-us__title">
				<?php echo esc_html( power_equipment_leads_get_map_setting( 'heading_line1' ) ); ?><br />
				<span class="accent"><?php echo esc_html( power_equipment_leads_get_map_setting( 'heading_line2' ) ); ?></span>
			</h2>

			<?php if ( $rows ) : ?>
				<div class="visit-us__rows">
					<?php foreach ( $rows as $row ) : ?>
						<div class="visit-us__row">
							<div class="visit-us__row-icon"><?php power_equipment_leads_icon( $row['icon'] ); ?></div>
							<div>
								<div class="visit-us__row-title"><?php echo esc_html( $row['title'] ); ?></div>
								<?php foreach ( $row['lines'] as $line ) : ?>
									<div class="visit-us__row-line"><?php echo esc_html( $line ); ?></div>
								<?php endforeach; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<?php if ( $directions_text && $directions_link ) : ?>
				<a href="<?php echo esc_url( $directions_link ); ?>" target="_blank" rel="noreferrer" class="btn btn--industrial visit-us__cta">
					<?php echo esc_html( $directions_text ); ?>
					<?php power_equipment_leads_icon( 'arrow-right' ); ?>
				</a>
			<?php endif; ?>
		</div>

		<div class="visit-us__map reveal">
			<?php if ( $map_embed_url ) : ?>
				<iframe title="<?php echo esc_attr( get_bloginfo( 'name' ) . ' ' . __( 'Location', 'power-equipment-leads' ) ); ?>" src="<?php echo esc_url( $map_embed_url ); ?>" loading="lazy"></iframe>
			<?php else : ?>
				<div class="visit-us__map-placeholder">
					<?php power_equipment_leads_icon( 'map-pin' ); ?>
				</div>
			<?php endif; ?>
			<?php if ( $address1 ) : ?>
				<div class="visit-us__map-tag"><?php power_equipment_leads_icon( 'map-pin' ); ?> <?php echo esc_html( get_bloginfo( 'name' ) ); ?></div>
			<?php endif; ?>
		</div>
	</div>
</section>

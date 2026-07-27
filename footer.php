<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Power_Equipment_Leads
 */

?>

	<footer class="site-footer">
		<div class="footer-grid">
			<div class="footer-col brand-col">
				<div class="brand">
					<?php if ( has_custom_logo() ) : ?>
						<?php the_custom_logo(); ?>
					<?php else : ?>
						<?php $power_equipment_leads_brand_text = power_equipment_leads_get_theme_setting( 'brand_initials' ); ?>
						<span class="brand-mark clip-diagonal-b">
							<?php if ( $power_equipment_leads_brand_text ) : ?>
								<?php echo esc_html( $power_equipment_leads_brand_text ); ?>
							<?php else : ?>
								<?php power_equipment_leads_icon( 'flame' ); ?>
							<?php endif; ?>
						</span>
						<span class="brand-text">
							<span class="brand-name"><?php bloginfo( 'name' ); ?></span>
						</span>
					<?php endif; ?>
				</div>
				<?php $power_equipment_leads_footer_tagline = power_equipment_leads_get_theme_setting( 'footer_tagline' ); ?>
				<?php if ( $power_equipment_leads_footer_tagline ) : ?>
					<p class="footer-tag"><?php echo esc_html( $power_equipment_leads_footer_tagline ); ?></p>
				<?php endif; ?>
			</div>

			<div class="footer-col">
				<h4><?php esc_html_e( 'Shop', 'power-equipment-leads' ); ?></h4>
				<?php
				power_equipment_leads_footer_col_nav(
					'footer-shop',
					array(
						array( 'url' => '#equipment', 'label' => __( 'Mowers', 'power-equipment-leads' ) ),
						array( 'url' => '#equipment', 'label' => __( 'Chainsaws', 'power-equipment-leads' ) ),
						array( 'url' => '#equipment', 'label' => __( 'Tractors', 'power-equipment-leads' ) ),
						array( 'url' => '#equipment', 'label' => __( 'Generators', 'power-equipment-leads' ) ),
					)
				);
				?>
			</div>

			<div class="footer-col">
				<h4><?php esc_html_e( 'Services', 'power-equipment-leads' ); ?></h4>
				<?php
				power_equipment_leads_footer_col_nav(
					'footer-company',
					array(
						array( 'url' => '#services', 'label' => __( 'Sales', 'power-equipment-leads' ) ),
						array( 'url' => '#services', 'label' => __( 'Repairs', 'power-equipment-leads' ) ),
						array( 'url' => '#services', 'label' => __( 'Maintenance', 'power-equipment-leads' ) ),
						array( 'url' => '#financing', 'label' => __( 'Financing', 'power-equipment-leads' ) ),
					)
				);
				?>
			</div>
		</div>

		<div class="footer-bar">
			<p>
				<?php
				printf(
					/* translators: 1: Current year, 2: Site name. */
					esc_html__( '© %1$s %2$s. All rights reserved.', 'power-equipment-leads' ),
					'<span id="year"></span>',
					esc_html( get_bloginfo( 'name' ) )
				);
				?>
			</p>
			<div class="footer-links">
				<?php esc_html_e( 'Authorized Dealer · Warranty Service Center', 'power-equipment-leads' ); ?>
			</div>
		</div>
	</footer><!-- .site-footer -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>

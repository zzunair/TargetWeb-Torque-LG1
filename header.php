<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Power_Equipment_Leads
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'power-equipment-leads' ); ?></a>

	<header class="site-header" id="siteHeader">
		<div class="header-inner">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="brand" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) . ' ' . __( 'home', 'power-equipment-leads' ) ); ?>">
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
						<?php $power_equipment_leads_logo_text = power_equipment_leads_get_theme_setting( 'logo_text' ); ?>
						<span class="brand-name"><?php echo esc_html( $power_equipment_leads_logo_text ? $power_equipment_leads_logo_text : 'MowtivatedPwr' ); ?></span>
						<?php $power_equipment_leads_tagline = get_bloginfo( 'description', 'display' ); ?>
						<?php if ( $power_equipment_leads_tagline ) : ?>
							<span class="brand-sub"><?php echo esc_html( $power_equipment_leads_tagline ); ?></span>
						<?php endif; ?>
					</span>
				<?php endif; ?>
			</a>

			<nav class="primary-nav" aria-label="<?php esc_attr_e( 'Primary', 'power-equipment-leads' ); ?>">
				<?php power_equipment_leads_primary_nav(); ?>
			</nav>

			<div class="header-cta">
				<?php $power_equipment_leads_phone = power_equipment_leads_get_theme_setting( 'phone' ); ?>
				<?php if ( $power_equipment_leads_phone ) : ?>
					<a href="tel:<?php echo esc_attr( power_equipment_leads_phone_href( $power_equipment_leads_phone ) ); ?>" class="phone-link">
						<?php power_equipment_leads_icon( 'phone', 'icon--sm' ); ?>
						<?php echo esc_html( $power_equipment_leads_phone ); ?>
					</a>
				<?php endif; ?>
				<a href="<?php echo esc_url( power_equipment_leads_get_theme_setting( 'cta_link' ) ); ?>" class="btn btn-industrial"><?php echo esc_html( power_equipment_leads_get_theme_setting( 'cta_text' ) ); ?></a>
			</div>

			<button class="menu-toggle" id="menuToggle" aria-label="<?php esc_attr_e( 'Open menu', 'power-equipment-leads' ); ?>" aria-expanded="false">
				<span></span><span></span><span></span>
			</button>
		</div>

		<div class="mobile-nav" id="mobileNav" hidden>
			<?php power_equipment_leads_primary_nav(); ?>
			<a href="<?php echo esc_url( power_equipment_leads_get_theme_setting( 'cta_link' ) ); ?>" class="btn btn-industrial btn-block"><?php echo esc_html( power_equipment_leads_get_theme_setting( 'cta_text' ) ); ?></a>
		</div>
	</header><!-- #siteHeader -->

<?php
/**
 * Power Equipment Leads Theme Customizer
 *
 * @package Power_Equipment_Leads
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function power_equipment_leads_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'power_equipment_leads_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'power_equipment_leads_customize_partial_blogdescription',
			)
		);
	}
}
add_action( 'customize_register', 'power_equipment_leads_customize_register' );

/**
 * Strips the Customizer back to what this theme actually uses, leaving
 * Site Identity, the theme's own panels, Menus and Additional CSS.
 *
 * Header Image, Background Image and the core Colors section are already
 * gone because the theme no longer declares custom-header/custom-background
 * support — they're listed here too so re-adding either support elsewhere
 * can't quietly bring the panels back. Nothing is lost for the other three:
 * widgets stay editable at Appearance > Widgets, the front page at
 * Settings > Reading, and the shop at WooCommerce > Settings.
 *
 * Hooked late so WooCommerce (which registers its panel at priority 10) has
 * run by the time this fires.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function power_equipment_leads_remove_unused_customizer_sections( $wp_customize ) {
	foreach ( array( 'widgets', 'woocommerce' ) as $panel ) {
		$wp_customize->remove_panel( $panel );
	}

	foreach ( array( 'colors', 'header_image', 'background_image', 'static_front_page' ) as $section ) {
		$wp_customize->remove_section( $section );
	}
}
add_action( 'customize_register', 'power_equipment_leads_remove_unused_customizer_sections', 20 );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function power_equipment_leads_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function power_equipment_leads_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function power_equipment_leads_customize_preview_js() {
	wp_enqueue_script( 'power-equipment-leads-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), _S_VERSION, true );
}
add_action( 'customize_preview_init', 'power_equipment_leads_customize_preview_js' );

/**
 * Field definitions (label, default value, sanitize callback) for every
 * Business Info setting. Centralized so the front end can fall back to
 * the same defaults shown in the Customizer before an admin ever saves
 * a value (get_theme_mod() does not use add_setting()'s default on its
 * own — it needs an explicit fallback passed in).
 *
 * @return array<string, array{label: string, default: string, sanitize?: string}>
 */
function power_equipment_leads_business_field_defs() {
	return array(
		'phone'          => array(
			'label'   => esc_html__( 'Phone Number', 'power-equipment-leads' ),
			'default' => '(555) 555-1234',
		),
		'email'          => array(
			'label'    => esc_html__( 'Email Address', 'power-equipment-leads' ),
			'default'  => 'sales@example.com',
			'sanitize' => 'sanitize_email',
		),
		'cta_text'       => array(
			'label'   => esc_html__( 'Header CTA Button Text', 'power-equipment-leads' ),
			'default' => esc_html__( 'Get Quote', 'power-equipment-leads' ),
		),
		'cta_link'       => array(
			'label'   => esc_html__( 'Header CTA Button Link', 'power-equipment-leads' ),
			'default' => '#quote',
		),
		'brand_initials' => array(
			'label'   => esc_html__( 'Brand Mark Text (leave blank for the flame icon)', 'power-equipment-leads' ),
			'default' => '',
		),
		'footer_tagline' => array(
			'label'   => esc_html__( 'Footer Tagline', 'power-equipment-leads' ),
			'default' => esc_html__( 'Built for the long haul.', 'power-equipment-leads' ),
		),
		'address_line1'  => array(
			'label'   => esc_html__( 'Address Line 1', 'power-equipment-leads' ),
			'default' => '2214 Foundry Road',
		),
		'address_line2'  => array(
			'label'   => esc_html__( 'Address Line 2 (City, State ZIP)', 'power-equipment-leads' ),
			'default' => 'Springfield, OH 45505',
		),
		'hours'          => array(
			'label'   => esc_html__( 'Business Hours', 'power-equipment-leads' ),
			'default' => 'Mon–Fri 7a–6p · Sat 8a–4p',
		),
	);
}

/**
 * Business info shown in the header/footer: phone, email, address, hours,
 * and the header call-to-action button. Lets the admin edit all of this
 * from Appearance > Customize without touching template code.
 */
function power_equipment_leads_business_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'pel_business_info',
		array(
			'title'    => esc_html__( 'Business Info', 'power-equipment-leads' ),
			'priority' => 30,
		)
	);

	foreach ( power_equipment_leads_business_field_defs() as $key => $field ) {
		$wp_customize->add_setting(
			'pel_' . $key,
			array(
				'default'           => $field['default'],
				'sanitize_callback' => $field['sanitize'] ?? 'sanitize_text_field',
				'transport'         => 'refresh',
			)
		);

		$wp_customize->add_control(
			'pel_' . $key,
			array(
				'section' => 'pel_business_info',
				'label'   => $field['label'],
				'type'    => 'text',
			)
		);
	}
}
add_action( 'customize_register', 'power_equipment_leads_business_customize_register' );

/**
 * Reads a Business Info setting, falling back to its documented default
 * (the same default shown in the Customizer) if it has never been saved.
 *
 * @param string $key One of: phone, email, cta_text, cta_link, brand_initials,
 *                     footer_tagline, address_line1, address_line2, hours.
 * @return string
 */
function power_equipment_leads_get_theme_setting( $key ) {
	$defs    = power_equipment_leads_business_field_defs();
	$default = isset( $defs[ $key ]['default'] ) ? $defs[ $key ]['default'] : '';

	return get_theme_mod( 'pel_' . $key, $default );
}

/**
 * Strips a display-formatted phone number down to digits (and a leading +)
 * for use in a tel: link.
 *
 * @param string $phone Display phone number, e.g. "(555) 555-1234".
 * @return string
 */
function power_equipment_leads_phone_href( $phone ) {
	return preg_replace( '/[^0-9+]/', '', $phone );
}

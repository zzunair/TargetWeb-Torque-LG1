<?php
/**
 * Brand colours: the Appearance > Customize > Colors section and the inline
 * CSS that feeds the chosen values into the design tokens in
 * assets/css/site.css.
 *
 * Only the two brand accents are exposed. Everything else in the palette
 * (backgrounds, borders, muted text) is part of the theme's industrial dark
 * look and derives from those two, so a single picker change carries through
 * to buttons, hovers, icon tiles and section accents.
 *
 * @package Power_Equipment_Leads
 */

/**
 * Field definitions for every brand colour: the label shown in the
 * Customizer, the default, and the CSS custom property it overrides.
 *
 * 'ink_property' names a companion property that holds the text colour used
 * on top of the chosen colour; it is calculated rather than picked.
 *
 * The defaults are hex equivalents of the oklch() values in site.css. They
 * are only used to seed the colour picker — while a setting still matches
 * its default nothing is printed, so an untouched theme renders the original
 * oklch palette exactly.
 *
 * @return array<string, array{label: string, description: string, default: string, property: string, ink_property?: string}>
 */
function power_equipment_leads_color_field_defs() {
	return array(
		'primary'   => array(
			'label'        => esc_html__( 'Primary Color', 'power-equipment-leads' ),
			'description'  => esc_html__( 'Buttons, links, icons, stat numbers and section accents.', 'power-equipment-leads' ),
			'default'      => '#ff7527',
			'property'     => '--primary',
			'ink_property' => '--primary-foreground',
		),
		'secondary' => array(
			'label'       => esc_html__( 'Secondary Color', 'power-equipment-leads' ),
			'description' => esc_html__( 'The deeper ember accent: button underlines, card edges and hover highlights.', 'power-equipment-leads' ),
			'default'     => '#ed3b00',
			'property'    => '--ember',
		),
	);
}

/**
 * Reads a brand colour, falling back to the default shown in the Customizer.
 *
 * @param string $key Either 'primary' or 'secondary'.
 * @return string Hex colour.
 */
function power_equipment_leads_get_color( $key ) {
	$defs    = power_equipment_leads_color_field_defs();
	$default = isset( $defs[ $key ]['default'] ) ? $defs[ $key ]['default'] : '';

	return get_theme_mod( 'pel_color_' . $key, $default );
}

/**
 * Picks readable text for a filled swatch: near-black on light colours,
 * white on dark ones. 0.179 is the relative-luminance crossover at which
 * black and white give equal WCAG contrast.
 *
 * @param string $hex Hex colour, with or without the leading '#'.
 * @return string Hex colour.
 */
function power_equipment_leads_contrast_ink( $hex ) {
	$hex = ltrim( (string) $hex, '#' );

	if ( 3 === strlen( $hex ) ) {
		$hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
	}

	if ( 6 !== strlen( $hex ) || ! ctype_xdigit( $hex ) ) {
		return '#0b0d10';
	}

	$channels = array();

	foreach ( str_split( $hex, 2 ) as $pair ) {
		$channel    = hexdec( $pair ) / 255;
		$channels[] = $channel <= 0.04045 ? $channel / 12.92 : pow( ( $channel + 0.055 ) / 1.055, 2.4 );
	}

	$luminance = ( 0.2126 * $channels[0] ) + ( 0.7152 * $channels[1] ) + ( 0.0722 * $channels[2] );

	return $luminance > 0.179 ? '#0b0d10' : '#ffffff';
}

/**
 * Builds the `:root` rule that overrides the brand tokens in site.css.
 * Returns an empty string while every colour is still at its default.
 *
 * @return string
 */
function power_equipment_leads_color_variables_css() {
	$declarations = array();

	foreach ( power_equipment_leads_color_field_defs() as $key => $field ) {
		$value = power_equipment_leads_get_color( $key );

		if ( ! $value || strtolower( $value ) === strtolower( $field['default'] ) ) {
			continue;
		}

		$declarations[ $field['property'] ] = $value;

		if ( isset( $field['ink_property'] ) ) {
			$declarations[ $field['ink_property'] ] = power_equipment_leads_contrast_ink( $value );
		}
	}

	if ( empty( $declarations ) ) {
		return '';
	}

	$css = '';

	foreach ( $declarations as $property => $value ) {
		$css .= $property . ':' . $value . ';';
	}

	return ':root{' . $css . '}';
}

/**
 * Attaches the brand colour overrides to site.css, which declares the
 * defaults they replace.
 */
function power_equipment_leads_enqueue_color_variables() {
	$css = power_equipment_leads_color_variables_css();

	if ( '' === $css ) {
		return;
	}

	wp_add_inline_style( 'power-equipment-leads-site', $css );
}
add_action( 'wp_enqueue_scripts', 'power_equipment_leads_enqueue_color_variables', 20 );

/**
 * Registers the Colors section and a picker for each brand colour.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function power_equipment_leads_colors_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'pel_colors',
		array(
			'title'       => esc_html__( 'Colors', 'power-equipment-leads' ),
			'description' => esc_html__( 'The two brand accents. Hover states, tinted icon tiles and the text colour used on top of a filled button all follow the primary colour automatically.', 'power-equipment-leads' ),
			'priority'    => 28,
		)
	);

	foreach ( power_equipment_leads_color_field_defs() as $key => $field ) {
		$setting = 'pel_color_' . $key;

		$wp_customize->add_setting(
			$setting,
			array(
				'default'           => $field['default'],
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'         => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$setting,
				array(
					'section'     => 'pel_colors',
					'label'       => $field['label'],
					'description' => $field['description'],
				)
			)
		);
	}
}
add_action( 'customize_register', 'power_equipment_leads_colors_customize_register' );

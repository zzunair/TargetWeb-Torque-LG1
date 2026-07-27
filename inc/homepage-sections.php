<?php
/**
 * Homepage sections (Hero, Stats, Categories, Services, ...) rendered in a
 * fixed order by front-page.php, with every field editable from
 * Appearance > Customize > Homepage Sections — no block editor required.
 *
 * Each section lives in its own file under inc/sections/ and follows the
 * same pattern:
 * 1. A `*_field_defs()` function describing its fields (label, default,
 *    control type, sanitize callback, and for 'select' fields a 'choices'
 *    array).
 * 2. A `power_equipment_leads_get_{section}_setting( $key )` accessor that
 *    falls back to the field's own default (get_theme_mod() does not use
 *    a control's registered default on its own).
 * 3. A matching template-parts/sections/{section}.php that renders it.
 *
 * This file wires all of them into a single Customizer panel.
 *
 * @package Power_Equipment_Leads
 */

foreach (
	array(
		'hero',
		'stats',
		'ticker',
		'categories',
		'services',
		'specials',
		'financing',
		'testimonials',
		'faq',
		'lead-form',
		'map',
	) as $power_equipment_leads_section_file
) {
	require get_template_directory() . '/inc/sections/' . $power_equipment_leads_section_file . '.php';
}
unset( $power_equipment_leads_section_file );

/**
 * Casts a Customizer checkbox value to a real boolean.
 *
 * @param mixed $value Raw value from the Customizer control.
 * @return bool
 */
function power_equipment_leads_sanitize_checkbox( $value ) {
	return (bool) $value;
}

/**
 * Registers the "Homepage Sections" panel and every section within it.
 * Each section's field-defs function is defined in inc/sections/*.php and
 * named power_equipment_leads_{section}_field_defs().
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function power_equipment_leads_register_homepage_sections( $wp_customize ) {
	$wp_customize->add_panel(
		'pel_homepage_sections',
		array(
			'title'       => esc_html__( 'Homepage Sections', 'power-equipment-leads' ),
			'description' => esc_html__( 'Edit the content of every section on the homepage. Sections render in a fixed order; use the checkbox at the top of each to show/hide it.', 'power-equipment-leads' ),
			'priority'    => 25,
		)
	);

	$sections = array(
		'hero'         => array( 'pel_hero_section', esc_html__( '1. Hero', 'power-equipment-leads' ), 'pel_hero_' ),
		'stats'        => array( 'pel_stats_section', esc_html__( '2. Quick Stats', 'power-equipment-leads' ), 'pel_stats_' ),
		'ticker'       => array( 'pel_ticker_section', esc_html__( '3. Brand Ticker', 'power-equipment-leads' ), 'pel_ticker_' ),
		'categories'   => array( 'pel_categories_section', esc_html__( '4. Equipment Categories', 'power-equipment-leads' ), 'pel_categories_' ),
		'services'     => array( 'pel_services_section', esc_html__( '5. Services', 'power-equipment-leads' ), 'pel_services_' ),
		'specials'     => array( 'pel_specials_section', esc_html__( '6. Specials', 'power-equipment-leads' ), 'pel_specials_' ),
		'financing'    => array( 'pel_financing_section', esc_html__( '7. Financing Banner', 'power-equipment-leads' ), 'pel_financing_' ),
		'testimonials' => array( 'pel_testimonials_section', esc_html__( '8. Testimonials', 'power-equipment-leads' ), 'pel_testimonials_' ),
		'faq'          => array( 'pel_faq_section', esc_html__( '9. FAQ', 'power-equipment-leads' ), 'pel_faq_' ),
		'lead_form'    => array( 'pel_lead_form_section', esc_html__( '10. Lead Form', 'power-equipment-leads' ), 'pel_lead_form_' ),
		'map'          => array( 'pel_map_section', esc_html__( '11. Visit Us / Map', 'power-equipment-leads' ), 'pel_map_' ),
	);

	foreach ( $sections as $slug => $section ) {
		$field_defs_fn = 'power_equipment_leads_' . str_replace( '-', '_', $slug ) . '_field_defs';
		if ( ! function_exists( $field_defs_fn ) ) {
			continue;
		}
		power_equipment_leads_register_section_fields( $wp_customize, $section[0], $section[1], $section[2], $field_defs_fn() );
	}
}
add_action( 'customize_register', 'power_equipment_leads_register_homepage_sections' );

/**
 * Registers a Customizer section plus a setting/control for every field
 * definition passed in. Shared by every homepage section so adding a new
 * section is just: write a field-defs function + a template part.
 *
 * @param WP_Customize_Manager $wp_customize   Customizer manager.
 * @param string               $section_id     Customizer section id.
 * @param string               $title          Section title shown in the panel.
 * @param string               $setting_prefix Prefix used for every theme_mod key (e.g. "pel_hero_").
 * @param array                $field_defs     Field definitions, see e.g. power_equipment_leads_hero_field_defs().
 */
function power_equipment_leads_register_section_fields( $wp_customize, $section_id, $title, $setting_prefix, $field_defs ) {
	$wp_customize->add_section(
		$section_id,
		array(
			'title' => $title,
			'panel' => 'pel_homepage_sections',
		)
	);

	foreach ( $field_defs as $key => $field ) {
		$setting_id = $setting_prefix . $key;
		$type       = $field['type'] ?? 'text';

		$wp_customize->add_setting(
			$setting_id,
			array(
				'default'           => $field['default'],
				'sanitize_callback' => $field['sanitize'] ?? 'sanitize_text_field',
				'transport'         => 'refresh',
			)
		);

		if ( 'image' === $type ) {
			$wp_customize->add_control(
				new WP_Customize_Image_Control(
					$wp_customize,
					$setting_id,
					array(
						'section' => $section_id,
						'label'   => $field['label'],
					)
				)
			);
			continue;
		}

		$control_args = array(
			'section' => $section_id,
			'label'   => $field['label'],
			'type'    => $type,
		);

		if ( 'select' === $type && isset( $field['choices'] ) ) {
			$control_args['choices'] = $field['choices'];
		}

		$wp_customize->add_control( $setting_id, $control_args );
	}
}

/**
 * Reads a homepage section setting, falling back to its field definition's
 * default if it has never been saved.
 *
 * @param array  $field_defs     Field definitions for the section.
 * @param string $setting_prefix Theme mod key prefix (e.g. "pel_hero_").
 * @param string $key            Field key within $field_defs.
 * @return mixed
 */
function power_equipment_leads_get_section_setting( $field_defs, $setting_prefix, $key ) {
	$default = isset( $field_defs[ $key ]['default'] ) ? $field_defs[ $key ]['default'] : '';
	return get_theme_mod( $setting_prefix . $key, $default );
}

/**
 * Outputs the shared "eyebrow + heading (+ optional accent word) + copy"
 * header used by most homepage sections (Categories, Services, Specials,
 * Testimonials, FAQ, ...), so each section's template only has to call
 * this once instead of re-building the same markup.
 *
 * @param string $eyebrow Small uppercase label above the heading.
 * @param string $heading Main heading text.
 * @param string $accent  Optional accent-colored word appended after $heading.
 * @param string $copy    Optional supporting paragraph.
 * @param string $align   'center' (default) or 'left'.
 */
function power_equipment_leads_section_head( $eyebrow, $heading, $accent = '', $copy = '', $align = 'center' ) {
	?>
	<div class="section-head section-head--<?php echo esc_attr( $align ); ?> reveal">
		<?php if ( $eyebrow ) : ?>
			<div class="section-head__eyebrow-row">
				<span class="section-head__rule"></span>
				<span class="eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
				<span class="section-head__rule"></span>
			</div>
		<?php endif; ?>
		<?php if ( $heading ) : ?>
			<h2 class="section-head__title">
				<?php echo esc_html( $heading ); ?>
				<?php if ( $accent ) : ?>
					<span class="accent"><?php echo esc_html( $accent ); ?></span>
				<?php endif; ?>
			</h2>
		<?php endif; ?>
		<?php if ( $copy ) : ?>
			<p class="section-head__copy"><?php echo esc_html( $copy ); ?></p>
		<?php endif; ?>
	</div>
	<?php
}

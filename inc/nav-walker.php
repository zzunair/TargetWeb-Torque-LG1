<?php
/**
 * Custom nav menu walker + helpers for the flat, unordered-list-free menus
 * used by the header/footer design (primary nav, footer legal links).
 *
 * @package Power_Equipment_Leads
 */

/**
 * Outputs each top-level menu item as a plain <a>, with no wrapping
 * <ul>/<li>, so the flexbox row layout in the design's CSS applies
 * directly to the links.
 */
class Power_Equipment_Leads_Flat_Nav_Walker extends Walker_Nav_Menu {

	/**
	 * Suppresses the default <ul> wrapper for sub-menus (unused here).
	 *
	 * @param string   $output Passed by reference.
	 * @param int      $depth  Depth of the menu.
	 * @param stdClass $args   Nav menu args.
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ) {}

	/**
	 * Suppresses the default </ul> wrapper for sub-menus (unused here).
	 *
	 * @param string   $output Passed by reference.
	 * @param int      $depth  Depth of the menu.
	 * @param stdClass $args   Nav menu args.
	 */
	public function end_lvl( &$output, $depth = 0, $args = null ) {}

	/**
	 * Outputs a single menu item as a bare <a> tag.
	 *
	 * @param string   $output Passed by reference.
	 * @param WP_Post  $item   Menu item.
	 * @param int      $depth  Depth of the menu item.
	 * @param stdClass $args   Nav menu args.
	 * @param int      $id     Menu item ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$output .= sprintf(
			'<a href="%s"%s>%s</a>',
			esc_url( $item->url ),
			$item->current ? ' aria-current="page"' : '',
			esc_html( $item->title )
		);
	}

	/**
	 * No-op: start_el() already outputs the closing tag.
	 *
	 * @param string  $output Passed by reference.
	 * @param WP_Post $item   Menu item.
	 * @param int     $depth  Depth of the menu item.
	 * @param stdClass $args  Nav menu args.
	 */
	public function end_el( &$output, $item, $depth = 0, $args = null ) {}
}

/**
 * Renders the primary nav links. Falls back to the design's default
 * homepage-section anchors until an admin assigns a menu under
 * Appearance > Menus > Primary.
 */
function power_equipment_leads_primary_nav() {
	wp_nav_menu(
		tw_main_menu_args(
			array(
				'theme_location' => 'menu-1',
				'container'      => false,
				'items_wrap'     => '%3$s',
				'walker'         => new Power_Equipment_Leads_Flat_Nav_Walker(),
				'fallback_cb'    => false,
				'depth'          => 1,
			)
		)
	);
}

/**
 * Default primary nav links (anchors to the landing page sections).
 */
function power_equipment_leads_primary_nav_fallback() {
	$links = array(
		'#equipment' => __( 'Equipment', 'power-equipment-leads' ),
		'#services'  => __( 'Services', 'power-equipment-leads' ),
		'#specials'  => __( 'Specials', 'power-equipment-leads' ),
		'#financing' => __( 'Financing', 'power-equipment-leads' ),
		'#contact'   => __( 'Contact', 'power-equipment-leads' ),
	);
	foreach ( $links as $url => $label ) {
		printf( '<a href="%s">%s</a>', esc_url( $url ), esc_html( $label ) );
	}
}

/**
 * Renders a footer column's link list (used for "Shop" and "Services")
 * as a normal <ul><li><a> list.
 *
 * @param string $location Registered nav menu location.
 * @param array  $fallback List of ['url' => ..., 'label' => ...] pairs used
 *                         until an admin assigns a menu to this location
 *                         (a plain list, not keyed by url, since several
 *                         fallback links legitimately share the same anchor).
 */
function power_equipment_leads_footer_col_nav( $location, $fallback = array() ) {
	wp_nav_menu(
		array(
			'theme_location' => $location,
			'container'      => false,
			'menu_class'     => '',
			'items_wrap'     => '<ul>%3$s</ul>',
			'depth'          => 1,
			'fallback_cb'    => function () use ( $fallback ) {
				echo '<ul>';
				foreach ( $fallback as $link ) {
					printf( '<li><a href="%s">%s</a></li>', esc_url( $link['url'] ), esc_html( $link['label'] ) );
				}
				echo '</ul>';
			},
		)
	);
}

/**
 * Renders the footer legal links (Privacy, Terms, Warranty) as bare <a> tags.
 */
function power_equipment_leads_footer_legal_nav() {
	wp_nav_menu(
		array(
			'theme_location' => 'footer-legal',
			'container'      => false,
			'items_wrap'     => '%3$s',
			'walker'         => new Power_Equipment_Leads_Flat_Nav_Walker(),
			'depth'          => 1,
			'fallback_cb'    => function () {
				$links = array(
					'#' => __( 'Privacy', 'power-equipment-leads' ),
				);
				foreach ( $links as $url => $label ) {
					printf( '<a href="%s">%s</a>', esc_url( $url ), esc_html( $label ) );
				}
			},
		)
	);
}

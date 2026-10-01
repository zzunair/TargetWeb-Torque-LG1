<?php
/**
 * Power Equipment Leads functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Power_Equipment_Leads
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function power_equipment_leads_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Power Equipment Leads, use a find and replace
		* to change 'power-equipment-leads' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'power-equipment-leads', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in the header and footer.
	register_nav_menus(
		array(
			'menu-1'         => esc_html__( 'Primary', 'power-equipment-leads' ),
			'footer-shop'    => esc_html__( 'Footer: Shop Column', 'power-equipment-leads' ),
			'footer-company' => esc_html__( 'Footer: Company Column', 'power-equipment-leads' ),
			'footer-legal'   => esc_html__( 'Footer: Legal Links', 'power-equipment-leads' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Enable wide/full alignment and responsive embeds for the block editor
	// (used on regular posts/pages; the homepage itself no longer relies on blocks).
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'power_equipment_leads_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function power_equipment_leads_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'power_equipment_leads_content_width', 640 );
}
add_action( 'after_setup_theme', 'power_equipment_leads_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function power_equipment_leads_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'power-equipment-leads' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'power-equipment-leads' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'power_equipment_leads_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function power_equipment_leads_scripts() {
	wp_enqueue_style( 'power-equipment-leads-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'power-equipment-leads-style', 'rtl', 'replace' );

	wp_enqueue_style(
		'power-equipment-leads-fonts',
		'https://fonts.googleapis.com/css2?family=Oswald:wght@500;600;700&family=Barlow+Condensed:wght@400;600;700&family=Barlow:wght@400;500;600&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'power-equipment-leads-site',
		get_template_directory_uri() . '/assets/css/site.css',
		array( 'power-equipment-leads-style', 'power-equipment-leads-fonts' ),
		_S_VERSION
	);

	if ( is_front_page() ) {
		wp_enqueue_style(
			'power-equipment-leads-sections',
			get_template_directory_uri() . '/assets/css/sections.css',
			array( 'power-equipment-leads-site' ),
			_S_VERSION
		);
	}

	wp_enqueue_script(
		'power-equipment-leads-main',
		get_template_directory_uri() . '/assets/js/main.js',
		array(),
		_S_VERSION,
		true
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'power_equipment_leads_scripts' );

/**
 * Preconnects to Google Fonts' origins for faster font loading.
 *
 * @param array  $urls          Resource hint URLs to output.
 * @param string $relation_type Relation type (dns-prefetch, preconnect, etc.).
 * @return array
 */
function power_equipment_leads_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href'        => 'https://fonts.googleapis.com',
			'crossorigin' => false,
		);
		$urls[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'power_equipment_leads_resource_hints', 10, 2 );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Brand colour settings and the inline CSS that applies them.
 */
require get_template_directory() . '/inc/colors.php';

/**
 * Custom nav menu walker used by the header/footer nav locations.
 */
require get_template_directory() . '/inc/nav-walker.php';

/**
 * Inline SVG icon helper used across the homepage sections.
 */
require get_template_directory() . '/inc/icons.php';

/**
 * Homepage section settings (Hero, Quick Stats, Lead Form, etc.) — all
 * editable from Appearance > Customize instead of the block editor.
 */
require get_template_directory() . '/inc/homepage-sections.php';

/**
 * Lead capture: storage, AJAX handler, and admin settings.
 */
require get_template_directory() . '/inc/leads.php';

/**
 * GitHub theme updates (Appearance → Themes).
 */
if ( file_exists( get_template_directory() . '/inc/theme-updater.php' ) ) {
	require_once get_template_directory() . '/inc/theme-updater.php';
}

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}


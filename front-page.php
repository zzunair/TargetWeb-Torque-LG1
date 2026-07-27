<?php
/**
 * The template for displaying the front page (landing page)
 *
 * Renders a fixed stack of sections. Every section's content, and whether
 * it's shown at all, is edited from Appearance > Customize > Homepage
 * Sections — this template intentionally doesn't touch post content, so
 * it works regardless of the Settings > Reading configuration.
 *
 * @package Power_Equipment_Leads
 */

get_header();
?>

	<main id="primary" class="site-main landing-page">
		<?php
		get_template_part( 'template-parts/sections/hero' );
		get_template_part( 'template-parts/sections/ticker' );
		get_template_part( 'template-parts/sections/stats' );
		get_template_part( 'template-parts/sections/categories' );
		get_template_part( 'template-parts/sections/services' );
		get_template_part( 'template-parts/sections/specials' );
		get_template_part( 'template-parts/sections/financing' );
		get_template_part( 'template-parts/sections/testimonials' );
		get_template_part( 'template-parts/sections/faq' );
		get_template_part( 'template-parts/sections/lead-form' );
		get_template_part( 'template-parts/sections/map' );
		?>
	</main><!-- #main -->

<?php
get_footer();

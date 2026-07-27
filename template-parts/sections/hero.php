<?php
/**
 * Hero section.
 *
 * Content editable via Appearance > Customize > Homepage Sections > 1. Hero.
 *
 * @package Power_Equipment_Leads
 */

if ( ! power_equipment_leads_get_hero_setting( 'show' ) ) {
	return;
}

$background_url = power_equipment_leads_get_hero_setting( 'background_image' );
$eyebrow         = power_equipment_leads_get_hero_setting( 'eyebrow_text' );
$lede            = power_equipment_leads_get_hero_setting( 'lede_text' );
$primary_text    = power_equipment_leads_get_hero_setting( 'primary_button_text' );
$secondary_text  = power_equipment_leads_get_hero_setting( 'secondary_button_text' );
$watermark       = power_equipment_leads_get_hero_setting( 'watermark_text' );

$badges = array(
	array(
		'icon' => power_equipment_leads_get_hero_setting( 'badge1_icon' ),
		'text' => power_equipment_leads_get_hero_setting( 'badge1_text' ),
	),
	array(
		'icon' => power_equipment_leads_get_hero_setting( 'badge2_icon' ),
		'text' => power_equipment_leads_get_hero_setting( 'badge2_text' ),
	),
);
?>
<section id="top" class="hero clip-diagonal-b" aria-label="<?php esc_attr_e( 'Hero', 'power-equipment-leads' ); ?>">
	<?php if ( $background_url ) : ?>
		<div class="hero__media">
			<img src="<?php echo esc_url( $background_url ); ?>" alt="" />
			<div class="hero__scrim"></div>
		</div>
	<?php endif; ?>
	<div class="hero__grid bg-grid" aria-hidden="true"></div>

	<div class="container hero__inner">
		<?php if ( $eyebrow ) : ?>
			<div class="hero__eyebrow-row">
				<span class="hero__rule"></span>
				<span class="eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
			</div>
		<?php endif; ?>

		<h1 class="hero__title">
			<?php echo esc_html( power_equipment_leads_get_hero_setting( 'heading_line1' ) ); ?><br />
			<span class="accent"><?php echo esc_html( power_equipment_leads_get_hero_setting( 'heading_line2' ) ); ?></span><br />
			<?php echo esc_html( power_equipment_leads_get_hero_setting( 'heading_line3' ) ); ?>
		</h1>

		<?php if ( $lede ) : ?>
			<p class="hero__lede"><?php echo esc_html( $lede ); ?></p>
		<?php endif; ?>

		<div class="hero__cta">
			<?php if ( $primary_text ) : ?>
				<a href="<?php echo esc_url( power_equipment_leads_get_hero_setting( 'primary_button_link' ) ); ?>" class="btn btn--industrial btn--lg"><?php echo esc_html( $primary_text ); ?></a>
			<?php endif; ?>
			<?php if ( $secondary_text ) : ?>
				<a href="<?php echo esc_url( power_equipment_leads_get_hero_setting( 'secondary_button_link' ) ); ?>" class="btn btn--steel btn--lg"><?php echo esc_html( $secondary_text ); ?></a>
			<?php endif; ?>
		</div>

		<ul class="hero__badges">
			<?php foreach ( $badges as $badge ) : ?>
				<?php if ( empty( $badge['text'] ) ) { continue; } ?>
				<li><?php power_equipment_leads_icon( $badge['icon'] ?: 'shield' ); ?> <?php echo esc_html( $badge['text'] ); ?></li>
			<?php endforeach; ?>
		</ul>
	</div>

	<?php if ( $watermark ) : ?>
		<div class="hero__watermark" aria-hidden="true"><?php echo esc_html( $watermark ); ?></div>
	<?php endif; ?>
</section>

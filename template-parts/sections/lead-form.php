<?php
/**
 * Lead Form section.
 *
 * Content editable via Appearance > Customize > Homepage Sections > 10. Lead Form.
 *
 * The TargetWeb CRM plugin injects its form into #leads-form-div and owns the
 * submit. data-tw-crm-inline marks this as a simple in-page form (not a popup).
 *
 * @package Power_Equipment_Leads
 */

if ( ! power_equipment_leads_get_lead_form_setting( 'show' ) ) {
	return;
}

$anchor_id = power_equipment_leads_get_lead_form_setting( 'anchor_id' );
$copy      = power_equipment_leads_get_lead_form_setting( 'copy' );

$badges = array();
for ( $i = 1; $i <= 3; $i++ ) {
	$badges[] = array(
		'icon'  => power_equipment_leads_get_lead_form_setting( "badge{$i}_icon" ),
		'key'   => power_equipment_leads_get_lead_form_setting( "badge{$i}_key" ),
		'value' => power_equipment_leads_get_lead_form_setting( "badge{$i}_value" ),
	);
}
?>
<section class="lead-form-section" id="<?php echo esc_attr( $anchor_id ); ?>" aria-label="<?php esc_attr_e( 'Get a Quote', 'power-equipment-leads' ); ?>">
	<div class="container lead-form-section__inner">
		<div class="lead-form-section__intro reveal">
			<?php $eyebrow = power_equipment_leads_get_lead_form_setting( 'eyebrow' ); ?>
			<?php if ( $eyebrow ) : ?>
				<span class="eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
			<?php endif; ?>
			<h2 class="lead-form-section__title">
				<?php echo esc_html( power_equipment_leads_get_lead_form_setting( 'heading_line1' ) ); ?><br />
				<span class="accent"><?php echo esc_html( power_equipment_leads_get_lead_form_setting( 'heading_line2' ) ); ?></span>
			</h2>
			<?php if ( $copy ) : ?>
				<p class="lead-form-section__copy"><?php echo esc_html( $copy ); ?></p>
			<?php endif; ?>

			<div class="lead-form-section__badges">
				<?php foreach ( $badges as $badge ) : ?>
					<?php if ( empty( $badge['key'] ) ) { continue; } ?>
					<div class="lead-form-badge">
						<div class="lead-form-badge__icon"><?php power_equipment_leads_icon( $badge['icon'] ?: 'shield' ); ?></div>
						<div>
							<div class="lead-form-badge__key"><?php echo esc_html( $badge['key'] ); ?></div>
							<div class="lead-form-badge__value"><?php echo esc_html( $badge['value'] ); ?></div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>

		<div class="lead-form-card reveal">
			<div class="lead-form-card__badge"><?php power_equipment_leads_icon( 'flame' ); ?></div>

			<div id="tw-crm-popup" data-tw-crm-inline>
				<div id="leads-form-div"></div>
			</div>

			<?php $disclaimer = power_equipment_leads_get_lead_form_setting( 'disclaimer' ); ?>
			<?php if ( $disclaimer ) : ?>
				<p class="pel-lead-form__disclaimer"><?php echo esc_html( $disclaimer ); ?></p>
			<?php endif; ?>
		</div>
	</div>
</section>

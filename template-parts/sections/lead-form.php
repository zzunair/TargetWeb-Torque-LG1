<?php
/**
 * Lead Form section.
 *
 * Content editable via Appearance > Customize > Homepage Sections > 10. Lead Form.
 * Submissions are handled by inc/leads.php (see Leads > Settings in wp-admin).
 *
 * @package Power_Equipment_Leads
 */

if ( ! power_equipment_leads_get_lead_form_setting( 'show' ) ) {
	return;
}

wp_enqueue_script( 'power-equipment-leads-leads' );

$anchor_id            = power_equipment_leads_get_lead_form_setting( 'anchor_id' );
$form_id              = power_equipment_leads_get_lead_form_setting( 'form_id' );
$copy                 = power_equipment_leads_get_lead_form_setting( 'copy' );
$show_zip_field       = power_equipment_leads_get_lead_form_setting( 'show_zip_field' );
$show_equipment_field = power_equipment_leads_get_lead_form_setting( 'show_equipment_field' );
$show_message_field   = power_equipment_leads_get_lead_form_setting( 'show_message_field' );
$equipment_choices    = power_equipment_leads_get_lead_form_equipment_choices();

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

			<form class="pel-lead-form" data-form-id="<?php echo esc_attr( $form_id ); ?>" novalidate>
				<div class="pel-lead-form__grid">
					<div class="pel-lead-form__row">
						<label for="pel-name-<?php echo esc_attr( $form_id ); ?>"><?php esc_html_e( 'Full Name', 'power-equipment-leads' ); ?></label>
						<input type="text" id="pel-name-<?php echo esc_attr( $form_id ); ?>" name="name" autocomplete="name" placeholder="<?php esc_attr_e( 'John Doe', 'power-equipment-leads' ); ?>" required>
					</div>

					<div class="pel-lead-form__row">
						<label for="pel-phone-<?php echo esc_attr( $form_id ); ?>"><?php esc_html_e( 'Phone', 'power-equipment-leads' ); ?></label>
						<input type="tel" id="pel-phone-<?php echo esc_attr( $form_id ); ?>" name="phone" autocomplete="tel" placeholder="<?php esc_attr_e( '(555) 000-0000', 'power-equipment-leads' ); ?>" required>
					</div>

					<div class="pel-lead-form__row">
						<label for="pel-email-<?php echo esc_attr( $form_id ); ?>"><?php esc_html_e( 'Email', 'power-equipment-leads' ); ?></label>
						<input type="email" id="pel-email-<?php echo esc_attr( $form_id ); ?>" name="email" autocomplete="email" placeholder="<?php esc_attr_e( 'you@example.com', 'power-equipment-leads' ); ?>" required>
					</div>

					<?php if ( $show_zip_field ) : ?>
						<div class="pel-lead-form__row">
							<label for="pel-zip-<?php echo esc_attr( $form_id ); ?>"><?php esc_html_e( 'ZIP Code', 'power-equipment-leads' ); ?></label>
							<input type="text" inputmode="numeric" id="pel-zip-<?php echo esc_attr( $form_id ); ?>" name="zip" autocomplete="postal-code" placeholder="00000" required>
						</div>
					<?php endif; ?>
				</div>

				<?php if ( $show_equipment_field && $equipment_choices ) : ?>
					<div class="pel-lead-form__row pel-lead-form__row--full">
						<label for="pel-equipment-<?php echo esc_attr( $form_id ); ?>"><?php esc_html_e( 'Equipment Interest', 'power-equipment-leads' ); ?></label>
						<select id="pel-equipment-<?php echo esc_attr( $form_id ); ?>" name="equipment_interest" required>
							<option value="" disabled selected><?php esc_html_e( 'Select a category…', 'power-equipment-leads' ); ?></option>
							<?php foreach ( $equipment_choices as $choice ) : ?>
								<option value="<?php echo esc_attr( $choice ); ?>"><?php echo esc_html( $choice ); ?></option>
							<?php endforeach; ?>
							<option value="other"><?php esc_html_e( 'Something else / Not sure', 'power-equipment-leads' ); ?></option>
						</select>
					</div>
				<?php endif; ?>

				<?php if ( $show_message_field ) : ?>
					<div class="pel-lead-form__row pel-lead-form__row--full">
						<label for="pel-message-<?php echo esc_attr( $form_id ); ?>"><?php esc_html_e( 'Tell us about the job', 'power-equipment-leads' ); ?></label>
						<textarea id="pel-message-<?php echo esc_attr( $form_id ); ?>" name="message" rows="4" placeholder="<?php esc_attr_e( 'Acreage, brand preference, budget range, timeline…', 'power-equipment-leads' ); ?>"></textarea>
					</div>
				<?php endif; ?>

				<div class="pel-lead-form__row pel-lead-form__honeypot" aria-hidden="true">
					<label for="pel-hp-<?php echo esc_attr( $form_id ); ?>">Leave this field empty</label>
					<input type="text" id="pel-hp-<?php echo esc_attr( $form_id ); ?>" name="pel_hp" tabindex="-1" autocomplete="off">
				</div>

				<div class="pel-lead-form__footer">
					<?php $disclaimer = power_equipment_leads_get_lead_form_setting( 'disclaimer' ); ?>
					<?php if ( $disclaimer ) : ?>
						<p class="pel-lead-form__disclaimer"><?php echo esc_html( $disclaimer ); ?></p>
					<?php endif; ?>
					<button type="submit" class="btn btn--industrial btn--lg pel-lead-form__submit">
						<?php echo esc_html( power_equipment_leads_get_lead_form_setting( 'button_text' ) ); ?>
						<?php power_equipment_leads_icon( 'arrow-right' ); ?>
					</button>
				</div>

				<p class="pel-lead-form__feedback" role="status" aria-live="polite"></p>
			</form>

			<div class="pel-lead-form__success" hidden>
				<div class="pel-lead-form__success-icon"><?php power_equipment_leads_icon( 'flame' ); ?></div>
				<h3><?php echo esc_html( power_equipment_leads_get_lead_form_setting( 'success_heading' ) ); ?></h3>
				<p><?php echo esc_html( power_equipment_leads_get_lead_form_setting( 'success_text' ) ); ?></p>
			</div>
		</div>
	</div>
</section>

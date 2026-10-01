<?php
/**
 * Lead capture: storage, submission handling, admin list, and settings.
 *
 * Any "Lead Form" section block on the front end posts to this handler via
 * the shared power_equipment_leads_leads.js script. Submissions are stored
 * as a custom post type (so they show up in a normal, sortable wp-admin
 * list) and an email notification is sent out.
 *
 * @package Power_Equipment_Leads
 */

/**
 * Registers the "Lead" custom post type used to store form submissions.
 */
function power_equipment_leads_register_lead_cpt() {
	register_post_type(
		'pel_lead',
		array(
			'labels'              => array(
				'name'          => esc_html__( 'Leads', 'power-equipment-leads' ),
				'singular_name' => esc_html__( 'Lead', 'power-equipment-leads' ),
				'all_items'     => esc_html__( 'All Leads', 'power-equipment-leads' ),
				'search_items'  => esc_html__( 'Search Leads', 'power-equipment-leads' ),
				'not_found'     => esc_html__( 'No leads found.', 'power-equipment-leads' ),
			),
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_admin_bar'   => false,
			'menu_icon'           => 'dashicons-email-alt',
			'menu_position'       => 25,
			'capability_type'     => 'page',
			'capabilities'        => array(
				'create_posts' => 'do_not_allow',
			),
			'map_meta_cap'        => true,
			'supports'            => array( 'title' ),
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'has_archive'         => false,
			'rewrite'             => false,
			'show_in_rest'        => false,
		)
	);
}
add_action( 'init', 'power_equipment_leads_register_lead_cpt' );

/**
 * Adds useful columns (email, phone, source page, date) to the Leads list table.
 *
 * @param array $columns Existing columns.
 * @return array
 */
function power_equipment_leads_lead_columns( $columns ) {
	$columns = array(
		'cb'              => $columns['cb'],
		'title'           => esc_html__( 'Name', 'power-equipment-leads' ),
		'lead_email'      => esc_html__( 'Email', 'power-equipment-leads' ),
		'lead_phone'      => esc_html__( 'Phone', 'power-equipment-leads' ),
		'lead_source'     => esc_html__( 'Source Page', 'power-equipment-leads' ),
		'date'            => $columns['date'],
	);

	return $columns;
}
add_filter( 'manage_pel_lead_posts_columns', 'power_equipment_leads_lead_columns' );

/**
 * Renders the custom Leads list table columns.
 *
 * @param string $column  Column key.
 * @param int    $post_id Post ID.
 */
function power_equipment_leads_lead_column_content( $column, $post_id ) {
	switch ( $column ) {
		case 'lead_email':
			echo esc_html( get_post_meta( $post_id, 'email', true ) );
			break;
		case 'lead_phone':
			echo esc_html( get_post_meta( $post_id, 'phone', true ) );
			break;
		case 'lead_source':
			$source_url = get_post_meta( $post_id, 'source_url', true );
			if ( $source_url ) {
				echo '<a href="' . esc_url( $source_url ) . '" target="_blank" rel="noopener noreferrer">' . esc_html( wp_parse_url( $source_url, PHP_URL_PATH ) ) . '</a>';
			}
			break;
	}
}
add_action( 'manage_pel_lead_posts_custom_column', 'power_equipment_leads_lead_column_content', 10, 2 );

/**
 * Shows lead detail (message, all submitted fields) in an edit-screen meta box.
 */
function power_equipment_leads_lead_meta_box() {
	add_meta_box(
		'pel_lead_details',
		esc_html__( 'Lead Details', 'power-equipment-leads' ),
		'power_equipment_leads_render_lead_meta_box',
		'pel_lead',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'power_equipment_leads_lead_meta_box' );

/**
 * Renders the lead detail meta box (read-only).
 *
 * @param WP_Post $post Current post.
 */
function power_equipment_leads_render_lead_meta_box( $post ) {
	// ZIP and Equipment Interest are no longer collected; they stay listed so
	// leads captured before the form change still show them.
	$fields = array(
		'first_name'         => esc_html__( 'First Name', 'power-equipment-leads' ),
		'last_name'          => esc_html__( 'Last Name', 'power-equipment-leads' ),
		'email'              => esc_html__( 'Email', 'power-equipment-leads' ),
		'phone'              => esc_html__( 'Phone', 'power-equipment-leads' ),
		'zip'                => esc_html__( 'ZIP Code', 'power-equipment-leads' ),
		'equipment_interest' => esc_html__( 'Equipment Interest', 'power-equipment-leads' ),
		'message'            => esc_html__( 'Message', 'power-equipment-leads' ),
		'source_url'         => esc_html__( 'Source Page', 'power-equipment-leads' ),
		'form_id'            => esc_html__( 'Form', 'power-equipment-leads' ),
	);

	echo '<table class="form-table"><tbody>';
	foreach ( $fields as $key => $label ) {
		$value = get_post_meta( $post->ID, $key, true );
		if ( '' === $value ) {
			continue;
		}
		echo '<tr><th scope="row">' . esc_html( $label ) . '</th><td>' . esc_html( $value ) . '</td></tr>';
	}
	echo '</tbody></table>';
}

/**
 * Enqueues the shared front-end script that powers every "Lead Form" block.
 */
function power_equipment_leads_enqueue_lead_script() {
	wp_register_script(
		'power-equipment-leads-leads',
		get_template_directory_uri() . '/js/leads.js',
		array(),
		_S_VERSION,
		true
	);

	wp_localize_script(
		'power-equipment-leads-leads',
		'PELLeads',
		array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'pel_submit_lead' ),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'power_equipment_leads_enqueue_lead_script' );

/**
 * Handles the AJAX lead form submission (logged-in and logged-out visitors).
 */
function power_equipment_leads_handle_lead_submission() {
	check_ajax_referer( 'pel_submit_lead', 'nonce' );

	// Honeypot: real visitors never fill this hidden field in.
	if ( ! empty( $_POST['pel_hp'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
		wp_send_json_success( array( 'message' => power_equipment_leads_get_setting( 'success_message' ) ) );
	}

	$first_name = isset( $_POST['first_name'] ) ? sanitize_text_field( wp_unslash( $_POST['first_name'] ) ) : '';
	$last_name  = isset( $_POST['last_name'] ) ? sanitize_text_field( wp_unslash( $_POST['last_name'] ) ) : '';
	$email      = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$phone      = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
	$message    = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';
	$form_id    = isset( $_POST['form_id'] ) ? sanitize_text_field( wp_unslash( $_POST['form_id'] ) ) : 'lead-form';
	$source     = isset( $_POST['source_url'] ) ? sanitize_url( wp_unslash( $_POST['source_url'] ) ) : '';
	$name       = trim( $first_name . ' ' . $last_name );

	if ( '' === $first_name || ! is_email( $email ) ) {
		wp_send_json_error(
			array( 'message' => esc_html__( 'Please enter your name and a valid email address.', 'power-equipment-leads' ) ),
			400
		);
	}

	$post_id = wp_insert_post(
		array(
			'post_type'   => 'pel_lead',
			'post_title'  => sprintf( '%s <%s>', $name, $email ),
			'post_status' => 'publish',
		)
	);

	if ( is_wp_error( $post_id ) || ! $post_id ) {
		wp_send_json_error( array( 'message' => esc_html__( 'Something went wrong. Please try again.', 'power-equipment-leads' ) ), 500 );
	}

	update_post_meta( $post_id, 'first_name', $first_name );
	update_post_meta( $post_id, 'last_name', $last_name );
	update_post_meta( $post_id, 'email', $email );
	update_post_meta( $post_id, 'phone', $phone );
	update_post_meta( $post_id, 'message', $message );
	update_post_meta( $post_id, 'form_id', $form_id );
	update_post_meta( $post_id, 'source_url', $source );

	power_equipment_leads_send_lead_notification( $post_id, $name, $email, $phone, $message );

	wp_send_json_success(
		array(
			'message'  => power_equipment_leads_get_setting( 'success_message' ),
			'redirect' => power_equipment_leads_get_setting( 'redirect_url' ),
		)
	);
}
add_action( 'wp_ajax_pel_submit_lead', 'power_equipment_leads_handle_lead_submission' );
add_action( 'wp_ajax_nopriv_pel_submit_lead', 'power_equipment_leads_handle_lead_submission' );

/**
 * Emails the configured notification address about a new lead.
 *
 * @param int    $post_id            Lead post ID.
 * @param string $name               Submitted name.
 * @param string $email              Submitted email.
 * @param string $phone              Submitted phone.
 * @param string $message            Submitted message.
 * @param string $zip                Submitted ZIP code, if any.
 * @param string $equipment_interest Submitted equipment interest, if any.
 */
function power_equipment_leads_send_lead_notification( $post_id, $name, $email, $phone, $message, $zip = '', $equipment_interest = '' ) {
	$to = power_equipment_leads_get_setting( 'notification_email' );

	if ( ! $to ) {
		return;
	}

	$subject = sprintf(
		/* translators: %s: site name. */
		esc_html__( 'New lead from %s', 'power-equipment-leads' ),
		wp_specialchars_decode( get_bloginfo( 'name' ) )
	);

	$body  = esc_html__( 'A new lead was submitted:', 'power-equipment-leads' ) . "\n\n";
	$body .= esc_html__( 'Name:', 'power-equipment-leads' ) . ' ' . $name . "\n";
	$body .= esc_html__( 'Email:', 'power-equipment-leads' ) . ' ' . $email . "\n";
	if ( $phone ) {
		$body .= esc_html__( 'Phone:', 'power-equipment-leads' ) . ' ' . $phone . "\n";
	}
	if ( $zip ) {
		$body .= esc_html__( 'ZIP:', 'power-equipment-leads' ) . ' ' . $zip . "\n";
	}
	if ( $equipment_interest ) {
		$body .= esc_html__( 'Equipment interest:', 'power-equipment-leads' ) . ' ' . $equipment_interest . "\n";
	}
	if ( $message ) {
		$body .= esc_html__( 'Message:', 'power-equipment-leads' ) . ' ' . $message . "\n";
	}
	$body .= "\n" . admin_url( 'post.php?post=' . $post_id . '&action=edit' );

	wp_mail( $to, $subject, $body );
}

/**
 * Registers the "Lead Settings" admin page (notification email, success
 * message, optional redirect) using the core Settings API — no ACF Options
 * Page required.
 */
function power_equipment_leads_register_lead_settings() {
	register_setting( 'pel_lead_settings', 'pel_notification_email', 'sanitize_email' );
	register_setting( 'pel_lead_settings', 'pel_success_message', 'sanitize_text_field' );
	register_setting( 'pel_lead_settings', 'pel_redirect_url', 'sanitize_url' );

	add_settings_section( 'pel_lead_settings_section', '', '__return_false', 'pel_lead_settings' );

	add_settings_field(
		'pel_notification_email',
		esc_html__( 'Notification email', 'power-equipment-leads' ),
		'power_equipment_leads_field_notification_email',
		'pel_lead_settings',
		'pel_lead_settings_section'
	);

	add_settings_field(
		'pel_success_message',
		esc_html__( 'Success message', 'power-equipment-leads' ),
		'power_equipment_leads_field_success_message',
		'pel_lead_settings',
		'pel_lead_settings_section'
	);

	add_settings_field(
		'pel_redirect_url',
		esc_html__( 'Redirect URL (optional)', 'power-equipment-leads' ),
		'power_equipment_leads_field_redirect_url',
		'pel_lead_settings',
		'pel_lead_settings_section'
	);
}
add_action( 'admin_init', 'power_equipment_leads_register_lead_settings' );

/**
 * Adds the "Lead Settings" submenu under the Leads post type menu.
 */
function power_equipment_leads_add_lead_settings_page() {
	add_submenu_page(
		'edit.php?post_type=pel_lead',
		esc_html__( 'Lead Settings', 'power-equipment-leads' ),
		esc_html__( 'Settings', 'power-equipment-leads' ),
		'manage_options',
		'pel-lead-settings',
		'power_equipment_leads_render_lead_settings_page'
	);
}
add_action( 'admin_menu', 'power_equipment_leads_add_lead_settings_page' );

/**
 * Renders the "Lead Settings" admin page.
 */
function power_equipment_leads_render_lead_settings_page() {
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Lead Settings', 'power-equipment-leads' ); ?></h1>
		<form method="post" action="options.php">
			<?php
			settings_fields( 'pel_lead_settings' );
			do_settings_sections( 'pel_lead_settings' );
			submit_button();
			?>
		</form>
	</div>
	<?php
}

/**
 * Field callback: notification email.
 */
function power_equipment_leads_field_notification_email() {
	$value = get_option( 'pel_notification_email', get_option( 'admin_email' ) );
	echo '<input type="email" class="regular-text" name="pel_notification_email" value="' . esc_attr( $value ) . '">';
	echo '<p class="description">' . esc_html__( 'Where new lead notifications are sent.', 'power-equipment-leads' ) . '</p>';
}

/**
 * Field callback: success message.
 */
function power_equipment_leads_field_success_message() {
	$value = get_option( 'pel_success_message', esc_html__( 'Thanks! We\'ll be in touch shortly.', 'power-equipment-leads' ) );
	echo '<input type="text" class="regular-text" name="pel_success_message" value="' . esc_attr( $value ) . '">';
}

/**
 * Field callback: redirect URL.
 */
function power_equipment_leads_field_redirect_url() {
	$value = get_option( 'pel_redirect_url', '' );
	echo '<input type="url" class="regular-text" name="pel_redirect_url" value="' . esc_attr( $value ) . '" placeholder="https://example.com/thank-you/">';
	echo '<p class="description">' . esc_html__( 'If set, visitors are redirected here after a successful submission instead of seeing the inline success message.', 'power-equipment-leads' ) . '</p>';
}

/**
 * Small helper to read a lead setting with a sensible fallback.
 *
 * @param string $key One of 'notification_email', 'success_message', 'redirect_url'.
 * @return string
 */
function power_equipment_leads_get_setting( $key ) {
	switch ( $key ) {
		case 'notification_email':
			return get_option( 'pel_notification_email', get_option( 'admin_email' ) );
		case 'success_message':
			return get_option( 'pel_success_message', esc_html__( 'Thanks! We\'ll be in touch shortly.', 'power-equipment-leads' ) );
		case 'redirect_url':
			return get_option( 'pel_redirect_url', '' );
		default:
			return '';
	}
}

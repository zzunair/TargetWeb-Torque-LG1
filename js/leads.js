/**
 * Handles AJAX submission for every ".pel-lead-form" on the page.
 *
 * Any lead-form block just needs to render a <form class="pel-lead-form">
 * with a data-form-id attribute and first_name/last_name/email/phone/message inputs;
 * this script takes care of the rest (submit, disable button, show
 * success/error, optional redirect).
 */
( function () {
	'use strict';

	function onSubmit( event ) {
		var form = event.target;
		if ( ! form.classList.contains( 'pel-lead-form' ) ) {
			return;
		}
		event.preventDefault();

		var feedback = form.querySelector( '.pel-lead-form__feedback' );
		var button = form.querySelector( '[type="submit"]' );
		var formData = new FormData( form );

		formData.append( 'action', 'pel_submit_lead' );
		formData.append( 'nonce', window.PELLeads.nonce );
		formData.append( 'form_id', form.getAttribute( 'data-form-id' ) || 'lead-form' );
		formData.append( 'source_url', window.location.href );

		if ( button ) {
			button.disabled = true;
		}
		form.classList.remove( 'is-error' );
		form.classList.add( 'is-submitting' );

		fetch( window.PELLeads.ajaxUrl, {
			method: 'POST',
			credentials: 'same-origin',
			body: formData,
		} )
			.then( function ( response ) {
				return response.json();
			} )
			.then( function ( response ) {
				form.classList.remove( 'is-submitting' );

				if ( response.success ) {
					if ( response.data.redirect ) {
						window.location.href = response.data.redirect;
						return;
					}

					// If the markup includes a dedicated "success panel" next
					// to the form (e.g. the main lead-form section), swap to
					// it instead of just leaving an inline message.
					var successPanel = form.parentElement
						? form.parentElement.querySelector( '.pel-lead-form__success' )
						: null;

					if ( successPanel ) {
						form.hidden = true;
						successPanel.hidden = false;
					} else {
						form.classList.add( 'is-success' );
						if ( feedback ) {
							feedback.textContent = response.data.message || '';
						}
						form.reset();
					}
				} else {
					form.classList.add( 'is-error' );
					if ( feedback ) {
						feedback.textContent =
							( response.data && response.data.message ) ||
							'Something went wrong. Please try again.';
					}
					if ( button ) {
						button.disabled = false;
					}
				}
			} )
			.catch( function () {
				form.classList.remove( 'is-submitting' );
				form.classList.add( 'is-error' );
				if ( feedback ) {
					feedback.textContent = 'Something went wrong. Please try again.';
				}
				if ( button ) {
					button.disabled = false;
				}
			} );
	}

	document.addEventListener( 'submit', onSubmit );
} )();

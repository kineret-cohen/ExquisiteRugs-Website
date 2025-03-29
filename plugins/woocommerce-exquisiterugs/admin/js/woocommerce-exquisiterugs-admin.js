(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	jQuery(document).ready(function($) {
		// Function to toggle the allowed users field visibility
		function toggleAllowedUsersField() {
			var selectedValue = $('input[name="wc_exquisiterugs_cart_access"]:checked').val();
			if (selectedValue === 'selected') {
				$('.allowed-users-field').show();
			} else {
				$('.allowed-users-field').hide();
			}
		}

		// Run on page load
		toggleAllowedUsersField();

		// Run when radio buttons change
		$('input[name="wc_exquisiterugs_cart_access"]').on('change', function() {
			toggleAllowedUsersField();
		});
	});

})( jQuery );

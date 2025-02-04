<?php
/**
 * Show a Different “Terms of Service” at Checkout Based on Membership Level
 * 
 * title: Show a Different TOS at Checkout Based on Membership Level
 * layout: snippet
 * collection: checkout
 * category: tos, levels
 * link:https://www.paidmembershipspro.com/show-different-terms-service-checkout-based-membership-level/
 * 
 * You can add this recipe to your site by creating a custom plugin
 * or using the Code Snippets plugin available for free in the WordPress repository.
 * Read this companion article for step-by-step directions on either method.
 * https://www.paidmembershipspro.com/create-a-plugin-for-pmpro-customizations/
 */


/**
 * Change the Terms of Service page based on the membership level.
 */
function my_option_pmpro_tospage( $tospage ) {
	global $pmpro_level;

	// Check if $pmpro_level is set and is an object
	if ( !empty( $pmpro_level ) && isset( $pmpro_level->id ) ) {
		if ( $pmpro_level->id == 1 ) {
			$tospage = 53; // change this
		} else {
			$tospage = 55;
		}
	}

	return $tospage;
}
add_filter( 'option_pmpro_tospage', 'my_option_pmpro_tospage' );

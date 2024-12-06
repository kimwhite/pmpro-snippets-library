<?php
/**
 * Stop members with a specific membership level from renewing their current membership.
 *
 * title: Stop members from renewing specific levels.
 * layout: snippet
 * collection: checkout
 * category: renewals
 * link: https://www.paidmembershipspro.com/prevent-membership-renewal/
 *
 * You can add this recipe to your site by creating a custom plugin
 * or using the Code Snippets plugin available for free in the WordPress repository.
 * Read this companion article for step-by-step directions on either method.
 */

function stop_members_from_renewing_specific_levels( $okay ) {

	// If something else isn't okay, stop from running this code further.
	if ( ! $okay ) {
		return $okay;
	}

	// If the user doesn't have a membership level carry on with checkout.
	if ( ! pmpro_hasMembershipLevel() ) {
		return $okay;
	}

	// Get level for checkout.
	$checkout_level = pmpro_getLevelAtCheckout();
	$level_id = $checkout_level->id;

	// Specify the level IDs to restrict renewals for.
	$restricted_levels = array(1, 2, 3); // Replace with your level IDs.

	// Check if the user's current membership level is the same as the one being checked out and is in the restricted levels.
	if ( pmpro_hasMembershipLevel( $level_id ) && in_array( $level_id, $restricted_levels ) ) {
		$okay = false;
		pmpro_setMessage( 'This is your current membership level. Please select a different membership level.', 'pmpro_error' );
	}

	return $okay;

}
add_filter( 'pmpro_registration_checks', 'stop_members_from_renewing_specific_levels', 10, 1 );

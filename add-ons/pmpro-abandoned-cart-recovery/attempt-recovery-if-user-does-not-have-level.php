<?php
/**
 * If a user does not have a level, attempt to recover their purchase.
 *
 * title: Attempt to recover an abandoned cart if the user does not have the level they tried to purchase.
 * layout: snippet
 * collection: add-ons
 * category: pmpro-abandoned-cart-recovery
 * link: https://www.paidmembershipspro.com/remove-lesson-list/
 *
 * You can add this recipe to your site by creating a custom plugin
 * or using the Code Snippets plugin available for free in the WordPress repository.
 * Read this companion article for step-by-step directions on either method.
 * https://www.paidmembershipspro.com/create-a-plugin-for-pmpro-customizations/
 */

/**
 * Attempt to recover abandoned cart if user does not have the level they tried to purchase.
 *
 * This is useful on websites where users can have multiple membership levels and where
 * levels are not "tiered".
 *
 * This replaces the default behavior of only attempting to recover abandoned carts if the
 * user does not have ANY membership level.
 *
 * @param bool $should_attempt_recovery Whether or not to attempt recovery.
 * @param MemberOrder $order The order object to check.
 * @return bool
 */
function my_pmproacr_attempt_recovery_if_user_does_not_have_level( $should_attempt_recovery, $order ) {
	// To only allow this to run for specific levels, you can uncomment the following code.
	// For example, if you have a level group of tiered levels and a separate level group of "memberhip add ons",
	//     you can use this check to only run this check for the Add On levels.
	/*
	$mmpu_levels = array( 1, 2, 3 ); // Add On levels
	if ( ! in_array( $order->membership_id, $mmpu_levels ) ) {
		return $should_attempt_recovery;
	}
	*/

	return ! pmpro_hasMembershipLevel( $order->user_id, $order->membership_id );
}
add_filter( 'pmproacr_should_attempt_recovery', 'my_pmproacr_attempt_recovery_if_user_does_not_have_level', 10, 2 );

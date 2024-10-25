<?php
/**
 * If a user started a checkout to upgrade their membership, attempt to recover their purchase.
 *
 * title: Attempt to recover an abandoned cart if the user was purchasing an upgrade.
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
 * Attempt to recover abandoned cart if user was purchasing an upgrade.
 *
 * This is useful on websites where levels are "tiered".
 *
 * This replaces the default behavior of only attempting to recover abandoned carts if the
 * user does not have ANY membership level.
 *
 * @param bool $should_attempt_recovery Whether or not to attempt recovery.
 * @param MemberOrder $order The order object to check.
 * @return bool
 */
function my_pmproacr_attempt_recovery_if_upgrading( $should_attempt_recovery, $order ) {
    // Set the "tier list" of levels that are considered "upgrades".
    $tier_list = array( 1, 2, 3 ); // Level 2 is an upgrade from Level 1, Level 3 is an upgrade from Level 2, etc.

    // If the user is not purchasing a level in the "upgrade list", bail.
    if ( ! in_array( $order->membership_id, $tier_list ) ) {
        return $should_attempt_recovery;
    }

    // Get the array of levels IDs that are $order->membership_id or higher.
    $purchase_level_or_better = array_slice( $tier_list, array_search( $order->membership_id, $tier_list ) );

    // We only want to attempt recovery if the user does not have a level in the $purchase_level_or_better array.
    return ! pmpro_hasMembershipLevel( $order->user_id, $purchase_level_or_better );
}
add_filter( 'pmproacr_should_attempt_recovery', 'my_pmproacr_attempt_recovery_if_upgrading', 10, 2 );

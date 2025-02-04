<?php
/**
 * If a user was approved for any other level, consider them approved for every level.
 *
 * Must be using PMPro Approvals version 1.4.2 or higher.
 *
 * title: Automatically Approve Previously Approved Members
 * layout: snippet
 * collection: add-ons
 * category: pmpro-approvals
 * link: https://www.paidmembershipspro.com/automatically-approve-previously-approved-members/
 *
 * You can add this recipe to your site by creating a custom plugin
 * or using the Code Snippets plugin available for free in the WordPress repository.
 * Read this companion article for step-by-step directions on either method.
 * https://www.paidmembershipspro.com/create-a-plugin-for-pmpro-customizations/
 */

function my_approve_user_if_already_approved( $approved, $user_id, $level_id, $user_approval ) {

	// Already approved?
	if ( $approved ) {
		return $approved;
	}

	// Check if this level requires approval.
	if ( ! PMPro_Approvals::requiresApproval( $level_id ) ) {
		return $approved;
	}

	// Okay, check their approval log.
	$approval_log = get_user_meta( $user_id, 'pmpro_approval_log', true );
	if ( is_array( $approval_log ) && ! empty( $approval_log ) ) {		
		$last_entry = end( $approval_log );
		if ( strpos( $last_entry, 'approved' ) !== false ) {
			// Previously approved.
			$approved = true;
		}
	}

	return $approved;
}
add_action( 'pmproap_user_is_approved', 'my_approve_user_if_already_approved', 10, 4 );

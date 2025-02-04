<?php
/**
 * Show the WordPress User ID as a Member ID on the Paid Memberships Pro Account Page
 * 
 * title: Show the WordPress User ID
 * layout: snippet
 * collection: frontend-pages
 * category: members-account-page
 * link: https://www.paidmembershipspro.com/show-member-id-on-the-membership-account-page-for-paid-memberships-pro/
 *
 * You can add this recipe to your site by creating a custom plugin
 * or using the Code Snippets plugin available for free in the WordPress repository.
 * Read this companion article for step-by-step directions on either method.
 * https://www.paidmembershipspro.com/create-a-plugin-for-pmpro-customizations/
 */
 function pmpro_add_user_id_account() {
	global $current_user;
	echo '<li><strong>Member ID: </strong>' . $current_user->ID . '</li>';
}
add_action( 'pmpro_account_bullets_top', 'pmpro_add_user_id_account' );

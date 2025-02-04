<?php
/**
 * This recipe allows a specific number of active sessions for a single user account when using the Limit Logins Add On.
 *
 * title: Allows a specific number of active sessions for a single user account
 * layout: snippet
 * collection: add-ons
 * category: pmpro-limit-logins
 * link: https://www.paidmembershipspro.com/limit-user-active-sessions/
 *
 * You can add this recipe to your site by creating a custom plugin
 * or using the Code Snippets plugin available for free in the WordPress repository.
 * Read this companion article for step-by-step directions on either method.
 * https://www.paidmembershipspro.com/create-a-plugin-for-pmpro-customizations/
 */

function my_pmpro_limit_logins_number_simultaneous_logins( $num ) {
	return 3;
}
add_filter( 'pmpro_limit_logins_number_simultaneous_logins', 'my_pmpro_limit_logins_number_simultaneous_logins' );

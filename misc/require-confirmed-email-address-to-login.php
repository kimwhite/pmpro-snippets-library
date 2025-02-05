<?php
/** 
 * Require Confirmed Email Address to Log In
 *
 * title: Require Confirmed Email Address to Log In
 * layout: snippet
 * collection: misc
 * category: login 
 * link: https://www.paidmembershipspro.com/restrict-user-login-for-members-only/#h-code-recipe-1-restrict-user-login-to-active-members
 *
 * You can add this recipe to your site by creating a custom plugin
 * or using the Code Snippets plugin available for free in the WordPress repository.
 * Read this companion article for step-by-step directions on either method.
 * https://www.paidmembershipspro.com/create-a-plugin-for-pmpro-customizations/
 */


function my_pmpro_check_login( $user, $password ) {

	$validated = get_user_meta( $user->ID, "pmpro_email_confirmation_key", true );

	if ( $validated != 'validated' && !empty( $validated ) ) {
		return new WP_Error( 'user_not_verified', 'User has not validated their email' ); 
	}

	return $user;
}

add_filter( 'wp_authenticate_user', 'my_pmpro_check_login', 10, 2 );
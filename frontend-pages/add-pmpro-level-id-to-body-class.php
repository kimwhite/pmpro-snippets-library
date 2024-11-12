<?php
/**
 * Add the member's level ID to the <body> tag's "class" attribute.
 *
 * title: AAdd the member's level ID to the <body> tag's "class" attribute.
 * layout: snippet
 * collection: frontend-pages
 * category: css
 * link: https://www.paidmembershipspro.com/add-the-members-level-id-to-the-body-class-for-level-specific-css-styles/
 *
 * You can add this recipe to your site by creating a custom plugin
 * or using the Code Snippets plugin available for free in the WordPress repository.
 * Read this companion article for step-by-step directions on either method.
 * https://www.paidmembershipspro.com/create-a-plugin-for-pmpro-customizations/
 */

function add_pmpro_level_id_to_body_class( $classes ) {
	global $current_user;
	if ( function_exists( 'pmpro_hasMembershipLevel' ) && pmpro_hasMembershipLevel() ) {
		$classes[] = 'pmpro-body-has-level-' . $current_user->membership_level->ID;
	}
	return $classes;
}
add_filter( 'body_class', 'add_pmpro_level_id_to_body_class' );

<?php
/**
 * Sell PMPro Course as AddOn Package
 *
 * title: Add AddOn Package Support for PMPro Courses
 * layout: snippet
 * collection: add-ons
 * category: pmpro-courses, pmpro-addon-packages
 * link: none
 *
 * You can add this recipe to your site by creating a custom plugin
 * or using the Code Snippets plugin available for free in the WordPress repository.
 * Read this companion article for step-by-step directions on either method.
 * https://www.paidmembershipspro.com/create-a-plugin-for-pmpro-customizations/
 */
 
 
/**
 * Adds the AddOn Package post meta to 'Courses' post type.
 * Give access if they purchased "Courses" parent container.
 * Add this code to your PMPro Customizations Plugin - https://www.paidmembershipspro.com/create-a-plugin-for-pmpro-customizations/
 */
 
 function add_pmpro_courses_to_AP( $types ) {
	$types[] = 'courses';

	return $types;
}
add_filter( 'pmproap_supported_post_types', 'add_pmpro_courses_to_AP', 10, 1 );

function pmpro_give_access_to_users_for_course( $hasaccess, $mypost, $myuser, $post_membership_levels) {

	$post_id = $mypost->ID;

	$is_course = get_post_meta( $post_id, '_post_courses', true );

	$ap_posts = get_user_meta( $myuser->ID, '_pmproap_posts', true );

	// Bail if nothing is found and return current access.
	if ( empty( $ap_posts) || empty( $is_course) ) {
		return $hasaccess;
	}

	if ( in_array( $is_course[0], $ap_posts ) ) {
		$hasaccess = true;
	}

	return $hasaccess;
}
add_filter('pmpro_has_membership_access_filter', 'pmpro_give_access_to_users_for_course', 10, 4 );
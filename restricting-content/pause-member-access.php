<?php

/**
 * Mark a member "paused" and deny access to members-only content.
 * Show a message that their account is paused containing a link to your website contact page.
 *
 * title: Mark a member "paused" and deny access to members-only content
 * layout: snippet
 * collection: restricting-content
 * category: content, restriction, member-access
 *
 * link:  https://www.paidmembershipspro.com/block-pause-members-access-restricted-content/
 *
 * You can add this recipe to your site by creating a custom plugin
 * or using the Code Snippets plugin available for free in the WordPress repository.
 * Read this companion article for step-by-step directions on either method.
 * https://www.paidmembershipspro.com/create-a-plugin-for-pmpro-customizations/
 */

function my_pmprouf_init_pause_access_new() {
	if ( ! function_exists( 'pmpro_add_user_field' ) ) {
		return false;
	}

	// Bail if not in administrative area.
	if ( ! is_admin() ) {
		return;
	}
    
//  pmpro_add_field_group( 'pause_hasaccess', 'Access to Member Content' );
    pmpro_add_field_group( 'Access to Member Content' );

	// Define the field.
  
  $fields = array();
  $fields[] = new PMPro_Field(
		'pmpro_paused_user',
		'checkbox',
		array(
			'label'   => 'Pause User',
			'text'    => 'Deny Access to Member Content',
			'profile' => 'admins',
		)
	);

	foreach ( $fields as $field ) {
	 pmpro_add_user_field(
			'Access to Member Content',
			$field
		);
	}
}
add_action( 'init', 'my_pmprouf_init_pause_access_new', 10, 1 );

/**
 * Deny access to member content if user is 'paused'.
 */

function paused_member_pmpro_has_membership_access_filter( $access, $post, $user, $levels ) {

	//if we don't have access now, we still won't
	if ( ! $access ) {
		return $access;
	}

	//no user, this must be open to everyone
	if ( empty( $user ) || empty( $user->ID ) ) {
		return $access;
	}

	//no levels, must be open
	if ( empty( $levels ) ) {
		return $access;
	}

	//now we need to check if the user is approved for ANY of the $levels
	$paused_user = get_user_meta( $user->ID, 'pmpro_paused_user', true );
	if ( ! empty( $paused_user ) ) {
		$access = false;
	}

	return $access;
}
add_filter( 'pmpro_has_membership_access_filter', 'paused_member_pmpro_has_membership_access_filter', 10, 4 );

/**
 * Show a different message for users that have their membership paused.
 */

function paused_member_pmpro_non_member_text_filter( $text ) {

	global $current_user, $has_access;

	//get current user's level ID
	$paused_user = get_user_meta( $current_user->ID, 'pmpro_paused_user', true );

	//if a user does not have a membership level, return default text.
	if ( ! empty( $paused_user ) ) {
		$text = __( '<p>Your membership is paused. Please contact us to reinstate your membership.</p><a href="/contact/">Contact Us</a>', 'paid-memberships-pro' );
	}

	return $text;
}

add_filter( 'pmpro_non_member_text_filter', 'paused_member_pmpro_non_member_text_filter' );

/**
 * Filter the content of the Membership Account page to show message to paused user.
 *
 */

function paused_member_pmpro_membership_account_filter( $content ) {
	global $pmpro_pages, $current_user;

	// Check if current user is paused.
	if ( is_user_logged_in() ) {
		$paused_user = get_user_meta( $current_user->ID, 'pmpro_paused_user', true );
	}

	if ( is_page( $pmpro_pages[ 'account' ] ) && ! empty( $paused_user ) ) {
		$newcontent = __( '<div class="pmpro_content_message"><p>Your membership is paused. Please contact us to reinstate your membership.</p><a href="/contact/">Contact Us</a></div>', 'paid-memberships-pro' );
		$content = $newcontent . $content;
	}
	return $content;
}

add_filter( 'the_content', 'paused_member_pmpro_membership_account_filter', 10 );

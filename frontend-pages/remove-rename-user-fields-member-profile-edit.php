<?php
/**
 * Removes the First Name and Last Name fields on the Member Profile Edit page.
 * Renames the "Display Name" field to just "Name".
 *
 * title: Remove or Rename User Fields on the Member Profile Edit Page
 * layout: snippet
 * collection: frontend-pages
 * category: profile, account
 * link: https://www.paidmembershipspro.com/remove-rename-user-fields-member-profile-edit/
 *
 * You can add this recipe to your site by creating a custom plugin
 * or using the Code Snippets plugin available for free in the WordPress repository.
 * Read this companion article for step-by-step directions on either method.
 * https://www.paidmembershipspro.com/create-a-plugin-for-pmpro-customizations/
 */
function my_pmpro_member_profile_edit_user_object_fields( $user_fields ) {
	unset( $user_fields['first_name'] );
	unset( $user_fields['last_name'] );
	$user_fields['display_name'] = 'Name';
	return $user_fields;
}
add_filter( 'pmpro_member_profile_edit_user_object_fields', 'my_pmpro_member_profile_edit_user_object_fields' );
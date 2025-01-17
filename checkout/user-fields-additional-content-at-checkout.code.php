<?php
/**
 * User Fields + Additional Content at Checkout
 *
 * This recipe requires Paid Memberships Pro 3.0 or higher.
 * Use this recipe as an example: you must change the field label, key, and membership level IDs to fit your needs.
 * 
 * title: Assign additional membership levels based on fields at checkout.
 * layout: snippet
 * collection: checkout
 * category: custom-fields, checkout, user-fields
 * link: https://www.paidmembershipspro.com/assign-additional-membership-levels-based-on-fields-at-checkout/
 * 
 * You can add this recipe to your site by creating a custom plugin
 * or using the Code Snippets plugin available for free in the WordPress repository.
 * Read this companion article for step-by-step directions on either method.
 * https://www.paidmembershipspro.com/create-a-plugin-for-pmpro-customizations/
 */

 function my_pmpro_user_field_add_save_function_example( $field, $where ) {
	// Match our field name
	if ( 'more_coding_content' === $field->name ) {
		// Add save function for our field.
		$field->save_function = 'my_pmpro_mmpu_add_level_field_save_function'; // Set to your callback function name.
	}
 
	return $field;
}
add_filter( 'pmpro_add_user_field', 'my_pmpro_user_field_add_save_function_example', 10, 2 );
/**
 * Give users an extra level based on a profile field selected at checkout or on profile page.
 */
function my_pmpro_mmpu_add_level_field_save_function( $user_id, $field_name, $value ) {	
	
	// Check field and give user level if appropriate.
	if ( $field_name == 'more_coding_content' ) {
		if ( $value == 1 ) {
			pmpro_changeMembershipLevel( 8, $user_id );
			update_user_meta( $user_id, 'more_coding_content', 1 );
		} else {
			pmpro_cancelMembershipLevel( 8, $user_id );
			update_user_meta( $user_id, 'more_coding_content', 0 );
		}
	}
}
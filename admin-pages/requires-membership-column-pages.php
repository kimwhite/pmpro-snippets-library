<?php
/**
 * Show a “Requires Membership” Column on the All Pages Screen
 *
 * title: Show a “Requires Membership” Column on the All Pages Screen
 * layout: snippet
 * collection: admin-pages
 * category: admin, pages
 * link: https://www.paidmembershipspro.com/show-post-page-categorys-required-membership-levels-dashboard-views/
 *
 * You can add this recipe to your site by creating a custom plugin
 * or using the Code Snippets plugin available for free in the WordPress repository.
 * Read this companion article for step-by-step directions on either method.
 * https://www.paidmembershipspro.com/create-a-plugin-for-pmpro-customizations/
 */

//add a new column to the all pages view
function requires_membership_pages_columns_head( $defaults ) {
    $defaults['requires_membership'] = 'Requires Membership';
    return $defaults;
}
add_filter( 'manage_pages_columns', 'requires_membership_pages_columns_head' );

//get the column data
function requires_membership_pages_columns_content( $column_name, $post_ID ) {
	if ( $column_name == 'requires_membership' ) {
	    global $membership_levels, $wpdb;
		$post_levels = $wpdb->get_col(
			"SELECT membership_id 
			 FROM {$wpdb->pmpro_memberships_pages} 
			 WHERE page_id = '{$post_ID}'" );
		$protected_levels = array();
		foreach ( $membership_levels as $level ) {
			if ( in_array( $level->id, $post_levels ) ) {
				$protected_levels[] = $level->name;
			}
		}
		echo implode( ', ', $protected_levels);
	}
}
add_action( 'manage_pages_custom_column', 'requires_membership_pages_columns_content', 10, 2 );

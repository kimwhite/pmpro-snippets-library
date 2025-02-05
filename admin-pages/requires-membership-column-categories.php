<?php
/**
 * Show a “Requires Membership” Column on the All Categories Screen
 *
 * title: Show a “Requires Membership” Column on the All Categories Screen
 * layout: snippet
 * collection: admin-pages
 * category: admin, categories
 * link: https://www.paidmembershipspro.com/show-post-page-categorys-required-membership-levels-dashboard-views/
 *
 * You can add this recipe to your site by creating a custom plugin
 * or using the Code Snippets plugin available for free in the WordPress repository.
 * Read this companion article for step-by-step directions on either method.
 * https://www.paidmembershipspro.com/create-a-plugin-for-pmpro-customizations/
 */

//add a new column to the categories view
function requires_membership_categories_columns_head( $defaults ) {
    $defaults['requires_membership'] = 'Requires Membership';
    return $defaults;
}
add_filter( 'manage_edit-category_columns', 'requires_membership_categories_columns_head' );

//get the column data
function requires_membership_categories_columns_content( $content, $column_name, $term_id ) {
	if ( $column_name == 'requires_membership' ) {
	    global $membership_levels, $wpdb;
		$protected_levels = array();
		foreach ( $membership_levels as $level ) {
				$protectedcategories = $wpdb->get_col(
					"SELECT category_id 
					 FROM $wpdb->pmpro_memberships_categories
					 WHERE membership_id = $level->id" );
				if ( in_array( $term_id, $protectedcategories ) ) {
					$protected_levels[] = $level->name;
				}
		}
		echo implode( ', ', $protected_levels );
	}
}
add_action( 'manage_category_custom_column', 'requires_membership_categories_columns_content', 10, 3 );
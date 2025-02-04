<?php
/**
 * Block dashboard access for custom roles pmpro_role_1 and pmpro_role_2.
 *
 * title: Block Dashboard Access for Additional User Roles
 * layout: snippet
 * collection: add-ons, pmpro-roles
 * category: capabilities
 * link: https://www.paidmembershipspro.com/block-dashboard-access-for-additional-user-roles/
 *
 * You can add this recipe to your site by creating a custom plugin
 * or using the Code Snippets plugin available for free in the WordPress repository.
 * Read this companion article for step-by-step directions on either method.
 * https://www.paidmembershipspro.com/create-a-plugin-for-pmpro-customizations/
 */

function block_dashboard_for_custom_role( $block ) {
	global $current_user;

	//Update this line with your custom roles
	$roles_to_block = array( 'pmpro_role_1', 'pmpro_role_2' );

	if ( ! current_user_can( 'manage_options' )
		&& ! wp_doing_ajax()
		&& ! empty( array_intersect( $roles_to_block, $current_user->roles ) ) ) {
		$block = true;
	}

	return $block;
}
add_filter( 'pmpro_block_dashboard', 'block_dashboard_for_custom_role' );

<?php
/**
 * Set levels as "all access levels" so members of these levels will be able to view all Addon Packages.
 * Requires Paid Memberships Pro and the pmpro-addon-packages plugin.
 *
 * title: Give Membership Level(s) to all Addon Packages
 * layout: snippet
 * collection: addons
 * category: pmpro-addon-packages
 * url: https://www.paidmembershipspro.com/allow-specific-membership-levels-to-view-addon-packages-and-require-others-to-pay/
 *
 * You can add this recipe to your site by creating a custom plugin
 * or using the Code Snippets plugin available for free in the WordPress repository.
 * Read this companion article for step-by-step directions on either method.
 * https://www.paidmembershipspro.com/create-a-plugin-for-pmpro-customizations/
 */

function my_pmproap_all_access_levels($levels, $user_id, $post_id)
{
	//I'm just adding the level, but I could do some calculation based on the user and post id to programatically give access to content
	$levels = array(16);	
	return $levels;
}
add_filter("pmproap_all_access_levels", "my_pmproap_all_access_levels", 10, 3);
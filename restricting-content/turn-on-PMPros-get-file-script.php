<?php
/**
 * Locking Down Non-WordPress Files and Folders with Paid Memberships Pro
 * Step 2: Turn On PMPro’s Get File Script
 *
 * title: Turn On PMPro’s Get File Script
 * layout: snippet
 * collection: restricting-content
 * category: Non-WordPress folders
 * link: https://www.paidmembershipspro.com/locking-non-wordpress-files-folders-paid-memberships-pro/
 *
 * You can add this recipe to your site by creating a custom plugin
 * or using the Code Snippets plugin available for free in the WordPress repository.
 * Read this companion article for step-by-step directions on either method.
 * https://www.paidmembershipspro.com/create-a-plugin-for-pmpro-customizations/
 */

 /*
  This code handles loading a file from the /protected-directory/ directory.
  (!) Be sure to change line 19 below to point to your protected directory if something other than /protected/
  (!) Be sure to change line 66 below to the level ID or array of level IDs to check for the levels you need.
  (!) Add this code to your active theme's functions.php or a custom plugin.
  (!) You should have a corresponding bit of code in your Apache .htaccess file to redirect files to this script. e.g.
  ###
  # BEGIN protected folder lock down
  <IfModule mod_rewrite.c>
  RewriteBase /
  RewriteRule ^protected-directory/(.*)$ /?pmpro_getfile=$1 [L]
  </IfModule>
  # END protected folder lock down
  ###
*/
define('PROTECTED_DIR', 'protected-directory');	//change this to the name of the folder to protect
function my_pmpro_category_filter( $query ) {

	// Set the members-only category IDs NOT to filter. Update this!
	$not_hidden_cat_ids = array( 1, 10 );
	
	// If post__not_in is not set, bail.
	if ( empty( $query->get( 'post__not_in' ) ) ) {
		return;
	}	
	
	// Disable filters to avoid loops.
	remove_filter( 'pre_get_posts', 'pmpro_search_filter' );
	remove_filter( 'pre_get_posts', 'my_pmpro_category_filter' );

	// Static var to cache the posts IDs in these cats.
	static $cat_posts = null;
	
	// Get the IDs of all posts in those cats.
	if ( ! isset( $cat_posts ) ) {
		$cat_posts = get_posts( array( 'category' => $not_hidden_cat_ids, 'numberposts' => -1, 'fields' => 'ids' ) );
	}

	// Remove the post ids from the post__not_in query var.
	$query->set( 'post__not_in', array_diff( $query->get( 'post__not_in' ), $cat_posts ) );

	// Reenable filters.
	add_filter( 'pre_get_posts', 'pmpro_search_filter' );
	add_filter( 'pre_get_posts', 'my_pmpro_category_filter' );

	return $query;
}

$filterqueries = pmpro_getOption( 'filterqueries' );

if( ! empty( $filterqueries ) ){
	add_filter( 'pre_get_posts', 'my_pmpro_category_filter', 15 );
}

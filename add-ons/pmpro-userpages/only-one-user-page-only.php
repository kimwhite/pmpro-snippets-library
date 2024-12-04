<?php
/**
 * This recipe removes the parameters for the page that gets created for each order. 
 * This ensures that only the user's page is created and no other pages for each level are created.
 * 
 * title: Only the user's page is created and no other pages for each level are created
 * layout: snippet
 * collection: add-ons, pmpro-userpages
 * category: user pages
 * url: https://www.paidmembershipspro.com/user-pages-user-page-only/
 *
 * You can add this recipe to your site by creating a custom plugin
 * or using the Code Snippets plugin available for free in the WordPress repository.
 * Read this companion article for step-by-step directions on either method.
 * https://www.paidmembershipspro.com/create-a-plugin-for-pmpro-customizations/
 */



function mypmpro_user_page_purchase_postdata( $postdata, $user, $level ){
	
	$postdata = array();
	
	return $postdata;

}
add_filter( 'pmpro_user_page_purchase_postdata', 'mypmpro_user_page_purchase_postdata', 10, 3 );
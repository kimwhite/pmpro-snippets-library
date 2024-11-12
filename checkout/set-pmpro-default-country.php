<?php
/**
 * Use the pmpro_default_country filter to pre-set the dropdown at checkout to your country of choice.
 *
 * Requires the Force First Last Plugin (https://wordpress.org/plugins/force-first-last/)
 *
 * title: Change the Default Country of Your Membership Site Checkout.
 * layout: snippet
 * collection: misc
 * category: checkout
 * link: https://www.paidmembershipspro.com/change-the-default-country-of-your-membership-website/
 *
 * You can add this recipe to your site by creating a custom plugin
 * or using the Code Snippets plugin available for free in the WordPress repository.
 * Read this companion article for step-by-step directions on either method.
 * https://www.paidmembershipspro.com/create-a-plugin-for-pmpro-customizations/
 */
function my_set_pmpro_default_country( $default_country ) {
	// Set country code to "GB" for United Kingdom.
	$default_country = 'GB';
	return $default_country;
}
add_filter( 'pmpro_default_country', 'my_set_pmpro_default_country' );

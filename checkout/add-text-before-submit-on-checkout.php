<?php

/**
 * Add Text Before the Submit and Checkout Button on the PMPro Checkout Page
 * 
 * title: Add Text Before the Submit and Checkout Button
 * layout: snippet
 * collection: checkout
 * category: fields
 * 
 * url: https://www.paidmembershipspro.com/add-text-before-the-submit-and-checkout-button-on-the-pmpro-checkout-page/
 *
 * You can add this recipe to your site by creating a custom plugin
 * or using the Code Snippets plugin available for free in the WordPress repository.
 * Read this companion article for step-by-step directions on either method.
 * https://www.paidmembershipspro.com/create-a-plugin-for-pmpro-customizations/
 */

function add_text_before_submit() {
	echo 'Hello! This will add some <a href="#" target="_blank">information</a> to your site for you.';
}

add_action( 'pmpro_checkout_before_submit_button', 'add_text_before_submit' );

<?php
/**
 * This recipe will add a percentage-based fee to the initial and recurring value when using Stripe
 * 
 * title: Add A Percentage Based Fee to Checkout When Using Stripe
 * layout: snippet
 * collection: checkout
 * category: stripe
 * link: https://www.paidmembershipspro.com/adjust-membership-pricing-by-payment-gateway/
 * 
 * You can add this recipe to your site by creating a custom plugin
 * or using the Code Snippets plugin available for free in the WordPress repository.
 * Read this companion article for step-by-step directions on either method.
 * https://www.paidmembershipspro.com/create-a-plugin-for-pmpro-customizations/
 */
function my_pmpro_increase_level_cost_by_percentage_for_gateway( $level ) {
	// set your percentage here
	$percentage = 4; // e.g. 4 = 4% increase
	$gateway = pmpro_getGateway();

	//Bail if gateway is not stripe
	if ( $gateway !== 'stripe' ) {
		return $level;
	}
	// Bail if percentage is not valid.
	if ( ! is_numeric( $percentage ) || $percentage <= 0 ) {
		return $level;
	}

	$percentage = $percentage / 100; // convert to decimal

	$increased_initial_payment   = $level->initial_payment + ( $level->initial_payment * $percentage ); // calculate the increased initial payment
	$increased_recurring_payment = $level->billing_amount + ( $level->billing_amount * $percentage ); // calculate the increased recurring payment

	$level->initial_payment = $increased_initial_payment; //Updates initial payment value
	$level->billing_amount  = $increased_recurring_payment; //Updates recurring payment value

	return $level;

}
add_filter( 'pmpro_checkout_level', 'my_pmpro_increase_level_cost_by_percentage_for_gateway' );
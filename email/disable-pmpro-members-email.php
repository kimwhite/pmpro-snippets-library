<?php
/**
*  The function below will disable any email sent to the Member/User by Paid Memberships Pro.
*  The admin emails will still be sent as intended.
*
* title: Disable PMPro Members Emails
* layout: snippet
* collection: email
* category: disable, email
* link: https://www.paidmembershipspro.com/disable-emails-member-user-admin/
*
* You can add this recipe to your site by creating a custom plugin
* or using the Code Snippets plugin available for free in the WordPress repository.
* Read this companion article for step-by-step directions on either method.
* https://www.paidmembershipspro.com/create-a-plugin-for-pmpro-customizations/
*/

function my_pmpro_disable_member_emails( $recipient, $email ) {
	if ( strpos( $email->template, "_admin" ) == false ) {
		//this is not an admin email template
  		$recipient = NULL;
	}	
	return $recipient;
}
add_filter( 'pmpro_email_recipient', 'my_pmpro_disable_member_emails', 10, 2 );
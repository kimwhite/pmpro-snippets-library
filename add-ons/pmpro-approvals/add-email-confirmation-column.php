<?php
/**
 * This recipe adds an "Email Confirmation" column to the Approvals admin screen when using PMPro Approvals.
 *
 * The recipe assumes the Email Confirmation Add On is active.
 *
 * title: Add Email Confirmation status to Approvals admin screen.
 * layout: snippet
 * collection: add-ons
 * category: pmpro-approvals
 *
 * You can add this recipe to your site by creating a custom plugin
 * or using the Code Snippets plugin available for free in the WordPress repository.
 * Read this companion article for step-by-step directions on either method.
 * https://www.paidmembershipspro.com/create-a-plugin-for-pmpro-customizations/
 */

 // Add column header
function my_pmpro_approvals_list_extra_cols_header_email_confirmation( $theusers ) {
	?>
	<th><?php esc_html_e( 'Email Confirmation', 'pmpro-email-confirmation' ); ?></th>
	<?php
}
add_action( 'pmpro_approvals_list_extra_cols_header', 'my_pmpro_approvals_list_extra_cols_header_email_confirmation' );

//Add 'Email Confirmation' status to Approved List Rows
function my_pmpro_approvals_list_extra_cols_body_email_confirmation( $theuser ) {
	?>
	<td>
		<?php
		// Show pending if the email confirmation key is set in user meta, otherwise show confirmed.
		if ( ! empty( $theuser->pmpro_email_confirmation_key ) ) {
			esc_html_e( 'Pending' );
		} else {
			esc_html_e( 'Confirmed' );
		}
		?>
	</td>
	<?php
}
add_action( 'pmpro_approvals_list_extra_cols_body', 'my_pmpro_approvals_list_extra_cols_body_email_confirmation' );

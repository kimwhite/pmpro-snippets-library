<?php
/**
 * Allows for a popup to show user has exceeded their log in limit 
 * and then gives them the option to log out of other instances using jquery and ajax.
 *
 * title: POPUP FOR EXCEEDED LOGIN LIMIT
 * collection: add-ons
 * category: wp-bouncer
 * link: https://www.paidmembershipspro.com/improve-the-user-experience-and-increase-signups-when-using-the-limit-post-views-add-on/
 *
 * You can add this recipe to your site by creating a custom plugin
 * or using the Code Snippets plugin available for free in the WordPress repository.
 * Read this companion article for step-by-step directions on either method.
 * https://www.paidmembershipspro.com/create-a-plugin-for-pmpro-customizations/
 */

// Hook into simultaneous login limit
function my_wp_bouncer_number_simultaneous_logins($num) {
    
    // Bail if PMPro not activated or function not available.
    if ( ! function_exists( 'pmpro_hasMembershipLevel' ) ) {
        return $num;
    }

    // Membership level checks and session limits
    if ( pmpro_hasMembershipLevel( '1' ) ) {
        $num = 1;
    }

    if ( pmpro_hasMembershipLevel( '2' ) ) {
        $num = 2;
    }

    if ( pmpro_hasMembershipLevel( '3' ) ) {
        $num = 6;
    }

    return $num;
}
add_filter('wp_bouncer_number_simultaneous_logins', 'my_wp_bouncer_number_simultaneous_logins');

// Enqueue necessary scripts for handling modal
function enqueue_modal_scripts() {
    wp_enqueue_script('jquery');
    wp_enqueue_script('my_modal_script', get_template_directory_uri() . '/js/modal-script.js', array('jquery'), null, true);
    wp_localize_script('my_modal_script', 'ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'user_id' => get_current_user_id(),
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_modal_scripts');

// Handle AJAX request to log out a previous session
function handle_logout_previous_session() {
    if ( ! is_user_logged_in() || ! isset( $_POST['user_id'] ) ) {
        wp_send_json_error('Invalid request');
    }

    $user_id = intval($_POST['user_id']);

    // Logout from other active sessions 
    wp_destroy_other_sessions();

    wp_send_json_success('Logged out from previous session.');
}
add_action('wp_ajax_logout_previous_session', 'handle_logout_previous_session');

// Function to check for session limit and trigger Convert Plus modal
function check_and_display_modal() {
    if ( ! is_user_logged_in() ) {
        return;
    }

    // Logic to check if the user has exceeded the login limit
    $user_id = get_current_user_id();
    $active_sessions = count_user_sessions($user_id); // Custom function to count sessions, based on your session manager

    $membership_level = pmpro_getMembershipLevelForUser($user_id);

    // Fetch the session limit based on membership level
    $session_limit = my_wp_bouncer_number_simultaneous_logins(0);

    if ( $active_sessions >= $session_limit ) {
        // Trigger the Convert Plus modal when the user exceeds the session limit
        echo '<script type="text/javascript">
                jQuery(document).ready(function($) {
                    // Trigger Convert Plus modal by ID (replace cp_id_5ac6a with your actual modal ID)
                    if (typeof cp_open !== "undefined") {
                        cp_open("cp_id_xxxxx");
                    }
                });
              </script>';
    }
}
add_action('wp_footer', 'check_and_display_modal');

// JavaScript for handling the modal and session logout
?>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        // Handle the button click inside the Convert Plus modal to log out from another session
        $('#logout-other-session').on('click', function() {
            $.post(ajax_object.ajax_url, {
                action: 'logout_previous_session',
                user_id: ajax_object.user_id,
            }, function(response) {
                if (response.success) {
                    // Reload the page to complete the new login
                    location.reload();
                } else {
                    alert('Failed to log out from another session.');
                }
            });
        });
    });
</script>
<?php

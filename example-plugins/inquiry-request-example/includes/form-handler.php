<?php
// Function to handle form submission.
function handle_inquiry_submission() {

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_inquiry'])) { // Check if form is submitted

        global $wpdb; // Global variable for WordPress database interaction

        $table_name = $wpdb->prefix . 'inquiry_request_table'; // Prefix the table name with the WordPress prefix

        // Sanitize and validate form data
        $first_name = sanitize_text_field($_POST['first_name']);
        $last_name = sanitize_text_field($_POST['last_name']);
        $email = sanitize_email($_POST['email']);
        $state = sanitize_text_field($_POST['state']);
        $phone_number = sanitize_text_field($_POST['phone_number']);

        // Check if all fields are filled and email is valid
        if (!empty($first_name) && !empty($last_name) && is_email($email) && !empty($state) && !empty($phone_number)) {
            // Insert data into database
            $wpdb->insert($table_name, [
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'state' => $state,
                'phone_number' => $phone_number
            ]);
            return true; // Return true if submission is successful

            // OR WE COULD REDIRECT THE USER TO A SUCCESS OR THANK YOU page
            // wp_redirect(home_url('/thank-you/')); // Redirect to a success page
            // exit;
        }

        return false; // Return false if validation fails
    }
}


// Function to handle form/inquiry update by admin. This function will be called when the form is updated by admin.
function handle_inquiry_update() {

    // Check if the current user has the 'manage_options' capability
    if (!current_user_can('manage_options')) {
        // If the user does not have the 'manage_options' capability, stop execution and display an error
        wp_die('You are not allowed to edit this item.');
    }

    // Check for POST request
    if ('POST' !== $_SERVER['REQUEST_METHOD']) {
        wp_die('Invalid request method.');
    }

    global $wpdb;
    $table_name = $wpdb->prefix . 'inquiry_request_table';

    // Assuming data is validated and sanitized because it is editable only by admins, we do not need to re-validate/sanitize here.
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $state = $_POST['state'];
    $phone_number = $_POST['phone_number'];
    $inquiry_id = intval($_POST['inquiry_id']);

    // Check that required fields are not empty
    if (!empty($first_name) && !empty($last_name) && !empty($email) && !empty($state) && !empty($phone_number)) {
        $wpdb->update($table_name, [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'state' => $state,
            'phone_number' => $phone_number
        ], ['id' => $inquiry_id]);
    } else {
        // Redirect back to the edit page if any field is empty with an error message
        wp_redirect(add_query_arg([
            'page' => 'sample_inquiries', // Page slug
            'edit' => $inquiry_id,    // Query arg for the inquiry ID
            'error' => 'empty_fields' // Query arg for error message
        ], admin_url('admin.php')));
        exit;
    }

    // Redirect back to the list page with a success message
    wp_redirect(add_query_arg([
        'page' => 'sample_inquiries', // Page slug
        'updated' => 'true'           // Query arg for success message
    ], admin_url('admin.php')));      // Redirect to the admin page
    exit;
}

// Register the admin post action for form submission
add_action('admin_post_handle_inquiry_update', 'handle_inquiry_update');


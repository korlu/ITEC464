<?php
/*
Plugin Name: My Simple Form Plugin
Plugin URI: http://localhost/my-simple-form-plugin
Description: A simple form plugin that saves data to a database with CSS example.
Grid layout.
Version: 1.1
Author: [Your Name]
Author URI: http://localhost
*/

// Create table on plugin activation
function itec_simple_form_install()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'itec_simple_form';

    $sql = "CREATE TABLE $table_name (
        id INT NOT NULL AUTO_INCREMENT,
        name VARCHAR(50) NOT NULL,
        email VARCHAR(150) NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
        PRIMARY KEY (id)
    )";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    dbDelta($sql);
}

// register the activation hook
register_activation_hook(__FILE__, 'itec_simple_form_install');



// Form creation function (`itec_simple_form`): Generates the HTML for the form.
function itec_simple_form()
{
    $content = '';
    // Check for the 'submitted' parameter to display a thank-you message
    if (isset($_GET['submitted']) && $_GET['submitted'] == 'yes') {
        $content = '<div>Thank you for your submission!</div>';
    } else {
        $action_url = esc_url($_SERVER['REQUEST_URI']); // Get the current URL

        // Generate the form HTML
        $content = <<<FORM_CONTENT
        <form action="{$action_url}" method="post" class="grid-form">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <input type="submit" value="Submit">
        </form>
        FORM_CONTENT;
    }
    return $content;
}

// Add/register the shortcode [my-simple-form] to display the form
add_shortcode('my-simple-form', 'itec_simple_form');



// Form submission function (`itec_simple_form_handler`)
// This function handles form submission and saves data to the database.
function itec_simple_form_handler()
{
    // Only proceed if the specific fields for our form are present
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'])) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'itec_simple_form';
        // $table_name = $wpdb->prefix . 'simple_form';

        $name = sanitize_text_field($_POST['name']);
        $email = sanitize_email($_POST['email']);

        // Ensure the table exists
        $table_exists = $wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name;

        if ($table_exists) {
            $wpdb->insert(
                $table_name,
                [
                    'name' => $name,
                    'email' => $email
                ]
            );

            // Redirect to avoid form resubmission issues
            $redirect_url = add_query_arg(
                'submitted',     // Add the'submitted' parameter to the URL
                'yes',           // Set the value of the'submitted' parameter to 'yes'
                wp_get_referer() // Get the URL the user came from
            );

            wp_redirect($redirect_url); // Redirect to the URL the user came from
            exit;
        }
    }
}

// Add the form submission handler to the init hook
add_action('init', 'itec_simple_form_handler');



// Function to enqueue/add CSS styles
function itec_simple_form_styles()
{
    wp_enqueue_style('itec-simple-form-css', plugins_url('formstyle.css', __FILE__));
}

// Add the form CSS to the wp_enqueue_scripts hook
add_action('wp_enqueue_scripts', 'itec_simple_form_styles');

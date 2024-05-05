<?php
/*
Plugin Name: Inquiry Request Example
Description: A plugin for managing inquiries with frontend form and backend data management. For the shortcode to display the form, use [example_inquiry_form].
Version: 1.0
Author: Your Name (Example: Wm. Thompson)
*/

// prevent direct access to the file
defined('ABSPATH') or die('Unauthorized access.');

// Define the path to the plugin directory for easy inclusion of files
define('INQUIRY_REQUEST_DIR', plugin_dir_path(__FILE__));

// Includes for handling various aspects of the plugin
include_once INQUIRY_REQUEST_DIR . 'includes/db-handler.php';  // Manages database operations
include_once INQUIRY_REQUEST_DIR . 'includes/form-handler.php'; // Handles form submissions and validation
include_once INQUIRY_REQUEST_DIR . 'includes/admin-page.php';  // Creates and manages the admin page
include_once INQUIRY_REQUEST_DIR . 'includes/shortcode-handler.php'; // Manages the shortcode for front-end form display


// Activation hook to create the database table when the plugin is activated
register_activation_hook(__FILE__, 'create_inquiry_request_table');

// Enqueue CSS styles for the front-end form
add_action('wp_enqueue_scripts', 'enqueue_inquiry_request_styles');
function enqueue_inquiry_request_styles() {
    wp_enqueue_style('inquiry-request-css', plugins_url('assets/css/style.css', __FILE__));
}

// Enqueue admin styles
add_action('admin_enqueue_scripts', 'inquiry_request_enqueue_admin_styles');
function inquiry_request_enqueue_admin_styles() {
    wp_enqueue_style('inquiry-request-admin-css', plugins_url('assets/css/style.css', __FILE__));
}

// Add an item to the admin menu for managing inquiries. This function is defined in admin-page.php in the includes folder.
add_action('admin_menu', 'inquiry_request_admin_menu');

<?php
/**
 * Sets up the admin page and handles the display and edit functionalities for inquiries.
 * 
 * The function inquiry_request_admin_menu() adds a new page to the WordPress admin menu specifically for managing the sample inquiries. It registers another function inquiry_request_admin_page() to render the page content.
 * 
 * The inquiry_request_admin_page() function checks first if there is an 'edit' request by looking at the URL parameters. If there is an inquiry ID to edit:
 * - It retrieves the inquiry details from the database.
 * - If the inquiry exists, it includes a PHP file that contains the form to edit the
 *   inquiry (edit-inquiry-form.php).
 * - If the inquiry does not exist, it displays an error message.
 * 
 * If not in edit mode, it fetches all inquiries from the database and includes a list view (admin-list-view.php), which lists all the inquiries with options to edit each.
 */

// Function to add a new menu item in the WordPress admin
function inquiry_request_admin_menu()
{
  add_menu_page(
    'Inquiry Request Example', // Page title (in the browser tab)
    'Inquiry Request Example', // Menu title (in the sidebar)
    'manage_options',   // Capability required to access the menu item (admin)
    'sample_inquiries', // Unique slug for the menu item (used in URL)
    'inquiry_request_admin_page' // Function to call when the menu item is clicked (this function displays the page content)
  );
}

// Displays the admin page content
function inquiry_request_admin_page()
{
  global $wpdb;
  $table_name = $wpdb->prefix . 'inquiry_request_table';

  // Check if an edit form is requested
  if (isset($_GET['edit']) && is_numeric($_GET['edit'])) { // Check if edit

    $inquiry_id = intval($_GET['edit']); // Get the inquiry ID from the URL

    // Prepare a query to fetch the inquiry details
    $statement = $wpdb->prepare("SELECT * FROM {$table_name} WHERE id = %d", $inquiry_id);

    // Fetch the inquiry details from the database
    $inquiry = $wpdb->get_row($statement);

    if ($inquiry) {
      // Include the edit form view if the inquiry exists
      include INQUIRY_REQUEST_DIR . 'views/edit-inquiry-form.php';
    } else {
      echo '<div class="notice notice-error"><p>No inquiry found with that ID.</p></div>';
    }
    return;  // Prevents the list from displaying when editing
  }

  // Display a success message if updated
  if (isset($_GET['updated']) && $_GET['updated'] == 'true') {
    echo '<div class="notice notice-success"><p>Inquiry updated successfully.</p></div>';
  }

  // Fetch all inquiries from the database to display in a list
  $inquiries = $wpdb->get_results("SELECT * FROM {$table_name}");

  // NOTE: the $inquiries variable is an array of objects. Each object represents a row from the database table. It is used in the admin-list-view.php file to display the list of inquiries.

  // Include the list view file for the admin page
  include INQUIRY_REQUEST_DIR . 'views/admin-list-view.php';
}

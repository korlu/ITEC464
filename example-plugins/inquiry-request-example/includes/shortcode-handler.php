<?php
// Function to register the shortcode and render the form
function inquiry_request_form_shortcode() {
    ob_start();  // Start output buffering to capture the form HTML

    $success = handle_inquiry_submission(); // Process form submission and capture success/failure

    include INQUIRY_REQUEST_DIR . 'views/inquiry-form.php'; // Include the form view
    
    return ob_get_clean();  // Return the form HTML as the shortcode output
}

// Register the shortcode
add_shortcode('example_inquiry_form', 'inquiry_request_form_shortcode');
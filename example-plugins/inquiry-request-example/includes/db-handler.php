<?php
// function to create a database table for storing inquiries
function create_inquiry_request_table() {

    global $wpdb; // Global variable for WordPress database interaction

    // Prefixing the table name with the WordPress prefix (usually wp_)
    $table_name = $wpdb->prefix . 'inquiry_request_table';

    // SQL statement for table creation
    if ($wpdb->get_var("SHOW TABLES LIKE '{$table_name}'") != $table_name) {
        $sql = "CREATE TABLE $table_name (
            id INT NOT NULL AUTO_INCREMENT,
            first_name VARCHAR(50) NOT NULL,
            last_name VARCHAR(50) NOT NULL,
            email VARCHAR(100) NOT NULL,
            state VARCHAR(100) NOT NULL,
            phone_number VARCHAR(30) NOT NULL,
            PRIMARY KEY (id)
        );";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); // WordPress function for running SQL
        
        dbDelta($sql); // Execute the SQL
    }
}

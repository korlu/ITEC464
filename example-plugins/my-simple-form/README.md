# My Simple Form Plugin

## Description
A simple form plugin that saves data to a database with CSS example.
```
/*
Plugin Name: My Simple Form Plugin
Plugin URI: http://localhost/my-simple-form-plugin
Description: A simple form plugin that saves data to a database with CSS example.
Grid layout.
Version: 1.1
Author: [Your Name]
Author URI: http://localhost
*/
```

## Code Explanation

**Form Handling**: The `itec_simple_form_handler` function checks if the form has been submitted by verifying the request method and the presence of a specific field in the POST data. This helps prevent unintended execution during other POST requests. It then sanitizes the input data to prevent security vulnerabilities and inserts the data into the database. Finally, it redirects the user to avoid duplicate submissions upon refreshing the page.

**Data Validation and Insertion**: After sanitizing the input data to prevent security
vulnerabilities, the function inserts the data into the specified table. It then redirects the user to avoid duplicate submissions upon refreshing the page.

**Redirection**: After successfully processing the form, the function redirects the user to the same page with a query parameter (submitted=yes) that can be used to display a confirmation message or similar feedback.

## The Code/functions

### 1. Database Table Creation function (`itec_simple_form_install`)

- Sets up a custom database table upon plugin activation to store form submissions essential for data management and retrieval.

```
// create table on plugin activation
function itec_simple_form_install() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'itec_simple_form';

    $sql = "CREATE TABLE $table_name (
        id INT NOT NULL AUTO_INCREMENT,
        name tinytext NOT NULL,
        email text NOT NULL,
        time datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        PRIMARY KEY (id)
    )";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    dbDelta($sql);
}

// register the activation hook
register_activation_hook(__FILE__, 'itec_simple_form_install');

```

### 2. Form creation function (`itec_simple_form`)

- This function first checks for the `submitted` parameter to display a thank-you message. Otherwise, it generates the form.

- In this example, to generate the form, we are using a special feature in PHP called Heredocs. Heredocs allow you to create a multi-line string without using quotes or escaping characters.

- Example heredoc syntax: <<<FORM_CONTENT some literal content FORM_CONTENT;

```
// generates the HTML for the form.
function itec_simple_form()
{
    $content = '';
    // Check for the 'submitted' parameter to display a thank-you message
    if (isset($_GET['submitted']) && $_GET['submitted'] == 'yes') {
        $content = '<div>Thank you for your submission!</div>';
    } else {
        // Get the current URL and store it in a variable called $action_url
        // $action_url = esc_url($_SERVER['REQUEST_URI']);
        $action_url = admin_url('admin-post.php');

        // Generate the form HTML using heredocs syntax
        $content = <<<FORM_CONTENT
        <form action="{$action_url}" method="post" class="grid-form">
            <input type="hidden" name="action" value="handle_itec_simple_form">
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
```

### 3. Shortcode Registration (`add_shortcode`)

- This function registers the shortcode [*my-simple-form*] to display the form.
  We can use the shortcode to embed this form within posts or pages, making it flexible and easy to use across the site.

```
// add/register the shortcode [*my-simple-form*] to display the form
add_shortcode('my-simple-form', 'itec_simple_form');
```

### 4. Form Handling function (`itec_simple_form_handler`)

- This function handles the form submission and saves data to the database.

- It handles the server-side processing of the form including sanitizing and inserting data into the database.

```
// form submission function (`itec_simple_form_handler`)
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

// Register the admin_post_handle_itec_simple_form action hook to handle form submissions
add_action('admin_post_handle_itec_simple_form', 'itec_simple_form_handler');
```

### 5. Adding CSS to the plugin: Enqueue Styles Function (`itec_simple_form_styles`)

- Add CSS styles for the form layout, improving the form's visual appearance and usability on the front-end.

- This function adds the CSS styles to the `wp_enqueue_scripts` hook.

```
// function to enqueue/add CSS styles to the form
function itec_simple_form_styles()
{
    wp_enqueue_style('itec-simple-form-css', plugins_url('formstyle.css', __FILE__));
}

// Add the form CSS to the wp_enqueue_scripts hook
add_action('wp_enqueue_scripts', 'itec_simple_form_styles');
```

### CSS for the Form (`form-style.css`)

- The form-style.css contains the styles necessary to utilize CSS Grid for the layout, ensuring the form is responsive and well-structured on various devices.

- Create a CSS file and name it: form-style.css and put the CSS code below in it.

```
/*
This CSS provides the styles necessary to utilize
CSS Grid for the layout, ensuring the form is responsive
and well-structured on various devices.
*/

.grid-form {
    display: grid;
    grid-template-columns: auto 1fr;
    gap: 10px;
    align-items: center;
}

.grid-form label {
    grid-column: 1 / 2;
}

.grid-form input[type="text"],
.grid-form input[type="email"],
.grid-form input[type="submit"] {
    grid-column: 2 / 3;
}
```

<?php
/*
* Explanation of the Code:

* Form Container: The form is contained within a div with the class wrap which is typical for WordPress admin panels to maintain consistent styling.

* Method and Action: The form uses the POST method to send the data securely to admin-post.php, which handles admin-side form submissions in WordPress.

* Hidden Fields:
The action hidden field tells WordPress which action to trigger on form submission. This should correspond to a function hooked to admin_post_sample_inquiry_update.
The inquiry_id hidden field holds the ID of the inquiry being edited, ensuring the correct record is updated in the database.

* Pre-filled Input Fields: Each input is pre-filled with data using esc_attr($inquiry->field_name) to ensure HTML encoding and prevent XSS attacks.
*/

// Ensure the $inquiry object containing the data is available. If not, the form will not be displayed.
if (isset($inquiry)) : ?>
    <div class="wrap">
        <h1>Edit Inquiry</h1>
        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="form-container">
            <input type="hidden" name="action" value="handle_inquiry_update">
            <input type="hidden" name="inquiry_id" value="<?php echo intval($inquiry->id); ?>">

            <label for="first_name">First Name</label>
            <input type="text" name="first_name" id="first_name" value="<?php echo esc_attr($inquiry->first_name); ?>">

            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" id="last_name" value="<?php echo esc_attr($inquiry->last_name); ?>">

            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?php echo esc_attr($inquiry->email); ?>">

            <label for="state">State</label>
            <input type="text" name="state" id="state" value="<?php echo esc_attr($inquiry->state); ?>" readonly>

            <label for="phone_number">Phone Number</label>
            <input type="tel" name="phone_number" id="phone_number" value="<?php echo esc_attr($inquiry->phone_number); ?>">

            <input type="submit" value="Update Inquiry" class="button-primary">
        </form>
    </div>
<?php endif; ?>
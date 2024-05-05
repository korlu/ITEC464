<?php

/** Explanation of the Code:
 * 
 * Table Structure: The inquiries are displayed in a table. Each column header represents a field from the inquiry data such as ID, first name, last name, email, etc.

 * Loop Through Inquiries: The foreach loop iterates over each inquiry fetched from the database and displays its details in a table row.

 * Edit Link: Each row includes an "Edit" link. This link uses add_query_arg to append the inquiry ID to the URL as a query parameter, facilitating the ability to edit the specific entry. The menu_page_url function dynamically generates the URL for the admin page without echoing it (hence the false parameter).
 */
?>

<h2>Inquiries Submission List</h2>
<table class="wp-list-table widefat fixed striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>State</th>
            <th>Phone Number</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($inquiries as $inquiry) : ?>
            <tr>
                <td><?php echo $inquiry->id; ?></td>
                <td><?php echo esc_html($inquiry->first_name); ?></td>
                <td><?php echo esc_html($inquiry->last_name); ?></td>
                <td><?php echo esc_html($inquiry->email); ?></td>
                <td><?php echo esc_html($inquiry->state); ?></td>
                <td><?php echo esc_html($inquiry->phone_number); ?></td>
                <td>

                    <!-- <a href="<?php echo admin_url('admin.php?page=sample_inquiries&edit=' . $inquiry->id); ?>">Edit</a> -->

                    <a href="<?= esc_url(add_query_arg('edit', $inquiry->id, menu_page_url('sample_inquiries', false))); ?>">Edit</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
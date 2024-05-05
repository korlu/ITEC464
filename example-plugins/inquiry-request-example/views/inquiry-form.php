<div class="example-inquiry-form">
    <?php
    if (isset($success) && $success) {
        echo '<h2 class="success">Thank you for your inquiry!</h2>';
    }
    ?>

    <form method="post" action="" class="form-container">
        <label for="first_name">First Name</label>
        <input type="text" name="first_name" placeholder="First Name">

        <label for="last_name">Last Name</label>
        <input type="text" name="last_name" placeholder="Last Name">

        <label for="email">Email</label>
        <input type="email" name="email" placeholder="Email">

        <label for="state">State</label>
        <select name="state">
            <option value="">Select a State</option>
            <option value="California">California</option>
            <option value="Maryland">Maryland</option>
            <option value="New York">New York</option>
            <option value="Texas">Texas</option>
        </select>

        <label for="phone_number">Phone Number</label>
        <input type="tel" name="phone_number" placeholder="Phone Number">

        <input type="submit" name="submit_inquiry" value="Submit Inquiry">
    </form>
</div>
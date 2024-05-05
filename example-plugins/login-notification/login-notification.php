<?php
/*
Plugin Name: Login Notification
Description: Sends an email notification every time a user logs in.
Version: 1.0
Author: Your Name Here
*/

function notify_on_login($user_login, $user)
{
  $to = 'admin-email-address@test.com'; // Replace with your email address.
  $subject = "Login Notification: $user->display_name ($user->user_email)";

  $message_to_admin = "User " . $user_login . " with email " . $user->user_email . " just logged in to your Wordpress site.";

  $message_to_user = "You just logged in to your Wordpress site. If this was not you, please contact us.";
  
  // Only message the site admin if the user who just logged is not an admin
  if (!in_array('administrator', (array) $user->roles)) {
	  wp_mail($to, $subject, $message_to_admin); // Send the email.
  }

  // message to user (if they have an email address)
  if (!empty($user->user_email)) {
	  wp_mail($user->user_email, $subject, $message_to_user); // Send the email.
  }
}

// Add the notify_on_login function to the wp_login hook
add_action('wp_login', 'notify_on_login', 10, 2);

// Explaination of the parameters for the add_action function below:
// 10: priority of the hook. 10 is the default.
// 2: number of parameters the function accepts. In this case, the function accepts two parameters: $user_login and $user.
// 3: the name of the function to call. In this case, the function is notify_on_login.
// 4: the webhook to attach the function to. In this case, the function is attached to the wp_login hook. In Wordpress, this hook (wp_login) is fired every time a user logs in.


/* Further Code Explanation:
* The notify_on_login function sends an email notification every time a user logs in to 
  the Wordpress site.

* The notify_on_login function accepts two parameters: $user_login and $user. 
  These parameters are automatically passed to the function by Wordpress when the function is called.

* The $user_login parameter contains the username of the user who just logged in.

* The $user parameter contains the user object of the user who just logged in. 
  This object contains information about the user, such as their username and email address.

The notify_on_login function sends an email notification to the site admin and the user who just logged in. The email contains information about the user who logged in, such as their username and email address.

* notify_on_login
The notify_on_login function is attached to the wp_login hook. 
This means that the function will be called every time a user logs in.

* add_action 
The add_action is a Wordpress function that attaches a function to a specific hook. In this case, we are attaching the notify_on_login function to the wp_login hook. This means that the notify_on_login function will be called every time a user logs in to the Wordpress site.

*
*/

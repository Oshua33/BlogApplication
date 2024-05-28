<?php
require 'config/database.php';

if (isset($_POST['submit'])) {
// get form data and santized the data
$username_email = filter_var($_POST['username_email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

// validate the form data
if (!$username_email) {
    $_SESSION['signin'] = "Username or Email Required";
} elseif (!$password) {
       $_SESSION['signin'] = "Password is Required";
} else {
    // fetch users from database
    $fetch_user_query = "SELECT * FROM users WHERE username='$username_email' OR email='$username_email'";
    $fetch_user_result = mysqli_query($connection, $fetch_user_query);

    if (mysqli_num_rows($fetch_user_result) == 1) {
        // convert the record into assoc arrays
        $user_record = mysqli_fetch_assoc($fetch_user_result); 
        $db_password = $user_record['password'];
        // compare form password with database password dat the user entered
        if(password_verify($password, $db_password)) {
            // set session for access control
            // give access to dashboard nd hv its own avatar
            $_SESSION['user-id'] = $user_record['id'];
            //set session if user is an admin
            if ($user_record['is_admin'] == 1) {
                $_SESSION['user_is_admin'] = true;
            }
            // log user in 
        header('location: '. ROOT_URL . 'admin/');
        } else {
        $_SESSION['signin'] = "Please check your input";
    }
}
    else {
        $_SESSION['signin'] = "User not found";
        }
    }

    // if any problem, redirect back to signin page with login data
    if (isset($_SESSION['signin'])) {
        $_SESSION['signin-data'] = $_POST;
        header('location: ' . ROOT_URL . 'signin.php');
        die();
    }
} else {
    header('location: '. ROOT_URL . 'signin.php');
    die();
}
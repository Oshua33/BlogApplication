<?php
//session_start();
require 'config/database.php';

// get signup form data if signup button was clicked
    //get all the input and sanitize them
if (isset($_POST['submit'])) {
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email   =    filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $avatar = $_FILES['avatar'];

    //after santize our input we validate to avoid empty space
    // validate input values
     //we use session bcos we want to access it on a diff page
    if(!$firstname) {
        $_SESSION['signup'] = "please enter your First Name";
    } elseif (!$lastname) {
        $_SESSION['signup'] = "please enter your Last Name";
    } elseif (!$username) {
        $_SESSION['signup'] = "please enter your User Name";
    } elseif (!$email) {
        $_SESSION['signup'] = "please enter your valid email";
    } elseif (strlen($createpassword) < 8 || strlen($confirmpassword) < 8) {
        $_SESSION['signup'] = "password should be 8+ characters";
    } elseif (!$avatar['name']) {
        $_SESSION['signup'] = "please add avatar";
    } else {
        // check if passwords don't match
        if($createpassword !== $confirmpassword) {
            $_SESSION['signup'] = "passwords do not match";
        } else {
            // hash password
            $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);

            // check if username or email already  exist in the databased
            $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email'";
            $user_check_result = mysqli_query($connection, $user_check_query);
            if (mysqli_num_rows($user_check_result) > 0) {
                $_SESSION['signup'] = "Username or Email already exist";
            } else {
                // WORK ON AVATAR
                // rename Avatar
                // or use $time = Math.radom();
                // make each image name unique using current timestamp
                // make sure file is an image (checks)
                // make sure image is not too large (1mb+)
                $time = time();
                $avatar_name = $time . $avatar['name'];
                $avatar_tmp_name = $avatar['tmp_name']; 
                $avatar_destination_path = 'images/' . $avatar_name;
                 // where to upload it to
 
               
                $allowed_files = ['png', 'jpg', 'jpeg'];
               // $file_extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
                // note explode is dot 
                $extention = explode ('.', $avatar_name);
                $extention= end($extention);
                if(in_array($extention, $allowed_files)) {
                    
                    if ($avatar['size'] <  1000000) {
                        // uplaod avatar
                        move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
                    } else {
                        $_SESSION['signup'] = 'file size too big. should be less than 1mb';
                    }
                } else {
                    $_SESSION['signup'] = "Files should be png, jpg, or jpeg";
 
            }
        }
    }
}
    //var_dump($avatar);
    // redirect back to signup page if there was any problem
    if (isset($_SESSION['signup'])) {
        // pass form data back to the signup page
        $_SESSION['signup-data'] = $_POST;
        header('location: ' . ROOT_URL . 'signup.php');
        die();
    } else {
     // insert new user into our database
    //$insert_user_query = "INSERT INTO users (firstname, lastname, username, email, password, avatar, is_admin) VALUES('$firstname', '$lastname', '$username', '$email', '$hashed_password', '$avatar_name', 0)";
            //OR
            $insert_user_query = "INSERT INTO users SET firstname='$firstname', lastname='$lastname', username='$username', email='$email', password='$hashed_password', avatar='$avatar_name', is_admin=0";
            $insert_user_result = mysqli_query($connection, $insert_user_query);
        
            //if evertyn went well we redirect to signin page
        if(!mysqli_error($connection)) {
            //redirect to login page with success message
            $_SESSION['signup-success'] = "Registration sucessful. Please log in";
            header('Location: ' . ROOT_URL . 'signin.php');
            die();
        }
    }

} else {
    // if button wasn't clicked , bounce back to signup page
    header('Location: ' . ROOT_URL . 'signup.php');
    die();
}

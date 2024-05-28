<?php
require 'config/database.php';

// get user form if submit button was clicked
if (isset($_POST['submit'])) {
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email   =    filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $is_admin = filter_var($_POST['userrole'], FILTER_SANITIZE_NUMBER_INT);
    $avatar = $_FILES['avatar'];
   

    //after santize our input we validate to avoid empty space
    // validate input values
     //we use session bcos we want to access it on a diff page
     if(!$firstname) {
        $_SESSION['add-user'] = "please enter your First Name";
    } elseif (!$lastname) {
        $_SESSION['add-user'] = "please enter your Last Name";
    } elseif (!$username) {
        $_SESSION['add-user'] = "please enter your User Name";
    } elseif (!$email) {
        $_SESSION['add-user'] = "please enter your valid email";
    } elseif (strlen($createpassword) < 8 || strlen($confirmpassword) < 8) {
        $_SESSION['add-user'] = "password should be 8+ characters";
    } elseif (!$avatar['name']) {
        $_SESSION['add-user'] = "please add avatar";
    } else {
        // check if passwords don't match
        if($createpassword !== $confirmpassword) {
            $_SESSION['add-user'] = "passwords do not match";
        } else {
            // hash password
            $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);

            // check if username or email already  exist in the databased
            $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email'";
            $user_check_result = mysqli_query($connection, $user_check_query);
            if (mysqli_num_rows($user_check_result) > 0) {
                $_SESSION['add-user'] = "Username or Email already exist";
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
                $avatar_destination_path = '../images/' . $avatar_name;
                 // where to upload it to
 
                // make sure file is an image using this files
                $allowed_files = ['png', 'jpg', 'jpeg'];
                $extention = explode ('.', $avatar_name);
                $extention= end($extention);
                if(in_array($extention, $allowed_files)) {
                    
                    if ($avatar['size'] <  1000000) {
                        // uplaod avatar
                        move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
                    } else {
                        $_SESSION['add-user'] = 'file size too big. should be less than 1mb';
                    }
                } else {
                    $_SESSION['add-user'] = "Files should be png, jpg, or jpeg";
 
            }
        }
    }
}
    //check if the add user is set this means there is an error i.e form submitted has an error it redirects to d add-user page but if successful it sends the data to the db
    // redirect back to add-user page if there was any problem
    if (isset($_SESSION['add-user'])) {
        // pass form data back to the add-user page
        $_SESSION['add-user-data'] = $_POST; 
        header('location: ' . ROOT_URL . 'admin/add-user.php');
        die();
    } else {
     // insert new user into our database
    //$insert_user_query = "INSERT INTO users (firstname, lastname, username, email, password, avatar, is_admin) VALUES('$firstname', '$lastname', '$username', '$email', '$hashed_password', '$avatar_name', 0)";
            //OR
            $insert_user_query = "INSERT INTO users SET firstname='$firstname', lastname='$lastname', username='$username', email='$email', password='$hashed_password', avatar='$avatar_name', is_admin=$is_admin";
            $insert_user_result = mysqli_query($connection, $insert_user_query);
        
            //if evertyn went well we redirect to login page with sucess message 
        if(!mysqli_errno($connection)) {
            //redirect to login page with success message
            $_SESSION['add-user-success'] = "New User $firstname $lastname added sucessfully.";
            header('Location: ' . ROOT_URL . 'admin/manage-user.php');
            die();
        }
    }


} else 
{
    header('location: ' . ROOT_URL . 'admin/add-user.php');
    die();
}
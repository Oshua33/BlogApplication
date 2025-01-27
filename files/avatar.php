<?php
require 'config/constants.php';

//get back form data if there was a registration error
$firstname = $_SESSION['signup-data']['firstname'] ?? null;
$lastname = $_SESSION['signup-data']['lastname'] ?? null;
$username = $_SESSION['signup-data']['username'] ?? null;
$email = $_SESSION['signup-data']['email'] ?? null;
$createpassword = $_SESSION['signup-data']['createpassword'] ?? null;
$confirmpassword = $_SESSION['signup-data']['confirmpassword'] ?? null;
// delete signup data session
unset($_SESSION['signup-data']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP & MYSQLI Blog Application with Admin Panel</title>
    <!-- CUSTOM STYLESHEET -->
    <link rel="stylesheet" href="<?=ROOT_URL ?>css/style.css">

    <!-- ICON SCOUT LINK -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
</head>
<body>
    

<section class="form_section">
    <div class="container form_section-container">
        <h2>Sign Up</h2>
       <?php if (isset($_SESSION['signup'])): ?>
        <div class="alert_message error">
            <p>
                <!--error message-->
                <?= $_SESSION['signup'];
                unset($_SESSION['signup']);
                ?>
            </p>
        </div>
        <?php endif ?>
        <!-- action sud go to logic page and enctype sud be dere cos we gonna uplaod a file -->
        <form action="<?= ROOT_URL?>signup-logic.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="firstname" value="<?= $firstname ?>" placeholder="First Name">
            <input type="text" name="lastname" value="<?= $lastname ?>" placeholder="Last Name">
            <input type="text" name="username" value="<?= $username ?>" placeholder="Username">
            <input type="email" name="email" value="<?= $email ?>" placeholder="Email">
            <input type="password"  value="<?= $createpassword ?>" name="createpassword" placeholder="Create password">
            <input type="password" name="confirmpassword" value="<?= $confirmpassword ?>"  placeholder="Confirm password">
            <div class="form_control">
                <label for="avatar">User Avatar</label>
                <input type="file" name="avatar" id="avatar">
            </div>
            <button type="submit" name="submit" class="btn">Sign Up</button>
            <small>Already have an account? <a href="signin.php">Sign In</a></small>
        </form>
    </div>
</section>

</body>
</html>
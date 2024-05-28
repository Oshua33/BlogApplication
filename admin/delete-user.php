<?php
// fetch all user data including the avatar
require 'config/database.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    //fetch user from database
    $query = "SELECT * FROM users WHERE id=$id";
    $result = mysqli_query($connection, $query);
    $user = mysqli_fetch_assoc($result);

    // make sure we got only one user
   if (mysqli_num_rows($result) == 1) {
        $avatar_name = $user['avatar'];
        $avatar_path = '../images/' . $avatar_name;
        // delete image if available
        if ($avatar_path) {
            unlink($avatar_path);
        }
}

// FOR LATER
// Fetch all thumbnails of user's posts and delete them
$thumbnails_query = "SELECT thumbnail FROM post WHERE author_id=$id";
$thumbnails_result = mysqli_query($connection, $thumbnails_query);
if (mysqli_num_rows($thumbnails_result) > 0) { // if there is thumbail(images) present in d db we delete it
    while ($thumbnail = mysqli_fetch_assoc($thumbnails_result)) {
        $thumbnail_path = '../images/' . $thumbnail['thumbnail'];
        // delete thumbnail from images folder is exixt
        if ( $thumbnail_path) {
            unlink( $thumbnail_path);
        }
    }

}




// delete user from the user table
$delete_user_query = "DELETE FROM users WHERE id=$id";
$delete_user_result = mysqli_query($connection, $delete_user_query);
// error messages
if(mysqli_errno($connection)) {
    $_SESSION['delete-user'] = "couldn't delete {$user['firstname']} {$user['lastname']}";
} else {
    $_SESSION['delete-user-success'] = "{$user['firstname']} {$user['lastname']} deleted successfully";
}
}

header('location: ' . ROOT_URL . 'admin/manage-user.php');
die();
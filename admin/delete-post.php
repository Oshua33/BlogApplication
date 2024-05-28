<?php 
require 'config/database.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // fetch post from data base in order to delete the thumbnailnfrom images folder
    $query = "SELECT * FROM post WHERE id=$id";
    $result = mysqli_query($connection, $query);

    //makesure only 1 record or post was fetched
    // first get the thumbnail, den path of images
    if (mysqli_num_rows($result) == 1) {
        $post = mysqli_fetch_assoc($result);
        $thumbnail_name = $post['thumbnail'];
        $thumbnail_path = '../images/' . $thumbnail_name;

        if($thumbnail_path) {
            unlink($thumbnail_path);
            
            // delete post from database
            $delete_post_query = "DELETE FROM post WHERE id=$id LIMIT 1";
            $delete_post_result = mysqli_query($connection, $delete_post_query);

            if (!mysqli_errno($connection)) {
                $_SESSION['delete-post-success'] = "Post Deleted successfully";
            }
        }
    }
}

header('location: ' . ROOT_URL . 'admin/');
die();
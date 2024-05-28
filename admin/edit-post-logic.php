<?php
require 'config/database.php';

// get user form if submit button was clicked
// new varible ($previous_thumbnail_name) is set to update the thumbnail on d databased
if (isset($_POST['submit'])) {
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $previous_thumbnail_name = filter_var($_POST['previous_thumbnail_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body  =    filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'],  FILTER_SANITIZE_NUMBER_INT);
    $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];

    //set is_featured to 0 if it was unlocked
    $is_featured = $is_featured == 1 ?: 0;
    
    //after santize our input we validate to avoid empty space
    // validate input values
     //we use session bcos we want to access it on a diff page
     if (!$title) {
        $_SESSION['edit-post'] = "Couldn't update post. Invalid form data on edit post page.";
    } elseif (!$category_id) {
        $_SESSION['edit-post'] = "Couldn't update post. Invalid form data on edit post page.";
    } elseif (!$body) {
        $_SESSION['edit-post'] = "Couldn't update post. Invalid form data on edit post page.";
    } else {
        // delete existing thumbnail if new thumbnail is avaliable
        if ($thumbnail['name']) {
            $previous_thumbnail_path = '../images/' . $previous_thumbnail_name;
            if ($previous_thumbnail_path) {
                unlink($previous_thumbnail_path);
            }
            // WORK ON THUMBNAIL
        // rename the image
        $time = time(); // make each image unique
        $thumbnail_name = $time . $thumbnail['name'];
        $thumbnail_tmp_name = $thumbnail['tmp_name'];
        $thumbnail_destination_path = '../images/' . $thumbnail_name; // the destination of the images

        //make sure file is an image
        $allowed_files = ['png', 'jpg', 'jpeg'];
        $extension = explode('.', $thumbnail_name);
        $extension = end($extension);
        if(in_array($extension, $allowed_files)) {
            //make sure image is not big. (2mb)
            if($thumbnail['size'] < 2000000) {
                // upload files or thumbnail
                move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
            } else {
                $_SESSION['edit-post'] = "Couldn't update post. Thumbnail size too big. should be less than 2mb";
            }
        } else {
            $_SESSION['edit-post'] ="Couldn't update post. thumbail should be png, jpg or jpeg";
        }

        }
    }

   
    // redirect back to manage form data  if there is any problem
    if ($_SESSION['edit-post']) {
       
        header('location: ' . ROOT_URL . 'admin/');
        die();
    } else {
        // SET is_featured of all post to 0 if is_featured for this post is 1
        if ($is_featured == 1) {
            $zero_all_is_featured_query = "UPDATE post SET is_featured=0";
            $zero_all_is_featured_result = mysqli_query($connection, $zero_all_is_featured_query);
        }

        // set thumbnail name if a new one was uplaoded, else keep old thumbnail name
        $thumbnail_to_insert = $thumbnail_name ?? $previous_thumbnail_name;


        //insert post into database
        $query = "UPDATE post SET title='$title', boby='$body', thumbnail='$thumbnail_to_insert', category_id=$category_id, is_featured=$is_featured WHERE id=$id LIMIT 1";
        $result = mysqli_query($connection, $query);
    }

        //everything good
        if(!mysqli_errno($connection)) {
            $_SESSION['edit-post-success'] = "New post Updated successfully";
               
         }

}


 
header('location: ' . ROOT_URL . 'admin/');
die();


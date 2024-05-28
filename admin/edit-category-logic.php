<?php
require 'config/database.php';

if (isset($_POST['submit'])) {
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // validate data
    if (!$title || !$description) {
        // give error note
        $_SESSION['edit-category'] = "Invalid form input on edit category page";
    } else {
        //update data base
        $query = "UPDATE categories SET title='$title', description='$description' WHERE id=$id LIMIT 1";
        $result = mysqli_query($connection, $query);

        // if there is  a problem display error message
        if(mysqli_errno($connection)) {
            $_SESSION['edit-category'] = "Failed to update category.";
        } else {
            $_SESSION['edit-category-success'] = " $title Category updated successfuly";
        }
    }
} 

    header('location: ' . ROOT_URL . 'admin/manage-category.php');
    die();

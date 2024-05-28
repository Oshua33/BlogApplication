<?php
require 'config/database.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    //FOR LATER
    //update category_id of posts to belong to this uncategorized category
    $update_query = "UPDATE post SET category_id=10 WHERE category_id=$id";
    $update_result = mysqli_query($connection, $update_query);

    // check connection error
    if (!mysqli_errno($connection)) {
       // delete category
     $query = "DELETE FROM categories WHERE id=$id LIMIT 1";
     $result = mysqli_query($connection, $query);
    $_SESSION['delete-category-sucess'] = "Category deleted sucessfully";
    }
}

header('location: ' . ROOT_URL . 'admin/manage-category.php');
die();
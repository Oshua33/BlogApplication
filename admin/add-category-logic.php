<?php
require 'config/database.php';

//make sure submit is set
if(isset($_POST['submit'])) {
    //get form data
    // sanitize to avoid rubbish insert data (malicious input)
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    //validate form to avoid error
    if(!$title) {
        $_SESSION['add-category'] = "Enter title";
    } elseif (!$description) {
        $_SESSION['add-category'] = "Enter description";
    }

    // redirect back to add category page with form data if there was invalid input(error)
    // error and success display
    if(isset($_SESSION['add-category'])) {
        $_SESSION['add-category-data'] = $_POST; 
        header('location: ' . ROOT_URL . 'admin/add-category.php');
        die();
    } else {
        // insert category-data into database
        $query = "INSERT INTO categories (title, description) VALUES ('$title', '$description')";
        $result = mysqli_query($connection, $query);
        //error message
        if(mysqli_error($connection)) {
            $_SESSION['add-category'] = "couldn't add category";
            header('location: ' . ROOT_URL . 'admin/add-category.php');
            die();
        } else {
            
            $_SESSION['add-category-success'] = " $title Category added successfully";
            header('location: ' . ROOT_URL . 'admin/manage-category.php');
            die();
        }
    }
}
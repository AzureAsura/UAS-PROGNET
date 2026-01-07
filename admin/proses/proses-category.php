<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();


require_once '../config/class-category.php';  

$category = new Category();


if (isset($_POST['add_category_btn'])) {
    $result = $category->create($_POST, $_FILES);

    if ($result['status']) {
        $_SESSION['success'] = $result['message'];
        header("Location: ../category.php");      
        exit();
    } else {
        $_SESSION['error'] = $result['message'];
        header("Location: ../add-category.php");  
        exit();
    }
}

else if (isset($_POST['update_category_btn'])) {
    $id = $_POST['category_id'] ?? 0;
    $result = $category->update($id, $_POST, $_FILES);

    if ($result['status']) {
        $_SESSION['success'] = $result['message'];
        header("Location: ../category.php");
        exit();
    } else {
        $_SESSION['error'] = $result['message'];
        header("Location: ../edit-category.php?id=$id");
        exit();
    }
}


else if (isset($_POST['delete_category_btn'])) {
    $id = (int)($_POST['category_id'] ?? 0);
    $result = $category->delete($id);

    $_SESSION['success'] = $result['message'];   
    header("Location: ../category.php");
    exit();
}


else {
    $_SESSION['error'] = "Akses tidak valid!";
    header("Location: ../add-category.php");
    exit();
}
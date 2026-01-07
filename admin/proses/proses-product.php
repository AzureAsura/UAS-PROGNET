<?php
session_start();
require_once '../config/class-product.php';

$product = new Product();

if (isset($_POST['add_product_btn'])) {
    $result = $product->create($_POST, $_FILES);

    if ($result['status']) {
        $_SESSION['success'] = $result['message'];
        header("Location: ../products.php");
        exit();
        
    } else {
        $_SESSION['error'] = $result['message'];
        header("Location: ../add-product.php");
        exit();
    }
}

else if (isset($_POST['update_product_btn'])) {
    $id = (int)($_POST['product_id'] ?? 0);
    $result = $product->update($id, $_POST, $_FILES);

    if ($result['status']) {
        $_SESSION['success'] = $result['message'];
        header("Location: ../products.php");
        exit();
    } else {
        $_SESSION['error'] = $result['message'];
        header("Location: ../edit-products.php?id=$id");
        exit();
    }
}

else if (isset($_POST['delete_product_btn'])) {
    $id = (int)($_POST['product_id'] ?? 0);
    $result = $product->delete($id);

    $_SESSION['success'] = $result['message']; 
    header("Location: ../products.php");
    exit();
}

else {
    $_SESSION['error'] = "Akses tidak valid";
    header("Location: ../add-product.php");
    exit();
}
<?php
// admin/code.php

session_start();
require_once '../config/db-config.php';
require_once 'app/Controllers/category_controller.php';
require_once 'app/Controllers/product_controller.php';
require_once 'app/Controllers/order_controller.php';

// Initialize Database
$db = Database::getInstance();  
$con = $db->getConnection();

// Initialize Controllers
$categoryController = new CategoryController($con);
$productController = new ProductController($con);
$orderController = new OrderController($con);

// =====================
// CATEGORY OPERATIONS
// =====================
if (isset($_POST['add_category_btn'])) {
    $categoryController->store($_POST, $_FILES);
    
} elseif (isset($_POST['update_category_btn'])) {
    $categoryController->update($_POST, $_FILES);
    
} elseif (isset($_POST['delete_category_btn'])) {
    $categoryController->delete($_POST['category_id']);
}

// =====================
// PRODUCT OPERATIONS
// =====================
elseif (isset($_POST['add_product_btn'])) {
    $productController->store($_POST, $_FILES);
    
} elseif (isset($_POST['update_product_btn'])) {
    $productController->update($_POST, $_FILES);
    
} elseif (isset($_POST['delete_products_btn'])) {
    $productController->delete($_POST['id_produk']);
}

// =====================
// ORDER OPERATIONS
// =====================
elseif (isset($_POST['update_status_btn'])) {
    $orderController->updateStatus(
        $_POST['no_tracking'], 
        $_POST['order_status'],
        $_SESSION['auth_user']
    );
}

else {
    header('Location: index.php');
    exit();
}
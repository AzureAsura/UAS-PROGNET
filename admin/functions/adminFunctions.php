<?php
include('../config/db-config.php');

function redirectAdmin($path, $message){
    $_SESSION['message'] = $message;
    header('Location: '.$path);
    exit();
}

function getOrders() {
    global $con;
    $query = "SELECT * FROM tb_orders 
              WHERE status = 0
              ORDER BY created_at DESC";
    return mysqli_query($con, $query);
}


function getStatistik() {
    global $con;
    $query = "SELECT SUM(total_harga) AS tharga 
              FROM tb_orders 
              WHERE status = 3";
    return mysqli_query($con, $query);
}

function checkTrackingNoValidAdmin($trackingNo) {
    global $con;

    $trackingNo = mysqli_real_escape_string($con, $trackingNo);

    $query = "
        SELECT 
            o.*,
            a.alamat AS alamat_lengkap,
            a.kota,
            a.provinsi
        FROM tb_orders o
        LEFT JOIN tb_alamat a ON o.alamat = a.id_alamat
        WHERE o.no_tracking = '$trackingNo'
        LIMIT 1
    ";

    return mysqli_query($con, $query);
}


function getOrderOnGoing() {
    global $con;
    $query = "SELECT * FROM tb_orders 
              WHERE status = 1 OR status = 2
              ORDER BY created_at DESC";
    return mysqli_query($con, $query);
}

function getOrderHistory() {
    global $con;
    $query = "SELECT * FROM tb_orders 
              WHERE status = 3 OR status = 4
              ORDER BY created_at DESC";
    return mysqli_query($con, $query);
}

function getOrderSuccess() {
    global $con;
    $query = "SELECT * FROM tb_orders 
              WHERE status = 3 
              ORDER BY created_at DESC";
    return mysqli_query($con, $query);
}


function getAll($table) {
    global $con;
    return mysqli_query($con, "SELECT * FROM $table");
}

function getById($table, $id, $column) {
    global $con;
    $id = mysqli_real_escape_string($con, $id);
    return mysqli_query($con, "SELECT * FROM $table WHERE $column = '$id'");
}


function getTotalProduk() {
    global $con;
    $query = "SELECT COUNT(*) AS total FROM tb_produk";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total'] ?? 0;
}


function getTotalKategori() {
    global $con;
    $query = "SELECT COUNT(*) AS total FROM tb_kategori";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total'] ?? 0;
}


function getTotalUser() {
    global $con;
    $query = "SELECT COUNT(*) AS total FROM tb_user";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total'] ?? 0;
}


function getPendingOrders() {
    global $con;
    $query = "SELECT COUNT(*) AS total FROM tb_orders WHERE status = 0";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total'] ?? 0;
}


function getTopProducts($limit = 5) {
    global $con;
    $query = "
        SELECT 
            p.nama_produk,
            SUM(oi.qty) AS total_qty
        FROM tb_order_items oi
        JOIN tb_produk p ON oi.id_produk = p.id_produk
        JOIN tb_orders o ON oi.id_order = o.id_order
        WHERE o.status IN (1,2,3)
        GROUP BY p.id_produk
        ORDER BY total_qty DESC
        LIMIT $limit
    ";
    return mysqli_query($con, $query);
}

function getUploadedPayments($limit = 10) {
    global $con;
    $query = "
        SELECT 
            p.id_payment,
            p.id_order,
            p.no_tracking,
            p.bukti_pembayaran,
            p.rekening,
            p.status AS payment_status,
            p.created_at AS upload_date,
            o.nama_user,
            o.total_harga,
            o.status AS order_status
        FROM tb_payment p
        INNER JOIN tb_orders o ON p.id_order = o.id_order
        WHERE p.bukti_pembayaran IS NOT NULL 
          AND p.bukti_pembayaran != ''
        ORDER BY p.created_at DESC
        LIMIT $limit
    ";
    return mysqli_query($con, $query);
}

function getTodayLogsCount() {
    global $con;
    
    $today = date('Y-m-d');
    
    $query = "SELECT COUNT(*) AS total_logs FROM tb_orders_log WHERE DATE(created_at) = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "s", $today);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $row = mysqli_fetch_assoc($result);
    return (int)($row['total_logs'] ?? 0);
}


function getAllLogs($limit = 50, $offset = 0) {
    global $con;
    $query = "
        SELECT 
            ol.*,
            DATE(ol.created_at) AS log_date,
            TIME(ol.created_at) AS log_time
        FROM tb_orders_log ol
        ORDER BY ol.created_at DESC
        LIMIT $limit OFFSET $offset
    ";
    return mysqli_query($con, $query);
}


function getLast24HoursLogs() {
    global $con;
    $query = "
        SELECT 
            ol.*,
            DATE(ol.created_at) AS log_date,
            TIME(ol.created_at) AS log_time
        FROM tb_orders_log ol
        WHERE ol.created_at >= NOW() - INTERVAL 1 DAY
        ORDER BY ol.created_at DESC
    ";
    return mysqli_query($con, $query);
}


function getTotalLogsCount() {
    global $con;
    $query = "SELECT COUNT(*) AS total FROM tb_orders_log";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    return (int)($row['total'] ?? 0);
}
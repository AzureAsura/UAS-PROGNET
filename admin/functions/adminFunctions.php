<?php
include('../config/db-config.php');

/* =====================
   ORDERS
===================== */

function getOrders() {
    global $con;
    $query = "SELECT * FROM tb_orders 
              WHERE status = 1
              ORDER BY created_at DESC";
    return mysqli_query($con, $query);
}

/* =====================
   STATISTIK
===================== */

function getStatistik() {
    global $con;
    $query = "SELECT SUM(total_harga) AS tharga 
              FROM tb_orders 
              WHERE status = 1";
    return mysqli_query($con, $query);
}

/* =====================
   ORDER DETAIL
===================== */

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

/* =====================
   DASHBOARD DATA
===================== */

function getOrderOnGoing() {
    global $con;
    $query = "SELECT * FROM tb_orders 
              WHERE status = 0 OR status = 1
              ORDER BY created_at DESC";
    return mysqli_query($con, $query);
}

function getOrderHistory() {
    global $con;
    $query = "SELECT * FROM tb_orders 
              WHERE status = 2 OR status = 3
              ORDER BY created_at DESC";
    return mysqli_query($con, $query);
}

/* =====================
   GENERAL
===================== */

function getAll($table) {
    global $con;
    return mysqli_query($con, "SELECT * FROM $table");
}

function getById($table, $id, $column) {
    global $con;
    $id = mysqli_real_escape_string($con, $id);
    return mysqli_query($con, "SELECT * FROM $table WHERE $column = '$id'");
}

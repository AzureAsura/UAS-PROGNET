<?php
session_start();
include('../functions/adminFunctions.php');  
require_once '../config/class-order.php';

$orderObj = new Order();

if (isset($_POST['update_status_btn'])) {
    $tracking_no = trim($_POST['no_tracking'] ?? '');
    $new_status  = (int)($_POST['order_status'] ?? -1);

    if (empty($tracking_no) || $new_status < 0) {
        redirectAdmin("../order-details.php?t=" . $tracking_no, "Data tidak valid");
    }

    $admin_id   = $_SESSION['auth_user']['id_user'] ?? 0;
    $admin_name = $_SESSION['auth_user']['nama_user'] ?? 'Admin';

    $result = $orderObj->updateStatus($tracking_no, $new_status, $admin_id, $admin_name);



    if ($result['status']) {
        redirectAdmin("../order-details.php?t=" . $tracking_no, "Status updated succesfully");
    } else {
        redirectAdmin("../order-details.php?t=" . $tracking_no, "Gagal update status");
    }
}
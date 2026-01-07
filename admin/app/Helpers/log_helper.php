<?php
// admin/app/Helpers/log_helper.php

class LogHelper {
    private $con;
    private $table = 'tb_orders_log';

    public function __construct($db) {
        $this->con = $db;
    }

    public function logStatusChange($orderId, $oldStatus, $newStatus, $adminId, $adminName) {
        $orderId = (int)$orderId;
        $oldStatus = (int)$oldStatus;
        $adminId = (int)$adminId;
        $description = mysqli_real_escape_string($this->con,
            "$adminName mengubah status orderan dari $oldStatus menjadi $newStatus"
        );

        $query = "INSERT INTO {$this->table} 
                  (order_id, log_sts, log_admin, keterangan) 
                  VALUES ($orderId, $oldStatus, $adminId, '$description')";

        return mysqli_query($this->con, $query);
    }

    public function getLogsByOrderId($orderId) {
        $orderId = (int)$orderId;
        
        $query = "SELECT l.*, u.nama_user 
                  FROM {$this->table} l
                  LEFT JOIN tb_users u ON l.log_admin = u.id_user
                  WHERE l.order_id = $orderId
                  ORDER BY l.created_at DESC";

        return mysqli_query($this->con, $query);
    }
}
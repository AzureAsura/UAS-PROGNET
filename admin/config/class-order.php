<?php

require_once __DIR__ . '/../../config/db-config.php';  


class Order extends Database
{
    private $table_orders = 'tb_orders';
    private $table_log = 'tb_orders_log';

    public function __construct()
    {
        parent::__construct();
    }

   public function updateStatus(string $tracking_no, int $new_status, int $admin_id, string $admin_name): array
{
    $response = ['status' => false, 'message' => ''];

    $this->conn->begin_transaction();  

    try {

        $tracking_no = $this->conn->real_escape_string($tracking_no);

        $query = "SELECT id_order, status FROM {$this->table_orders} WHERE no_tracking = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $tracking_no);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            throw new Exception('Order tidak ditemukan');
        }

        $order = $result->fetch_assoc();
        $old_status = $order['status'];
        $order_id   = $order['id_order'];
        $stmt->close();

        $update_query = "UPDATE {$this->table_orders} SET status = ? WHERE no_tracking = ?";
        $stmt = $this->conn->prepare($update_query);
        $stmt->bind_param("is", $new_status, $tracking_no);
        if (!$stmt->execute()) {
            throw new Exception('Gagal update status: ' . $stmt->error);
        }
        $stmt->close();

        $keterangan = $admin_name . " mengubah status orderan dari " . $old_status . " menjadi " . $new_status;
        $log_query = "INSERT INTO {$this->table_log} 
                      (order_id, log_sts, log_admin, keterangan) 
                      VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($log_query);
        $stmt->bind_param("iiis", $order_id, $old_status, $admin_id, $keterangan);
        if (!$stmt->execute()) {
            throw new Exception('Gagal insert log: ' . $stmt->error);
        }
        $stmt->close();

        $this->conn->commit();  

        $response['status']  = true;
        $response['message'] = 'Status berhasil diperbarui dan dicatat ke log';

    } catch (Exception $e) {
        $this->conn->rollback();  
        $response['message'] = $e->getMessage();
    }

    return $response;
}
}
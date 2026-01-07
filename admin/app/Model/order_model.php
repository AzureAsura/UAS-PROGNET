<?php
// admin/app/Models/order_model.php - COMPLETE VERSION

class OrderModel
{
    private $con;
    private $table = 'tb_orders';

    public function __construct($db)
    {
        $this->con = $db;
    }

    /**
     * Get pending orders (status = 0)
     */
    public function getOrders()
    {
        return mysqli_query($this->con,
            "SELECT * FROM {$this->table} WHERE status = 0 ORDER BY created_at DESC"
        );
    }

    /**
     * Get revenue statistics
     */
    public function getStatistik()
    {
        return mysqli_query($this->con,
            "SELECT SUM(total_harga) AS tharga FROM {$this->table} WHERE status = 1"
        );
    }

    /**
     * Get ongoing orders (status = 1, 2)
     */
    public function getOrderOnGoing()
    {
        return mysqli_query($this->con,
            "SELECT * FROM {$this->table} WHERE status IN (1, 2) ORDER BY created_at DESC"
        );
    }

    /**
     * Get order history (status = 3, 4)
     */
    public function getOrderHistory()
    {
        return mysqli_query($this->con,
            "SELECT * FROM {$this->table} WHERE status IN (3, 4) ORDER BY created_at DESC"
        );
    }

    /**
     * Check tracking number with address details
     */
    public function checkTracking($trackingNo)
    {
        $trackingNo = mysqli_real_escape_string($this->con, $trackingNo);

        return mysqli_query($this->con, "
            SELECT o.*, a.alamat AS alamat_lengkap, a.kota, a.provinsi
            FROM {$this->table} o
            LEFT JOIN tb_alamat a ON o.alamat = a.id_alamat
            WHERE o.no_tracking='$trackingNo'
            LIMIT 1
        ");
    }

    /**
     * Update order status
     */
    public function updateStatus($trackingNo, $newStatus)
    {
        $trackingNo = mysqli_real_escape_string($this->con, $trackingNo);
        $newStatus = (int)$newStatus;

        $query = "UPDATE {$this->table} 
                  SET status=$newStatus 
                  WHERE no_tracking='$trackingNo'";

        return mysqli_query($this->con, $query);
    }

    /**
     * Get order by tracking number (without join)
     */
    public function getOrderByTracking($trackingNo)
    {
        $trackingNo = mysqli_real_escape_string($this->con, $trackingNo);

        return mysqli_query($this->con,
            "SELECT * FROM {$this->table} WHERE no_tracking='$trackingNo' LIMIT 1"
        );
    }

    /**
     * Get order items with product details
     */
    public function getOrderItems($trackingNo)
    {
        $trackingNo = mysqli_real_escape_string($this->con, $trackingNo);

        $query = "SELECT o.id_order, o.no_tracking, oi.*, oi.qty as orderqty, p.*
                  FROM {$this->table} o
                  INNER JOIN tb_order_items oi ON oi.id_order = o.id_order
                  INNER JOIN tb_produk p ON p.id_produk = oi.id_produk
                  WHERE o.no_tracking='$trackingNo'";

        return mysqli_query($this->con, $query);
    }

    /**
     * Get order by ID
     */
    public function getById($id)
    {
        $id = (int)$id;
        return mysqli_query($this->con,
            "SELECT * FROM {$this->table} WHERE id_order=$id LIMIT 1"
        );
    }

    /**
     * Get all orders with optional filters
     */
    public function getAllOrders($status = null, $limit = null)
    {
        $query = "SELECT * FROM {$this->table}";
        
        if ($status !== null) {
            $status = (int)$status;
            $query .= " WHERE status = $status";
        }
        
        $query .= " ORDER BY created_at DESC";
        
        if ($limit !== null) {
            $limit = (int)$limit;
            $query .= " LIMIT $limit";
        }

        return mysqli_query($this->con, $query);
    }

    /**
     * Count orders by status
     */
    public function countByStatus($status)
    {
        $status = (int)$status;
        $result = mysqli_query($this->con,
            "SELECT COUNT(*) as total FROM {$this->table} WHERE status=$status"
        );
        $row = mysqli_fetch_assoc($result);
        return $row['total'] ?? 0;
    }

    /**
     * Get total revenue
     */
    public function getTotalRevenue()
    {
        $result = mysqli_query($this->con,
            "SELECT SUM(total_harga) AS total FROM {$this->table} WHERE status = 1"
        );
        $row = mysqli_fetch_assoc($result);
        return $row['total'] ?? 0;
    }
}
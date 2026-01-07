<?php
// admin/app/Controllers/order_controller.php

require_once __DIR__ . '/../Helpers/redirect_helper.php';
require_once __DIR__ . '/../Helpers/log_helper.php';
require_once __DIR__ . '/../Model/order_model.php';

class OrderController {
    private $model;
    private $logHelper;

    public function __construct($db) {
        $this->model = new OrderModel($db);
        $this->logHelper = new LogHelper($db);
    }

    public function updateStatus($trackingNo, $newStatus, $adminSession) {
        try {
            $result = $this->model->getOrderByTracking($trackingNo);
            
            if (mysqli_num_rows($result) === 0) {
                throw new Exception("Order not found");
            }
            
            $orderData = mysqli_fetch_array($result);
            $oldStatus = $orderData['status'];
            
            if ($this->model->updateStatus($trackingNo, $newStatus)) {
                $this->logHelper->logStatusChange(
                    $orderData['id_order'],
                    $oldStatus,
                    $newStatus,
                    $adminSession['id_user'],
                    $adminSession['nama_user']
                );
                
                RedirectHelper::redirect("order-details.php?t=$trackingNo", 
                    "Status updated successfully");
            } else {
                throw new Exception("Failed to update status");
            }
        } catch (Exception $e) {
            RedirectHelper::redirect("order-details.php?t=$trackingNo", 
                "Error: " . $e->getMessage());
        }
    }

    public function getOrders() {
        return $this->model->getOrders();
    }

    public function getStatistik() {
        return $this->model->getStatistik();
    }

    public function getOrderOnGoing() {
        return $this->model->getOrderOnGoing();
    }

    public function getOrderHistory() {
        return $this->model->getOrderHistory();
    }

    public function checkTracking($trackingNo) {
        return $this->model->checkTracking($trackingNo);
    }

    public function getOrderItems($trackingNo) {
        return $this->model->getOrderItems($trackingNo);
    }
}
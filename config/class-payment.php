<?php

include_once 'db-config.php';

class Payment extends Database {

    public function createPayment($data, $file){

        if ($file['error'] !== 0) {
            return false;
        }

        $path = "../uploads/payments/";

        // pastikan folder ada
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        // generate filename aman
        $image_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed_ext = ['jpg','jpeg','png','webp'];

        if (!in_array($image_ext, $allowed_ext)) {
            return false;
        }

        $filename = time() . '_' . uniqid() . '.' . $image_ext;

        $query = "INSERT INTO tb_payment 
                    (id_order, no_tracking, bukti_pembayaran, rekening) 
                  VALUES (?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);
        if (!$stmt) return false;

        $stmt->bind_param(
            "isss",
            $data['id_order'],
            $data['no_tracking'],
            $filename,
            $data['rekening']
        );

        if ($stmt->execute()) {
            move_uploaded_file($file['tmp_name'], $path . $filename);
            return true;
        }

        return false;
    }

    public function updatePayment($paymentId, $data, $file){

        $path = "../uploads/payments/";
        $old_image = $data['old_image'];
        $update_filename = $old_image;

        if ($file['name'] != "") {

            $image_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $allowed_ext = ['jpg','jpeg','png','webp'];

            if (!in_array($image_ext, $allowed_ext)) {
                return false;
            }

            $update_filename = time() . '_' . uniqid() . '.' . $image_ext;
        }

        $query = "UPDATE tb_payment 
                  SET rekening = ?, bukti_pembayaran = ?
                  WHERE id_payment = ?";

        $stmt = $this->conn->prepare($query);
        if (!$stmt) return false;

        $stmt->bind_param(
            "ssi",
            $data['rekening'],
            $update_filename,
            $paymentId
        );

        if ($stmt->execute()) {

            if ($file['name'] != "") {
                move_uploaded_file($file['tmp_name'], $path . $update_filename);

                if ($old_image && file_exists($path . $old_image)) {
                    unlink($path . $old_image);
                }
            }

            return true;
        }

        return false;
    }

    public function getPaymentByOrder($orderId){

        $query = "SELECT * FROM tb_payment WHERE id_order = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) return false;

        $stmt->bind_param("i", $orderId);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function getPaymentById($id_payment)
{
    $query = "SELECT * FROM tb_payment WHERE id_payment = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("i", $id_payment);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

}

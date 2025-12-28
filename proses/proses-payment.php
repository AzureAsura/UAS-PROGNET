<?php
session_start();

require_once '../config/class-payment.php';

if (!isset($_SESSION['auth'])) {
    header("Location: ../login.php");
    exit();
}

$payment = new Payment();
$userId  = $_SESSION['auth_user']['id_user'];


if (isset($_POST['add_payment'])) {

    $data = [
        'id_order'    => $_POST['id_order'],
        'no_tracking' => $_POST['no_tracking'],
        'rekening'    => $_POST['rekening']
    ];

    $file = $_FILES['bukti_pembayaran'];

    if ($payment->createPayment($data, $file)) {
        $_SESSION['message'] = "Bukti pembayaran berhasil dikirim";
    } else {
        $_SESSION['message'] = "Gagal mengirim bukti pembayaran";
    }

    header("Location: ../order-details.php?t=".$_POST['no_tracking']);
    exit();
}


if (isset($_POST['update_payment'])) {

    $paymentId = $_POST['id_payment'];

    $data = [
        'rekening'  => $_POST['rekening'],
        'old_image' => $_POST['old_image']
    ];

    $file = $_FILES['bukti_pembayaran'];

    if ($payment->updatePayment($paymentId, $data, $file)) {
        $_SESSION['message'] = "Bukti pembayaran berhasil diperbarui";
    } else {
        $_SESSION['message'] = "Gagal memperbarui bukti pembayaran";
    }

    header("Location: ../order-details.php?t=".$_POST['no_tracking']);
    exit();
}

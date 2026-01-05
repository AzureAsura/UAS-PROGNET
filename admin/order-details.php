<?php
include('../middleware/adminMiddleware.php');
include('functions/adminFunctions.php');
include('template/header.php');

if (isset($_GET['t'])) {

    $tracking_no = $_GET['t'];

    $orderData = checkTrackingNoValidAdmin($tracking_no);


    if (mysqli_num_rows($orderData) < 0) {
        ?>
            <h4>Something went wrong</h4>
        <?php
        die();
    }

} else {
    ?>
        <h4>Something went wrong</h4>
    <?php
    die();
}

$data = mysqli_fetch_array($orderData);

// Ambil data payment
require_once "../config/class-payment.php";
$paymentObj = new Payment();
$payment = $paymentObj->getPaymentByOrder($data['id_order']);

?>

    <?php include('template/sidebar.php')?>

    <!-- CONTENT -->
    <main class="flex-1 p-8 md:pt-8 pt-24">
      <h1 class="text-4xl font-bold text-[#3C3F58] mb-2">Welcome, Human</h1>
      <p class="text-[#707793]">
        Selamat datang di dashboard Admin!
      </p>

    <h2 class="text-3xl font-bold text-gray-800 mb-10 pt-8">Order Details</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

        <!-- LEFT COLUMN → CUSTOMER INFO -->
        <div class="md:col-span-1">
            <div class="bg-white shadow-md rounded-xl p-6 border space-y-3">
                <h3 class="text-xl font-semibold mb-3">Customer Info</h3>

                <p><span class="font-medium text-gray-600">Nama:</span> <?= $data['nama_user'] ?></p>
                <p><span class="font-medium text-gray-600">Email:</span> <?= $data['email'] ?></p>
                <p><span class="font-medium text-gray-600">No Telp:</span> <?= $data['no_telp'] ?></p>
                <p><span class="font-medium text-gray-600">Tracking No:</span> <?= $data['no_tracking'] ?></p>
                        <p><span class="font-medium text-gray-700">
                            <?= htmlspecialchars($data['alamat_lengkap']) ?><br>
                            <?= htmlspecialchars($data['kota']) ?>, <?= htmlspecialchars($data['provinsi']) ?><br>
                            Kode Pos: <?= htmlspecialchars($data['pincode']) ?>
                        </span></p>
            </div>
        </div>

        <!-- RIGHT COLUMN → ITEMS + TOTAL + PAYMENT -->
        <div class="md:col-span-2 space-y-8">

            <!-- ITEMS -->
            <div class="bg-white shadow-md rounded-xl p-6 border">
                <h3 class="text-xl font-semibold mb-4">Items</h3>

                <div class="space-y-4">
                    <?php

                    $order_query = "
                        SELECT 
                            o.id_order AS oid,
                            o.no_tracking,
                            oi.*,
                            oi.qty as orderqty,
                            p.*
                        FROM tb_orders o
                        INNER JOIN tb_order_items oi ON oi.id_order = o.id_order
                        INNER JOIN tb_produk p ON p.id_produk = oi.id_produk
                        AND o.no_tracking = '$tracking_no'
                    ";

                    $order_query_run = mysqli_query($con, $order_query);
                    if (mysqli_num_rows($order_query_run)) {
                        foreach ($order_query_run as $item) {
                    ?>
                        <div class="flex items-center gap-4 bg-gray-50 p-4 rounded-lg border">
                            <img src="../uploads/<?= $item['gambar'] ?>" 
                                class="w-20 h-20 rounded-lg object-cover border" 
                                alt="<?= $item['nama_produk'] ?>">

                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-800"><?= $item['nama_produk'] ?></h4>
                                <p class="text-gray-600 text-sm">Harga: Rp <?= number_format($item['harga'], 0, ',', '.') ?></p>
                                <p class="text-gray-600 text-sm">Qty: <?= $item['orderqty'] ?></p>
                            </div>
                        </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>

            <!-- TOTAL PRICE -->
            <div class="bg-white shadow-md rounded-xl p-6 border">
                <h3 class="text-xl font-semibold mb-1">Total Price</h3>
                <p class="text-2xl font-bold text-green-600">
                    Rp <?= number_format($data['total_harga'], 0, ',', '.') ?>
                </p>
            </div>

            <!-- BUKTI PEMBAYARAN -->
            <div class="bg-white shadow-md rounded-xl p-6 border">
                <h3 class="text-xl font-semibold mb-4">Bukti Pembayaran</h3>
                
                <?php if ($payment): ?>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-600 font-medium mb-1">Rekening Pengirim</p>
                            <p class="text-base text-gray-900 font-semibold"><?= htmlspecialchars($payment['rekening']) ?></p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-600 font-medium mb-1">Tanggal Upload</p>
                            <p class="text-base text-gray-700">
                                <?= date('d F Y, H:i', strtotime($payment['created_at'] ?? $data['updated_at'] ?? 'now')) ?>
                            </p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-600 font-medium mb-2">Bukti Transfer</p>
                            <?php 
                            $imagePath = "../uploads/payments/" . htmlspecialchars($payment['bukti_pembayaran']);
                            if (!empty($payment['bukti_pembayaran']) && file_exists($imagePath)): 
                            ?>
                                <a href="<?= $imagePath ?>" target="_blank" class="block">
                                    <img src="<?= $imagePath ?>" 
                                         alt="Bukti Pembayaran" 
                                         class="w-full max-w-sm rounded-lg border-2 border-gray-200 hover:border-blue-400 transition-all cursor-pointer"
                                         loading="lazy">
                                </a>
                                <p class="text-xs text-gray-500 mt-2">Klik gambar untuk melihat ukuran penuh</p>
                            <?php else: ?>
                                <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-center">
                                    <p class="text-red-600 text-sm font-medium">File tidak ditemukan</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="bg-amber-50 border border-amber-200 rounded-lg p-4">
                        <p class="text-amber-700 text-sm font-medium">
                            <i class="ri-alert-line"></i> Pelanggan belum mengupload bukti pembayaran
                        </p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- PAYMENT INFO & STATUS -->
            <div class="bg-white shadow-md rounded-xl p-6 border space-y-2">
                <p class="font-medium text-gray-700">Payment Mode: 
                    <span class="font-semibold text-gray-900"><?= $data['payment_mode'] ?></span>
                </p>

                <form action="code.php" method="POST">
                    <p class="font-medium text-gray-700">Status:
                    <span class="font-semibold">
                            <input type="hidden" name="no_tracking" value="<?= $data['no_tracking'] ?>">
                            <select name="order_status" class="border border-gray-300 rounded-lg px-3 py-2 mt-2 w-full">
                                <option value="0" <?= $data['status'] == 0?"selected":"" ?>>Menunggu Pembayaran</option>
                                <option value="1" <?= $data['status'] == 1?"selected":"" ?>>Pembayaran Terverifikasi</option>
                                <option value="2" <?= $data['status'] == 2?"selected":"" ?>>Produk Dikirim</option>
                                <option value="3" <?= $data['status'] == 3?"selected":"" ?>>Terkirim</option>
                                <option value="4" <?= $data['status'] == 4?"selected":"" ?>>Dibatalkan</option>
                            </select>

                        </span>
                    </p>
                    <button type="submit" name="update_status_btn" class="p-3 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-xl mt-3 w-full transition-colors">
                        Update Status
                    </button>
                </form>
            </div>

        </div>

    </div>
    </main>

  <?php include('template/footer.php')?>
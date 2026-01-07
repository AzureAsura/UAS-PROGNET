<?php
include('../middleware/staffMiddleware.php');  // ← Ini cukup untuk role 1 & 2
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
<main class="flex-1 p-4 md:p-8 md:pt-8 pt-20 bg-slate-100 min-h-screen">
    
    <div class="max-w-7xl mx-auto">
        
        <!-- Header Section -->
        <div class="mb-6">
            <div class="flex items-center gap-2 mb-2">
                <h1 class="text-2xl md:text-3xl font-bold text-slate-800">Detail Pesanan</h1>
            </div>
            <p class="text-slate-600 text-sm">Informasi lengkap pesanan #<?= $data['id_order'] ?></p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 md:gap-6">

            <!-- LEFT COLUMN → CUSTOMER INFO + BUKTI PEMBAYARAN -->
            <div class="lg:col-span-1 space-y-4 md:space-y-6">
                
                <!-- Customer Info Card -->
                <div class="bg-white shadow-sm rounded-lg p-4 md:p-6 border border-slate-200">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Informasi Pelanggan
                    </h3>

                    <div class="space-y-3">
                        <div>
                            <p class="text-xs font-medium text-slate-500 mb-1">Nama</p>
                            <p class="text-sm text-slate-900 font-semibold"><?= $data['nama_user'] ?></p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-slate-500 mb-1">Email</p>
                            <p class="text-sm text-slate-900 break-all"><?= $data['email'] ?></p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-slate-500 mb-1">No. Telepon</p>
                            <p class="text-sm text-slate-900 font-mono"><?= $data['no_telp'] ?></p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-slate-500 mb-1">No. Tracking</p>
                            <p class="text-sm text-slate-900 font-mono bg-slate-100 px-3 py-2 rounded-lg break-all">
                                <?= $data['no_tracking'] ?>
                            </p>
                        </div>
                        <div class="pt-3 border-t border-slate-200">
                            <p class="text-xs font-medium text-slate-500 mb-2">Alamat Pengiriman</p>
                            <p class="text-sm text-slate-900 leading-relaxed">
                                <?= htmlspecialchars($data['alamat_lengkap']) ?><br>
                                <?= htmlspecialchars($data['kota']) ?>, <?= htmlspecialchars($data['provinsi']) ?><br>
                                <span class="font-medium">Kode Pos:</span> <?= htmlspecialchars($data['pincode']) ?>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- BUKTI PEMBAYARAN -->
                <div class="bg-white shadow-sm rounded-lg p-4 md:p-6 border border-slate-200">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Bukti Pembayaran
                    </h3>
                    
                    <?php if ($payment): ?>
                        <div class="space-y-4">
                            <div class="bg-slate-50 p-3 rounded-lg">
                                <p class="text-xs font-medium text-slate-500 mb-1">Rekening Pengirim</p>
                                <p class="text-sm md:text-base text-slate-900 font-semibold">
                                    <?= htmlspecialchars($payment['rekening']) ?>
                                </p>
                            </div>
                            
                            <div class="bg-slate-50 p-3 rounded-lg">
                                <p class="text-xs font-medium text-slate-500 mb-1">Tanggal Upload</p>
                                <p class="text-sm md:text-base text-slate-700">
                                    <?= date('d F Y, H:i', strtotime($payment['created_at'] ?? $data['updated_at'] ?? 'now')) ?>
                                </p>
                            </div>
                            
                            <div>
                                <p class="text-xs font-medium text-slate-500 mb-2">Bukti Transfer</p>
                                <?php 
                                $imagePath = "../uploads/payments/" . htmlspecialchars($payment['bukti_pembayaran']);
                                if (!empty($payment['bukti_pembayaran']) && file_exists($imagePath)): 
                                ?>
                                    <a href="<?= $imagePath ?>" target="_blank" class="block">
                                        <img src="<?= $imagePath ?>" 
                                             alt="Bukti Pembayaran" 
                                             class="w-full rounded-lg border-2 border-slate-200 hover:border-slate-400 transition-all cursor-pointer"
                                             loading="lazy">
                                    </a>
                                    <p class="text-xs text-slate-500 mt-2">Klik gambar untuk melihat ukuran penuh</p>
                                <?php else: ?>
                                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-center">
                                        <p class="text-red-600 text-sm font-medium">File tidak ditemukan</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 flex items-start gap-3">
                            <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <p class="text-amber-700 text-sm font-medium">
                                Pelanggan belum mengupload bukti pembayaran
                            </p>
                        </div>
                    <?php endif; ?>
                </div>

            </div>

            <!-- RIGHT COLUMN → ITEMS + TOTAL + STATUS -->
            <div class="lg:col-span-2 space-y-4 md:space-y-6">

                <!-- ITEMS -->
                <div class="bg-white shadow-sm rounded-lg p-4 md:p-6 border border-slate-200">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        Produk yang Dipesan
                    </h3>

                    <div class="space-y-3">
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
                            <div class="flex items-center gap-3 md:gap-4 bg-slate-50 p-3 md:p-4 rounded-lg border border-slate-200">
                                <img src="../uploads/<?= $item['gambar'] ?>" 
                                    class="w-16 h-16 md:w-20 md:h-20 rounded-lg object-cover border border-slate-200 flex-shrink-0" 
                                    alt="<?= $item['nama_produk'] ?>">

                                <div class="flex-1 min-w-0">
                                    <h4 class="font-semibold text-slate-900 text-sm md:text-base truncate">
                                        <?= $item['nama_produk'] ?>
                                    </h4>
                                    <div class="flex flex-col md:flex-row md:items-center md:gap-4 mt-1">
                                        <p class="text-slate-600 text-xs md:text-sm">
                                            Harga: <span class="font-semibold">Rp <?= number_format($item['harga'], 0, ',', '.') ?></span>
                                        </p>
                                        <p class="text-slate-600 text-xs md:text-sm">
                                            Qty: <span class="font-semibold"><?= $item['orderqty'] ?></span>
                                        </p>
                                    </div>
                                    <p class="text-slate-800 text-sm md:text-base font-bold mt-1">
                                        Subtotal: Rp <?= number_format($item['harga'] * $item['orderqty'], 0, ',', '.') ?>
                                    </p>
                                </div>
                            </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>

                <!-- TOTAL PRICE -->
                <div class="bg-white shadow-sm rounded-lg p-4 md:p-6 border border-slate-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-slate-800">Total Pembayaran</h3>
                        <p class="text-xl md:text-3xl font-bold text-green-600">
                            Rp <?= number_format($data['total_harga'], 0, ',', '.') ?>
                        </p>
                    </div>
                </div>

                <!-- PAYMENT INFO & STATUS -->
                <div class="bg-white shadow-sm rounded-lg p-4 md:p-6 border border-slate-200">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Status Pesanan
                    </h3>

                    <div class="space-y-4">
                        <div class="bg-slate-50 p-3 rounded-lg">
                            <p class="text-xs font-medium text-slate-500 mb-1">Metode Pembayaran</p>
                            <p class="text-sm md:text-base font-semibold text-slate-900">
                                <?= $data['payment_mode'] ?>
                            </p>
                        </div>

                        <form action="proses/proses-order.php" method="POST" class="space-y-4">
                            <div>
                                <label class="block text-xs font-medium text-slate-500 mb-2">Update Status Pesanan</label>
                                <input type="hidden" name="no_tracking" value="<?= htmlspecialchars($data['no_tracking']) ?>">
                                <select name="order_status" class="w-full border border-slate-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-slate-400 focus:border-transparent outline-none transition">
                                    <option value="0" <?= $data['status'] == 0 ? "selected" : "" ?>>Menunggu Pembayaran</option>
                                    <option value="1" <?= $data['status'] == 1 ? "selected" : "" ?>>Pembayaran Terverifikasi</option>
                                    <option value="2" <?= $data['status'] == 2 ? "selected" : "" ?>>Produk Dikirim</option>
                                    <option value="3" <?= $data['status'] == 3 ? "selected" : "" ?>>Terkirim</option>
                                    <option value="4" <?= $data['status'] == 4 ? "selected" : "" ?>>Dibatalkan</option>
                                </select>
                            </div>

                            <button type="submit" name="update_status_btn" 
                                    class="w-full py-3 bg-slate-800 hover:bg-slate-700 text-white font-semibold text-sm rounded-lg transition-colors shadow-sm hover:shadow-md">
                                Perbarui Status Pesanan
                            </button>
                        </form>
                    </div>
                </div>

            </div>

        </div>
    </div>

</main>

<?php include('template/footer.php')?>
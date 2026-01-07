<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('../middleware/staffMiddleware.php');  
include('functions/adminFunctions.php');
include('template/header.php');
include('template/sidebar.php');  

$statistik = getStatistik();
$revenue = 0;
if ($statistik && mysqli_num_rows($statistik) > 0) {
    $row = mysqli_fetch_assoc($statistik);
    $revenue = $row['tharga'] ?? 0;
}

$orderAktif = getOrderOnGoing();

$orderHistory = getOrderHistory();

$orderSuccess = getOrderSuccess(); 


$totalProduk = getTotalProduk();

$totalKategori = getTotalKategori();

$totalUser = getTotalUser();

$pendingOrders = getPendingOrders();

$topProducts = getTopProducts(5);

$uploadedPayments = getUploadedPayments();

$todayLogsCount = getTodayLogsCount();

function labelStatus($status) {
    switch ($status) {
        case 0: return '<span class="text-yellow-600 font-medium">Pesanan dibuat</span>';
        case 1: return '<span class="text-green-600 font-medium">Pembayaran terverifikasi</span>';
        case 2: return '<span class="text-blue-600 font-medium">Produk dikirim</span>';
        case 3: return '<span class="text-indigo-600 font-medium">Produk telah sampai tujuan</span>';
        case 4: return '<span class="text-red-600 font-medium">Dibatalkan</span>';
        default: return '<span class="text-gray-600 font-medium">Unknown</span>';
    }
}
?>

<main class="flex-1 p-8 md:pt-8 pt-24 bg-gray-50 min-h-screen">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard Admin</h1>
        <p class="text-gray-500 mt-1">Ringkasan aktivitas dan transaksi toko hari ini</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-10">
        <div class="bg-slate-500 p-6 rounded-xl text-white shadow-lg">
            <p class="text-sm font-semibold uppercase">Total Revenue</p>
            <h3 class="text-3xl font-bold mt-2">Rp <?= number_format($revenue, 0, ',', '.') ?></h3>
        </div>

        <div class="bg-slate-500 p-6 rounded-xl text-white shadow-lg">
            <p class="text-sm font-semibold uppercase">Order Aktif</p>
            <h3 class="text-3xl font-bold mt-2"><?= mysqli_num_rows($orderAktif) ?></h3>
        </div>

        <div class="bg-slate-500 p-6 rounded-xl text-white shadow-lg">
            <p class="text-sm font-semibold uppercase">Order Selesai</p>
            <h3 class="text-3xl font-bold mt-2"><?= mysqli_num_rows($orderHistory) ?></h3>
        </div>

        <div class="bg-slate-500 p-6 rounded-xl text-white shadow-lg">
            <p class="text-sm font-semibold uppercase">Total Produk</p>
            <h3 class="text-3xl font-bold mt-2"><?= $totalProduk ?></h3>
        </div>

        <div class="bg-slate-500 p-6 rounded-xl text-white shadow-lg">
            <p class="text-sm font-semibold uppercase">Pending Orders</p>
            <h3 class="text-3xl font-bold mt-2"><?= $pendingOrders ?></h3>
        </div>
    </div>

    <!-- NOTIF PENDING ORDERS -->
    <?php if ($pendingOrders > 0): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg mb-8">
            <strong>Peringatan!</strong> Ada <?= $pendingOrders ?> pesanan dibuat. Segera verifikasi!
        </div>
    <?php endif; ?>


    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-6 py-4 rounded-lg mb-8">
        <strong>Informasi!</strong> Ada <?= $todayLogsCount ?> order log yang dibuat hari ini.
    </div>


    <!-- RECENT ORDERS -->
    <div class="bg-white rounded-xl border shadow-sm overflow-hidden mb-10">
        <div class="p-6 border-b bg-gray-50">
            <h3 class="font-bold text-lg text-gray-800">Order Terbaru (Aktif)</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="p-4 text-left">Customer</th>
                        <th class="p-4 text-left">Status</th>
                        <th class="p-4 text-left">Tracking</th>
                        <th class="p-4 text-left">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                <?php if (mysqli_num_rows($orderSuccess) > 0): ?>
                    <?php $counter = 0; while ($item = mysqli_fetch_assoc($orderSuccess)): ?>
                        <?php if ($counter >= 10) break; ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4 font-medium"><?= htmlspecialchars($item['nama_user']) ?></td>
                            <td class="p-4"><?= labelStatus($item['status']) ?></td>
                            <td class="p-4">
                                <a href="order-details.php?t=<?= htmlspecialchars($item['no_tracking']) ?>" class="text-blue-600 hover:underline">
                                    <?= htmlspecialchars($item['no_tracking']) ?>
                                </a>
                            </td>
                            <td class="p-4 font-semibold text-green-600">
                                Rp <?= number_format($item['total_harga'], 0, ',', '.') ?>
                            </td>
                        </tr>
                        <?php $counter++; ?>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="p-10 text-center text-gray-500">
                            Belum ada order aktif
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- BUKTI PEMBAYARAN YANG DIUPLOAD -->
    <div class="bg-white rounded-xl border shadow-sm overflow-hidden mb-10">
        <div class="p-6 border-b bg-gray-50 flex justify-between items-center">
            <h3 class="font-bold text-lg text-gray-800">Bukti Pembayaran yang Diupload</h3>
            <span class="text-sm text-gray-600">
                <?= mysqli_num_rows($uploadedPayments) ?> bukti baru
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="p-4 text-left">Customer</th>
                        <th class="p-4 text-left">Tracking</th>
                        <th class="p-4 text-left">Total</th>
                        <th class="p-4 text-left">Upload</th>
                        <th class="p-4 text-left">Rekening</th>
                        <th class="p-4 text-left">Status</th>
                        <th class="p-4 text-left">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                <?php 
                if (mysqli_num_rows($uploadedPayments) > 0): 
                    while ($payment = mysqli_fetch_assoc($uploadedPayments)): 
                        $uploadDate = date('d M Y H:i', strtotime($payment['upload_date']));
                        $statusLabel = ($payment['order_status'] == 0) 
                            ? '<span class="text-yellow-600 font-medium">Menunggu Verifikasi</span>' 
                            : '<span class="text-green-600 font-medium">Sudah Diverifikasi</span>';
                ?>
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4 font-medium"><?= htmlspecialchars($payment['nama_user']) ?></td>
                        <td class="p-4">
                            <a href="order-details.php?t=<?= htmlspecialchars($payment['no_tracking']) ?>" 
                               class="text-blue-600 hover:underline">
                                <?= htmlspecialchars($payment['no_tracking']) ?>
                            </a>
                        </td>
                        <td class="p-4 font-semibold text-green-600">
                            Rp <?= number_format($payment['total_harga'], 0, ',', '.') ?>
                        </td>
                        <td class="p-4 text-gray-600 text-sm"><?= $uploadDate ?></td>
                        <td class="p-4 text-gray-700"><?= htmlspecialchars($payment['rekening']) ?></td>
                        <td class="p-4"><?= $statusLabel ?></td>
                        <td class="p-4">
                            <a href="order-details.php?t=<?= htmlspecialchars($payment['no_tracking']) ?>" 
                               class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">
                                Lihat & Verifikasi →
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="p-10 text-center text-gray-500">
                            Belum ada bukti pembayaran yang diupload
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- TOP 5 PRODUK TERLARIS -->
    <div class="bg-white rounded-xl border shadow-sm overflow-hidden">
        <div class="p-6 border-b bg-gray-50">
            <h3 class="font-bold text-lg text-gray-800">Top 5 Produk Terlaris</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="p-4 text-left">Produk</th>
                        <th class="p-4 text-left">Terjual</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                <?php if (mysqli_num_rows($topProducts) > 0): ?>
                    <?php while ($prod = mysqli_fetch_assoc($topProducts)): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4 font-medium"><?= htmlspecialchars($prod['nama_produk']) ?></td>
                            <td class="p-4 font-bold text-purple-600"><?= $prod['total_qty'] ?> unit</td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="2" class="p-10 text-center text-gray-500">
                            Belum ada penjualan produk
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</main>

<?php include('template/footer.php'); ?>
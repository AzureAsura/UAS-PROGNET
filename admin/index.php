<?php
include('../middleware/adminMiddleware.php');
include('functions/adminFunctions.php');
include('template/header.php');
include('template/sidebar.php');

/* =====================
   DATA DASHBOARD
===================== */

// Revenue
$statistik = getStatistik();
$revenue = 0;
if ($statistik && mysqli_num_rows($statistik) > 0) {
    $row = mysqli_fetch_assoc($statistik);
    $revenue = $row['tharga'] ?? 0;
}

// Orders
$orderAktif = getOrderOnGoing();
$orderHistory = getOrderHistory();

function labelStatus($status) {
    switch ($status) {
        case 0: return 'Menunggu Pembayaran';
        case 1: return 'Dibayar';
        case 2: return 'Dikirim';
        case 3: return 'Terkirim';
        default: return 'Unknown';
    }
}
?>

<!-- MAIN CONTENT - TANPA MAX-WIDTH untuk Dashboard -->
<main class="flex-1 p-3 sm:p-6 lg:p-8 pt-20 sm:pt-24 md:pt-8">
    
    <div class="mb-6 sm:mb-8">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Dashboard Admin</h1>
        <p class="text-sm sm:text-base text-gray-500 mt-1">
            Ringkasan aktivitas dan transaksi toko
        </p>
    </div>

    <!-- SUMMARY CARDS - Grid Full Width -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8 sm:mb-10">

        <div class="bg-blue-300 p-5 sm:p-6 rounded-xl border shadow-sm">
            <p class="text-xs sm:text-sm text-gray-700 font-semibold uppercase">Total Revenue</p>
            <h3 class="text-xl sm:text-2xl font-bold mt-2 text-gray-900">
                Rp <?= number_format($revenue, 0, ',', '.') ?>
            </h3>
        </div>

        <div class="bg-lime-300 p-5 sm:p-6 rounded-xl border shadow-sm">
            <p class="text-xs sm:text-sm text-gray-700 font-semibold uppercase">Order Aktif</p>
            <h3 class="text-xl sm:text-2xl font-bold mt-2 text-gray-900">
                <?= mysqli_num_rows($orderAktif) ?>
            </h3>
        </div>

        <div class="bg-yellow-300 p-5 sm:p-6 rounded-xl border shadow-sm">
            <p class="text-xs sm:text-sm text-gray-700 font-semibold uppercase">Order Selesai</p>
            <h3 class="text-xl sm:text-2xl font-bold mt-2 text-gray-900">
                <?= mysqli_num_rows($orderHistory) ?>
            </h3>
        </div>

        <div class="bg-orange-300 p-5 sm:p-6 rounded-xl border shadow-sm">
            <p class="text-xs sm:text-sm text-gray-700 font-semibold uppercase">Status Sistem</p>
            <h3 class="text-lg sm:text-xl font-bold mt-2 text-green-600">Aktif</h3>
        </div>

    </div>

    <!-- RECENT ORDERS TABLE -->
    <div class="bg-white rounded-xl border shadow-sm overflow-hidden">
        <div class="p-4 sm:p-6 border-b">
            <h3 class="text-base sm:text-lg font-bold text-gray-800">Order Aktif Terbaru</h3>
        </div>

        <!-- Mobile View: Card Style -->
        <div class="block sm:hidden divide-y">
            <?php if (mysqli_num_rows($orderAktif) > 0): ?>
                <?php foreach ($orderAktif as $item): ?>
                    <div class="p-4 space-y-2">
                        <div class="flex justify-between items-start">
                            <p class="font-semibold text-gray-900 text-sm">
                                <?= htmlspecialchars($item['nama_user']) ?>
                            </p>
                            <span class="text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded">
                                <?= labelStatus($item['status']) ?>
                            </span>
                        </div>
                        <p class="text-xs text-gray-500">
                            Tracking: <span class="font-mono"><?= htmlspecialchars($item['no_tracking']) ?></span>
                        </p>
                        <p class="text-sm font-bold text-gray-900">
                            Rp <?= number_format($item['total_harga'], 0, ',', '.') ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="p-6 text-center text-gray-500 text-sm">
                    Tidak ada order aktif
                </div>
            <?php endif; ?>
        </div>

        <!-- Desktop View: Table -->
        <div class="hidden sm:block overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                    <tr>
                        <th class="p-4 text-left font-semibold">Customer</th>
                        <th class="p-4 text-left font-semibold">Status</th>
                        <th class="p-4 text-left font-semibold">Tracking</th>
                        <th class="p-4 text-left font-semibold">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                <?php if (mysqli_num_rows($orderAktif) > 0): ?>
                    <?php 
                    // Reset pointer untuk loop kedua
                    mysqli_data_seek($orderAktif, 0);
                    foreach ($orderAktif as $item): 
                    ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4 font-medium text-gray-900">
                                <?= htmlspecialchars($item['nama_user']) ?>
                            </td>
                            <td class="p-4">
                                <span class="text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded font-medium">
                                    <?= labelStatus($item['status']) ?>
                                </span>
                            </td>
                            <td class="p-4 font-mono text-xs text-gray-600">
                                <?= htmlspecialchars($item['no_tracking']) ?>
                            </td>
                            <td class="p-4 font-semibold text-gray-900">
                                Rp <?= number_format($item['total_harga'], 0, ',', '.') ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="p-6 text-center text-gray-500">
                            Tidak ada order aktif
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</main>


<?php include('template/footer.php'); ?>
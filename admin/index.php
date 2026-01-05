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

<main class="flex-1 p-8 md:pt-8 pt-24 bg-gray-50 min-h-screen">

    <!-- HEADER -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard Admin</h1>
        <p class="text-gray-500 mt-1">
            Ringkasan aktivitas dan transaksi toko
        </p>
    </div>

    <!-- SUMMARY -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">

        <div class="bg-blue-300 p-6 rounded-xl border shadow-sm">
            <p class="text-sm text-gray-500 font-semibold uppercase">Total Revenue</p>
            <h3 class="text-2xl font-bold mt-2">
                Rp <?= number_format($revenue, 0, ',', '.') ?>
            </h3>
        </div>

        <div class="bg-lime-300 p-6 rounded-xl border shadow-sm">
            <p class="text-sm text-gray-500 font-semibold uppercase">Order Aktif</p>
            <h3 class="text-2xl font-bold mt-2">
                <?= mysqli_num_rows($orderAktif) ?>
            </h3>
        </div>

        <div class="bg-yellow-300 p-6 rounded-xl border shadow-sm">
            <p class="text-sm text-gray-500 font-semibold uppercase">Order Selesai</p>
            <h3 class="text-2xl font-bold mt-2">
                <?= mysqli_num_rows($orderHistory) ?>
            </h3>
        </div>

        <div class="bg-orange-300 p-6 rounded-xl border shadow-sm">
            <p class="text-sm text-gray-500 font-semibold uppercase">Status Sistem</p>
            <h3 class="text-xl font-bold mt-2 text-green-600">Aktif</h3>
        </div>

    </div>

    <!-- RECENT ORDERS -->
    <div class="bg-white rounded-xl border shadow-sm overflow-hidden">
        <div class="p-6 border-b">
            <h3 class="font-bold text-gray-800">Order Aktif Terbaru</h3>
        </div>

        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 uppercase">
                <tr>
                    <th class="p-4 text-left">Customer</th>
                    <th class="p-4 text-left">Status</th>
                    <th class="p-4 text-left">Tracking</th>
                    <th class="p-4 text-left">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y">
            <?php if (mysqli_num_rows($orderAktif) > 0): ?>
                <?php foreach ($orderAktif as $item): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 font-medium">
                            <?= htmlspecialchars($item['nama_user']) ?>
                        </td>
                        <td class="p-4">
                            <?= labelStatus($item['status']) ?>
                        </td>
                        <td class="p-4">
                            <?= htmlspecialchars($item['no_tracking']) ?>
                        </td>
                        <td class="p-4 font-semibold">
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

</main>

<?php include('template/footer.php'); ?>
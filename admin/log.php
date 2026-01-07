<?php
include('../middleware/adminMiddleware.php');
include('functions/adminFunctions.php');
include('template/header.php');
include('template/sidebar.php');

// Pagination sederhana
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 50; // jumlah per halaman
$offset = ($page - 1) * $limit;

$allLogs = getAllLogs($limit, $offset);
$totalLogs = getTotalLogsCount();
$totalPages = ceil($totalLogs / $limit);

// Log 24 jam terakhir
$last24Logs = getLast24HoursLogs();

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

    <!-- HEADER -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Log Aktivitas Admin</h1>
        <p class="text-gray-500 mt-1">Riwayat semua perubahan status order oleh admin</p>
    </div>

    <!-- RINGKASAN 24 JAM TERAKHIR -->
    <div class="bg-white rounded-xl border shadow-sm overflow-hidden mb-10">
        <div class="p-6 border-b bg-gray-50 flex justify-between items-center">
            <h3 class="font-bold text-lg text-gray-800">Aktivitas 24 Jam Terakhir</h3>
            <span class="text-sm text-gray-600">
                <?= mysqli_num_rows($last24Logs) ?> perubahan status
            </span>
        </div>

        <div class="p-6">
            <?php if (mysqli_num_rows($last24Logs) > 0): ?>
                <ul class="space-y-4">
                    <?php while ($log = mysqli_fetch_assoc($last24Logs)): ?>
                        <li class="bg-gray-50 p-4 rounded-lg border">
                            <p class="font-medium text-gray-800">
                                <?= htmlspecialchars($log['keterangan']) ?>
                            </p>
                            <p class="text-sm text-gray-500 mt-1">
                                <?= date('d M Y', strtotime($log['log_date'])) ?> 
                                pukul <?= $log['log_time'] ?>
                            </p>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p class="text-center text-gray-500 py-8">
                    Belum ada aktivitas dalam 24 jam terakhir
                </p>
            <?php endif; ?>
        </div>
    </div>

    <!-- SEMUA LOG (DENGAN PAGINATION) -->
    <div class="bg-white rounded-xl border shadow-sm overflow-hidden">
        <div class="p-6 border-b bg-gray-50">
            <h3 class="font-bold text-lg text-gray-800">Semua Riwayat Log</h3>
            <p class="text-sm text-gray-600 mt-1">
                Total: <?= $totalLogs ?> perubahan status
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="p-4 text-left">Keterangan</th>
                        <th class="p-4 text-left">Order ID</th>
                        <th class="p-4 text-left">Admin ID</th>
                        <th class="p-4 text-left">Tanggal & Waktu</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                <?php if (mysqli_num_rows($allLogs) > 0): ?>
                    <?php while ($log = mysqli_fetch_assoc($allLogs)): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4 font-medium"><?= htmlspecialchars($log['keterangan']) ?></td>
                            <td class="p-4"><?= $log['order_id'] ?></td>
                            <td class="p-4"><?= $log['log_admin'] ?></td>
                            <td class="p-4 text-gray-600">
                                <?= date('d M Y H:i:s', strtotime($log['created_at'])) ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="p-10 text-center text-gray-500">
                            Belum ada log aktivitas
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <?php if ($totalPages > 1): ?>
            <div class="p-6 flex justify-center items-center gap-4 border-t">
                <?php if ($page > 1): ?>
                    <a href="?page=<?= $page - 1 ?>" class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">
                        ← Sebelumnya
                    </a>
                <?php endif; ?>

                <span class="text-gray-700">
                    Halaman <?= $page ?> dari <?= $totalPages ?>
                </span>

                <?php if ($page < $totalPages): ?>
                    <a href="?page=<?= $page + 1 ?>" class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">
                        Selanjutnya →
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

</main>

<?php include('template/footer.php'); ?>
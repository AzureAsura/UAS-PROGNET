<?php
session_start();
include("includes/header.php");
include("validator/user-validator.php");          
include("middleware/clientMiddleware.php");


if (!isset($_SESSION['auth'])) {
    header('Location: ../login.php');
    exit;
}

$userId = $_SESSION['auth_user']['id_user'];

$profile = getProfile();        
$orders  = getOrders();    


?>

<div class=" pt-24 pb-10">
    <div class="max-w-[1400px] mx-auto px-4">
        
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl sm:text-4xl font-semibold text-gray-900 tracking-tight">Akun</h1>
            <a href="logout.php" class="text-sm text-gray-600 hover:text-gray-900 transition-colors">
                Keluar
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <div class="lg:col-span-1 space-y-4">
                <!-- Profile Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-6">Informasi Pribadi</h2>
                        
                        <?php if ($profile): ?>
                            <div class="space-y-5">
                                <div class="flex flex-col">
                                    <span class="text-xs text-gray-500 mb-1">Nama</span>
                                    <span class="text-sm text-gray-900 font-medium"><?= $profile['nama_user'] ?></span>
                                </div>
                                <div class="h-px bg-gray-100"></div>
                                
                                <div class="flex flex-col">
                                    <span class="text-xs text-gray-500 mb-1">Email</span>
                                    <span class="text-sm text-gray-900"><?= $profile['email'] ?></span>
                                </div>
                                <div class="h-px bg-gray-100"></div>
                                
                                <div class="flex flex-col">
                                    <span class="text-xs text-gray-500 mb-1">Telepon</span>
                                    <span class="text-sm text-gray-900"><?= $profile['no_telp'] ?></span>
                                </div>
                                <div class="h-px bg-gray-100"></div>
                                
                                <div class="flex flex-col">
                                    <span class="text-xs text-gray-500 mb-1">Bergabung</span>
                                    <span class="text-sm text-gray-900"><?= date("d M Y", strtotime($profile['created_at'] ?? 'now')) ?></span>
                                </div>
                            </div>
                        <?php else: ?>
                            <p class="text-sm text-gray-500">Data profil tidak tersedia</p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:border-gray-200 transition-colors">
                    <a href="add-address.php" class="block p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-900">Kelola Alamat</span>
                            </div>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </a>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 sm:p-8">
                        <h2 class="text-lg font-semibold text-gray-900 mb-6">Pesanan</h2>

                        <?php if (!empty($orders)): ?>
                            <div class="space-y-4">
                                <?php foreach ($orders as $order): 
                                $statusLabels = [
                                    0 => 'Pesanan Dibuat',
                                    1 => 'Pembayaran Terverifikasi',
                                    2 => 'Produk Dikirim',
                                    3 => 'Terkirim',
                                    4 => 'Dibatalkan'
                                ];

                                $statusColors = [
                                    0 => 'bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-600/20',
                                    1 => 'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20',
                                    2 => 'bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-600/20',
                                    3 => 'bg-green-50 text-green-700 ring-1 ring-inset ring-green-600/20',
                                    4 => 'bg-red-50 text-red-700 ring-1 ring-inset ring-red-600/20'
                                ];

                                $status = $order['status'] ?? -1;
                                $label = $statusLabels[$status] ?? 'Status Tidak Dikenal';
                                $color = $statusColors[$status] ?? 'bg-gray-50 text-gray-700 ring-1 ring-inset ring-gray-600/20';
                                    
                                    
                                    ?>
                                    <div class="border border-gray-100 rounded-xl p-5 hover:border-gray-200 transition-colors">
                                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                            <div class="space-y-2.5">
                                                <div class="flex items-center gap-3 flex-wrap">
                                                    <!-- ORDER STATUS -->
                                                    <span class="text-sm font-medium text-gray-900">
                                                        #<?= $order['no_tracking'] ?>
                                                    </span>

                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $color ?>">
                                                        <?= htmlspecialchars($label) ?>
                                                    </span>

                                                    <!-- PAYMENT STATUS -->
                                                    <?php if (empty($order['paid_order_id'])): ?>
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                                    bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-600/20">
                                                            Menunggu Pembayaran
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                                    bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                                                            Sudah Dibayar
                                                        </span>
                                                    <?php endif; ?>
                                                </div>

                                                <p class="text-sm text-gray-500"><?= date("d M Y, H:i", strtotime($order['created_at'])) ?></p>
                                                <p class="text-base font-semibold text-gray-900">
                                                    Rp <?= number_format($order['total_harga'], 0,',','.') ?>
                                                </p>
                                            </div>

                                            <a href="order-details.php?t=<?= urlencode($order['no_tracking']) ?>"
                                               class="inline-flex items-center justify-center px-5 py-2.5 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors">
                                                Lihat Detail
                                            </a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-12">
                                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                                <p class="text-base text-gray-500 mb-4">Belum ada pesanan</p>
                                <a href="index.php" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-700 transition-colors">
                                    Mulai Belanja
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>
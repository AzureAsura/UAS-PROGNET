<?php include('../middleware/adminMiddleware.php') ?>
<?php include('functions/adminFunctions.php') ?>
<?php include('template/header.php');?>

    <!-- SIDEBAR -->
    <?php include('template/sidebar.php')?>

    <!-- CONTENT -->
    <main class="flex-1 p-8 md:pt-8 pt-24">
      <div class="mb-8">
        <h1 class="text-4xl font-bold text-[#3C3F58] mb-2">Semua Order</h1>
        <p class="text-[#707793]">Kelola semua pesanan dari pelanggan</p>
      </div>

        <?php
            $orders = getOrders();

            if (mysqli_num_rows($orders) > 0) {
        ?>

        <div class="grid grid-cols-1 gap-6">
            <?php foreach ($orders as $item) { ?>
                <div class="bg-white border-2 border-gray-200 rounded-2xl overflow-hidden hover:border-blue-400 hover:shadow-xl transition-all duration-300 group">
                    
                    <!-- Header Card dengan Background -->
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-6 text-white">
                        <div class="flex items-center justify-between flex-wrap gap-4">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                                    <i class="ri-shopping-bag-line text-2xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-blue-100 font-medium">Order ID</p>
                                    <p class="text-2xl font-bold">#<?= $item['id_order'] ?></p>
                                </div>
                            </div>
                            
                            <div class="text-right">
                                <p class="text-sm text-blue-100 font-medium mb-1">Total Pembayaran</p>
                                <p class="text-3xl font-bold">
                                    Rp <?= number_format($item['total_harga'],0,',','.') ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Body Card dengan Info Detail -->
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                            
                            <!-- Pelanggan -->
                            <div class="space-y-2">
                                <div class="flex items-center gap-2 text-gray-500 text-xs font-semibold uppercase tracking-wider">
                                    <i class="ri-user-line text-base"></i>
                                    <span>Pelanggan</span>
                                </div>
                                <p class="text-gray-900 font-bold text-lg leading-tight"><?= $item['nama_user'] ?></p>
                            </div>

                            <!-- Tracking Number -->
                            <div class="space-y-2">
                                <div class="flex items-center gap-2 text-gray-500 text-xs font-semibold uppercase tracking-wider">
                                    <i class="ri-barcode-line text-base"></i>
                                    <span>No. Tracking</span>
                                </div>
                                <p class="text-gray-900 font-mono font-bold text-base bg-gray-100 px-3 py-2 rounded-lg inline-block">
                                    <?= $item['no_tracking'] ?>
                                </p>
                            </div>

                            <!-- Tanggal Order -->
                            <div class="space-y-2">
                                <div class="flex items-center gap-2 text-gray-500 text-xs font-semibold uppercase tracking-wider">
                                    <i class="ri-calendar-check-line text-base"></i>
                                    <span>Tanggal Order</span>
                                </div>
                                <p class="text-gray-900 font-bold text-base">
                                    <?= date('d M Y', strtotime($item['created_at'])) ?>
                                </p>
                                <p class="text-gray-500 text-sm">
                                    <?= date('H:i', strtotime($item['created_at'])) ?> WIB
                                </p>
                            </div>

                            <!-- Status Pembayaran -->
                            <div class="space-y-2">
                                <div class="flex items-center gap-2 text-gray-500 text-xs font-semibold uppercase tracking-wider">
                                    <i class="ri-shield-check-line text-base"></i>
                                    <span>Status</span>
                                </div>
                                <span class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 font-bold text-sm rounded-lg">
                                    <i class="ri-checkbox-circle-fill text-base mr-2"></i>
                                    Aktif
                                </span>
                            </div>

                        </div>

                        <!-- Action Button -->
                        <div class="pt-4 border-t-2 border-gray-100">
                            <a href="order-details.php?t=<?= $item['no_tracking'] ?>"
                               class="w-full md:w-auto inline-flex items-center justify-center gap-3 px-8 py-3.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-lg hover:shadow-xl group-hover:scale-[1.02]">
                               <i class="ri-eye-line text-xl"></i>
                               <span>Lihat Detail Lengkap</span>
                               <i class="ri-arrow-right-line text-xl group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>

                </div>
            <?php } ?>
        </div>

        <?php
            } else {
        ?>
                <div class="flex flex-col items-center justify-center py-20 bg-white rounded-2xl border-2 border-dashed border-gray-300">
                    <div class="w-32 h-32 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                        <i class="ri-shopping-bag-line text-6xl text-gray-300"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Belum Ada Order</h3>
                    <p class="text-gray-500 text-center max-w-md">
                        Belum ada pesanan yang masuk. Order akan muncul di sini setelah pelanggan melakukan pemesanan.
                    </p>
                </div>
        <?php
            }
        ?>
    </main>

  <?php include('template/footer.php')?>
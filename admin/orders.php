<?php include('../middleware/adminMiddleware.php') ?>
<?php include('functions/adminFunctions.php') ?>
<?php include('template/header.php');?>
<?php
// LOAD MODEL
include('../admin/app/Model/order_model.php');

// INIT MODEL
$orderModel = new OrderModel($con);

// GET DATA
$orders = $orderModel->getOrders();
?>
    <!-- SIDEBAR -->
    <?php include('template/sidebar.php')?>

   <!-- CONTENT -->
    <main class="flex-1 p-8 md:pt-8 pt-24">
      <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-1">Semua Order</h1>
        <p class="text-gray-500">Kelola semua pesanan dari pelanggan</p>
      </div>

        <?php
            $orders = $orderModel->getOrders();

            if (mysqli_num_rows($orders) > 0) {
        ?>

        <div class="space-y-4">
            <?php foreach ($orders as $item) { ?>
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-md">
                    
                    <div class="flex items-start justify-between mb-4 pb-4 border-b border-gray-100">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Order #<?= $item['id_order'] ?></p>
                            <p class="text-xl font-bold text-gray-900">Rp <?= number_format($item['total_harga'],0,',','.') ?></p>
                        </div>
                        <a href="order-details.php?t=<?= $item['no_tracking'] ?>"
                           class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors">
                           Lihat Detail
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                        <div>
                            <p class="text-gray-500 mb-1">Pelanggan</p>
                            <p class="font-semibold text-gray-900"><?= $item['nama_user'] ?></p>
                        </div>
                        <div>
                            <p class="text-gray-500 mb-1">No. Tracking</p>
                            <p class="font-mono font-semibold text-gray-900"><?= $item['no_tracking'] ?></p>
                        </div>
                        <div>
                            <p class="text-gray-500 mb-1">Tanggal</p>
                            <p class="font-semibold text-gray-900"><?= date('d M Y, H:i', strtotime($item['created_at'])) ?></p>
                        </div>
                    </div>

                </div>
            <?php } ?>
        </div>

        <?php
            } else {
        ?>
                <div class="text-center py-16 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-gray-500">Belum ada order.</p>
                </div>
        <?php
            }
        ?>
    </main>

  <?php include('template/footer.php')?>
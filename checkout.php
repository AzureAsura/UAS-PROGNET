<?php
session_start();
include("includes/header.php");
include("validator/user-validator.php");        
include("middleware/clientMiddleware.php");
require_once "config/class-address.php";

$user_id = $_SESSION['auth_user']['id_user'];

$addressObj = new Address();
$addresses  = $addressObj->getAddressByUser($user_id);

$items = getCart();
$totalPrice = 0;

foreach ($items as $citem) {
    $totalPrice += $citem['harga_jual'] * $citem['prod_qty'];
}

$estimatedTax = 0; // Estimasi pajak
$subtotal = $totalPrice;
$grandTotal = $subtotal;
?>

<div class=" mt-24">
    <div class="max-w-[1400px] mx-auto px-4">
        
        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-sm mb-8 text-gray-600">
            <a href="cart.php" class="hover:text-gray-900">Cart</a>
            <span>›</span>
            <span class="font-medium text-gray-900">Shipping</span>
            <span>›</span>
            <span class="text-gray-400">Payment</span>
        </div>

        <?php if(empty($items)): ?>
            <div class="text-center py-20 text-xl text-gray-600 bg-white rounded-lg">
                Keranjang kosong. <a href="index.php" class="text-blue-600 underline">Belanja dulu</a>
            </div>
        <?php else: ?>

        <form action="proses/proses-order.php" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- KIRI: FORM (2 kolom) -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Shipping Address Section -->
                <div class="bg-white rounded-lg p-8 shadow-sm">
                    <h2 class="text-2xl font-semibold mb-6">Data Pengiriman</h2>
                    
                    <div class="space-y-4">
                        <!-- Nama Lengkap -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap*
                            </label>
                            <input type="text" name="nama_user" placeholder="Nama Lengkap"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Email*
                            </label>
                            <input type="email" name="email" placeholder="Email"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                        </div>

                        <!-- No Telepon -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                No Telepon*
                            </label>
                            <input type="text" name="no_telp" placeholder="No Telepon"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                        </div>

                        <!-- Kode Pos -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Kode Pos*
                            </label>
                            <input type="text" name="pincode" placeholder="Kode Pos"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                        </div>

                        <!-- Pilih Alamat -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Pilih Alamat*
                            </label>
                            <select name="alamat" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white">
                                <option value="">-- Pilih Alamat --</option>
                                <?php if (!empty($addresses)): ?>
                                    <?php foreach ($addresses as $addr): ?>
                                        <option value="<?= $addr['id_alamat'] ?>">
                                            <?= $addr['alamat'] ?>, <?= $addr['kota'] ?>, <?= $addr['provinsi'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option disabled>Belum ada alamat</option>
                                <?php endif; ?>
                            </select>
                            <a href="add-address.php" class="text-sm text-blue-600 mt-2 inline-block hover:underline">
                                + Tambah alamat baru
                            </a>
                        </div>
                    </div>
                </div>



            </div>

            <!-- KANAN: CART SUMMARY (1 kolom) -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg p-6 shadow-sm top-8">
                    <h2 class="text-2xl font-semibold mb-6">Pesanan Anda</h2>
                    
                    <!-- Cart Items -->
                    <div class="space-y-4 mb-6 max-h-80 overflow-y-auto">
                        <?php foreach($items as $citem): ?>
                        <div class="flex gap-3 mt-2">
                            <div class="relative">
                                <img src="uploads/<?= $citem['gambar'] ?>" 
                                    class="w-20 h-20 object-cover rounded-lg bg-gray-100">
                                <span class="absolute -top-2 -right-2 bg-black text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">
                                    <?= $citem['prod_qty'] ?>
                                </span>
                            </div>
                            <div class="flex-1 flex flex-col justify-center space-y-2">
                                <div>
                                    <h4 class="font-medium text-sm"><?= $citem['nama_produk'] ?></h4>
                                </div>
                                <p class="font-semibold">Rp <?= number_format($citem['harga_jual'] * $citem['prod_qty'],0,',','.') ?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Total -->
                    <div class="flex justify-between items-center mb-6 pt-4 border-t-2">
                        <span class="text-lg font-semibold">Total</span>
                        <span class="text-2xl font-bold">Rp <?= number_format($grandTotal,0,',','.') ?></span>
                    </div>

                    <!-- Hidden Inputs -->
                    <input type="hidden" name="total_price" value="<?= $grandTotal ?>">
                    <input type="hidden" name="payment_mode" value="Bank Transfer">

                    <!-- Submit Button -->
                    <button type="submit" name="placeOrderBtn" 
                        class="w-full bg-black text-white py-4 rounded-lg font-medium hover:bg-gray-800 transition">
                        Konfirmasi Pesanan
                    </button>
                </div>
            </div>

        </form>

        <?php endif; ?>
    </div>
</div>

<?php include("includes/footer.php"); ?>
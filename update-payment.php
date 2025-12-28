<?php
session_start();
include("includes/header.php");
require_once "config/class-payment.php";
include("middleware/clientMiddleware.php");

if (!isset($_GET['id_order'])) {
    $_SESSION['message'] = "Order tidak valid";
    header("Location: profile.php");
    exit;
}

$orderId = (int)$_GET['id_order'];

$paymentObj = new Payment();
$payment = $paymentObj->getPaymentByOrder($orderId);

if (!$payment) {
    $_SESSION['message'] = "Data pembayaran tidak ditemukan untuk pesanan ini";
    header("Location: profile.php");
    exit;
}


?>

<div class="mt-24 sm:mt-36 mx-4 sm:mx-auto max-w-xl 
            bg-white p-5 sm:p-8 
            rounded-2xl shadow-lg border">

    <h2 class="text-xl sm:text-2xl font-bold mb-6 text-gray-800 text-center sm:text-left">
        Update Bukti Pembayaran
    </h2>

    <form action="proses/proses-payment.php" 
          method="POST" 
          enctype="multipart/form-data"
          class="space-y-6">

        <input type="hidden" name="id_payment" value="<?= $payment['id_payment'] ?>">
        <input type="hidden" name="id_order" value="<?= $orderId ?>">
        <input type="hidden" name="old_image" value="<?= htmlspecialchars($payment['bukti_pembayaran']) ?>">
        <input type="hidden" name="no_tracking" value="<?= htmlspecialchars($payment['no_tracking']) ?>">

        <!-- Rekening -->
        <div>
            <label class="block font-medium text-gray-700 mb-2 text-sm sm:text-base">
                Rekening Pengirim
            </label>
            <input type="text" 
                   name="rekening"
                   value="<?= htmlspecialchars($payment['rekening']) ?>"
                   class="w-full border border-gray-300 p-3 rounded-xl
                          text-sm sm:text-base
                          focus:ring-2 focus:ring-blue-500 focus:outline-none"
                   required>
        </div>

        <!-- Bukti -->
        <div>
            <label class="block font-medium text-gray-700 mb-3 text-sm sm:text-base">
                Bukti Pembayaran Saat Ini
            </label>

            <div class="flex justify-center sm:justify-start">
                <img src="uploads/payments/<?= htmlspecialchars($payment['bukti_pembayaran']) ?>"
                     alt="Bukti Pembayaran"
                     class="w-full max-w-[220px] sm:w-48 
                            rounded-xl border shadow-sm mb-4 object-cover">
            </div>

            <label class="block font-medium text-gray-700 mb-2 text-sm sm:text-base">
                Ganti dengan yang baru (opsional)
            </label>
            <input type="file" 
                   name="bukti_pembayaran"
                   class="w-full border border-gray-300 p-3 rounded-xl text-sm sm:text-base">
        </div>

        <!-- Button -->
        <button type="submit" 
                name="update_payment"
                class="w-full bg-gray-900 hover:bg-gray-800 
                       text-white py-3 sm:py-3.5
                       rounded-xl font-semibold 
                       text-sm sm:text-base
                       transition active:scale-[0.98]">
            Simpan Perubahan
        </button>
    </form>
</div>


<?php
include("includes/footer.php");
?>

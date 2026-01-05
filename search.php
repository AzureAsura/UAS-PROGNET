<?php
session_start();
include("includes/header.php");
include("config/class-user.php");

$user = new User();

// LOGIC SEARCH
if (isset($_GET['q']) && trim($_GET['q']) !== '') {
    $products = $user->searchProducts($_GET['q']);
    $title = "Search Results";
} else {
    // sebelum search → tampil semua produk
    $products = $user->getAllProducts();
    $title = "All Products";
}
?>

<div class="mt-24 max-w-[1400px] mx-auto px-4">

    <!-- SEARCH INPUT -->
    <form method="GET" class="mb-10">
        <input
            type="text"
            name="q"
            placeholder="Search product..."
            value="<?= isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '' ?>"
            class="w-full border border-gray-300 rounded-xl px-5 py-4 text-sm focus:outline-none focus:ring-2 focus:ring-black"
        >
    </form>

    <!-- TITLE -->
    <h2 class="text-3xl font-bold text-start mb-6">
        <?= $title ?>
    </h2>

    <!-- PRODUCT GRID -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-14 mt-14">

        <?php if (!empty($products)) : ?>
            <?php foreach ($products as $item) : ?>
                <a href="product-view.php?product=<?= $item['slug'] ?>" class="group block">

                    <!-- IMAGE -->
                    <div class="bg-[#F5F5F5] rounded-xl flex items-center justify-center overflow-hidden transition-transform duration-300 group-hover:scale-105">
                        <img
                            src="uploads/<?= $item['gambar'] ?>"
                            alt="<?= $item['nama_produk'] ?>"
                            class="max-h-full w-auto object-contain"
                        >
                    </div>

                    <!-- INFO -->
                    <div class="mt-4 flex justify-between items-center text-sm text-slate-800">
                        <p class="font-medium truncate max-w-[60%]">
                            <?= $item['nama_produk'] ?>
                        </p>
                        <p class="font-semibold">
                            Rp<?= number_format($item['harga_jual'], 0, ',', '.') ?>
                        </p>
                    </div>

                </a>
            <?php endforeach; ?>
        <?php else : ?>
            <p class="col-span-5 text-center text-gray-500">
                Produk tidak ditemukan
            </p>
        <?php endif; ?>

    </div>

</div>

<?php include("includes/footer.php"); ?>

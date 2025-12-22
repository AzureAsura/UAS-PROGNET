<?php

session_start();
include("includes/header.php");
include("config/class-user.php");

$user = new User();

if (isset($_GET['category'])) {
    $category_slug = $_GET['category'];

    // Ambil data kategori pakai class
    $category = $user->getSlugActive("tb_kategori", $category_slug);

    if ($category) {
        $cid = $category['id_kategori'];
?>

        <div class="mt-24 max-w-[1400px] mx-auto px-4">
            <h2 class="text-3xl font-bold text-start mb-6"><?= $category['nama_kategori'] ?></h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-10 text-center">
                <?php

                // Ambil product by category
                $products = $user->getProductByCategory($cid);

                if (!empty($products)) {
                    foreach ($products as $item) {
                ?>

                        <a href="product-view.php?product=<?= $item['slug'] ?>" class="group block">

                            <div class="bg-[#F5F5F5] rounded-xl flex items-center justify-center overflow-hidden transition-transform duration-300 group-hover:scale-105">
                                <img src="uploads/<?= $item['gambar'] ?>"
                                    alt="<?= $item['nama_produk'] ?>"
                                    class="max-h-full w-auto object-contain">
                            </div>

                            <div class="mt-4 flex justify-between items-center text-sm text-slate-800">
                                <p class="font-medium truncate max-w-[60%]">
                                    <?= $item['nama_produk'] ?>
                                </p>
                                <p class="font-semibold">
                                    Rp<?= number_format($item['harga_jual'], 0, ',', '.') ?>
                                </p>
                            </div>
                        </a>

                <?php
                    }
                } else {
                    echo "<p class='text-gray-600 col-span-6 text-center'>No data available</p>";
                }
                ?>
            </div>
        </div>

<?php
    } else {
        echo "<div class='mt-20 max-w-[1400px] mx-auto px-4'>";
        echo "Something went wrong";
    }
} else {
    echo "<div class='mt-20 max-w-[1400px] mx-auto px-4'>";
    echo "Something went wrong";
}

include("includes/footer.php");
?>
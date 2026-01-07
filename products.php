<?php

session_start();
include("includes/header.php");
include("config/class-user.php");

$user = new User();

if (isset($_GET['category'])) {
    $category_slug = $_GET['category'];

    $category = $user->getSlugActive("tb_kategori", $category_slug);

    if ($category) {
        $cid = $category['id_kategori'];
?>
        
        <div class="mt-24 max-w-[1400px] mx-auto px-6">
            <h2 class="text-4xl font-semibold text-start mb-5"><?= $category['nama_kategori'] ?></h2>

            <div class="">
                <?php

                $products = $user->getProductByCategory($cid);

                if (!empty($products)) {
                    foreach ($products as $item) {
                ?>

                        <div class="py-8 border-b border-gray-200">
                            <div class="flex flex-col lg:grid lg:grid-cols-2 gap-8 lg:gap-12 items-center">
                                
                                <div class="text-center lg:text-left order-1 lg:order-1">
                                    <h3 class="text-3xl lg:text-3xl font-semibold mb-3"><?= $item['nama_produk'] ?></h3>
                                    <p class="text-base lg:text-md text-gray-600 mb-6"><?= $item['headline'] ?></p>
                                    
                                    <div class="hidden lg:flex">
                                        <a href="product-view.php?product=<?= $item['slug'] ?>" 
                                        class="px-8 py-3 bg-blue-600 text-white rounded-2xl hover:bg-blue-700 transition font-medium text-base">
                                            Beli sekarang
                                        </a>
                                    </div>

                                </div>

                                <div class="order-2 lg:order-2 w-full">
                                    <a href="product-view.php?product=<?= $item['slug'] ?>" class="block">
                                        <div class="relative w-full flex items-center justify-center lg:justify-end">
                                            <img src="uploads/<?= $item['gambar'] ?>"
                                                alt="<?= $item['nama_produk'] ?>"
                                                class="w-[180px] lg:w-[280px] object-contain hover:scale-105 transition-transform duration-300">
                                        </div>
                                    </a>

                                    <div class="mt-8 flex justify-center lg:hidden">
                                        <a href="product-view.php?product=<?= $item['slug'] ?>" 
                                        class="w-full px-8 py-3 bg-blue-600 text-white rounded-2xl hover:bg-blue-700 transition font-medium text-sm text-center">
                                            Beli sekarang
                                        </a>
                                    </div>
                                </div>



                            </div>
                        </div>

                <?php
                    }
                } else {
                    echo "<p class='text-gray-600 text-center py-12'>Data tidak tersedia</p>";
                }
                ?>
            </div>
        </div>

<?php
    } else {
        echo "<div class='mt-20 max-w-[1200px] mx-auto px-6'>";
        echo "<p class='text-center text-gray-600'>Something went wrong</p>";
        echo "</div>";
    }
} else {
    echo "<div class='mt-20 max-w-[1200px] mx-auto px-6'>";
    echo "<p class='text-center text-gray-600'>Something went wrong</p>";
    echo "</div>";
}

include("includes/footer.php");
?>
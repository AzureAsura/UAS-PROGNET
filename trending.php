<?php

session_start();
include("includes/header.php");
include("config/class-user.php");

$user = new User();

?>

        <div class="mt-24 max-w-[1400px] mx-auto px-4">
            <h2 class="text-3xl font-bold text-start mb-6">Trending Products</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-14 mt-14">

                <?php
                $trending = $user->getTrending();
                $counttrending = 1;
                $maxtrending = 8;

                if (!empty($trending)) {
                    foreach ($trending as $item) {
                        if ($counttrending > $maxtrending) {
                            break;
                        } else {
                            $counttrending++;
                        }

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
                    echo "<p class='text-gray-600 col-span-4 text-center'>No data available</p>";
                }
                ?>
            </div>

        </div>

<?php
include("includes/footer.php");
?>
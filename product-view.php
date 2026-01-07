<?php
session_start(); 
include("includes/header.php");
include("config/class-user.php");

$user = new User();

if (isset($_GET['product'])) {
    
    $product_slug = $_GET['product'];
    $product = $user->getSlugActive("tb_produk", $product_slug);
    $randomProducts = $user->getRandomProductsExceptSlug("tb_produk", $product_slug, 5);


    if ($product) {


$diskon_persen = 0;
if ($product['harga_asli'] > $product['harga_jual'] && $product['harga_asli'] > 0) {
    $diskon_persen = round((($product['harga_asli'] - $product['harga_jual']) / $product['harga_asli']) * 100);
}

?>
    <div class="max-w-[1400px] mx-auto px-6">

        <div class="flex max-lg:flex-col gap-12 mt-24 product-data">
            <div class="flex max-sm:flex-col-reverse gap-3">
                <div class="flex sm:flex-col gap-3">
                        <div class="bg-slate-100 flex items-center justify-center size-26 rounded-lg group cursor-pointer">
                            <img src="uploads/<?= $product['gambar'] ?>" alt="product image" class="w-[100px] h-[100px] hover:scale-105 active:scale-95 transition">
                        </div>
                </div>
                <div class="flex justify-center items-center h-100 sm:size-113 bg-slate-100 rounded-lg ">
                    <img src="uploads/<?= $product['gambar'] ?>" alt="product image" class="w-[450px] md:h-[450px] h-[350px] object-contain">
                </div>
            </div>
            <div class="flex-1">
                <h1 class="text-3xl font-semibold text-slate-800"> <?= $product['nama_produk'] ?></h1>

                <div class="flex items-start mb-6 mt-2 gap-3 text-2xl font-semibold text-slate-800">
                    <p>Rp. <?= number_format($product['harga_jual'], 0,  ',', '.') ?></p>
                    <p class="text-xl text-slate-500 line-through">
                        Rp. <?= number_format($product['harga_asli'], 0, ',', '.') ?>
                    </p>
                </div>
                <div class="flex items-center gap-2 text-slate-500">
                    <TagIcon size={14} />
                    <p>Potongan <?= $diskon_persen ?>% hari ini</p>
                </div>
                <div class="flex items-end gap-5 mt-10">
                            <div class="flex flex-col gap-3">
                                <p class="text-lg text-slate-800 font-semibold">Jumlah</p>
                                <div class="flex items-center gap-2">
                                    <!-- <button class="decrement_btn bg-gray-200 px-3 py-1 rounded">-</button>
                                    <input type="text" class="qty-input w-12 text-center border border-gray-300 rounded" value="1">
                                    <button class="increment_btn bg-gray-200 px-3 py-1 rounded">+</button> -->

                                    <button class="decrement_btn bg-gray-200 w-11 h-11 rounded flex items-center justify-center">-</button>
                                    <input type="text" class="w-12 h-11 text-center border rounded qty-input" value="1">
                                    <button class="increment_btn bg-gray-200 w-11 h-11 rounded flex items-center justify-center">+</button>

                                </div>
                            </div>

                    <button class="bg-slate-800 text-white px-10 py-3 text-sm font-medium rounded hover:bg-slate-900 active:scale-95 transition add-to-cart" value="<?= $product['id_produk'] ?>">
                        Tambah keranjang
                    </button>
                </div>
                <hr class="border-gray-300 my-5" />
                <div class="flex flex-col gap-4 text-slate-500 mt-6">
                    <div class="flex items-center gap-3">
                        <i class="ri-price-tag-3-line text-lg text-slate-400"></i>
                        <p class="text-sm">Hemat <?= $diskon_persen ?>% khusus hari ini</p>
                    </div>

                    <div class="flex items-center gap-3">
                        <i class="ri-truck-line text-lg text-slate-400"></i>
                        <p class="text-sm">Gratis ongkir ke seluruh Indonesia</p>
                    </div>

                    <div class="flex items-center gap-3">
                        <i class="ri-shield-check-line text-lg text-slate-400"></i>
                        <p class="text-sm">Produk 100% original & garansi resmi</p>
                    </div>
                </div>

            </div>
        </div>

        <div class="mt-14 text-sm text-black w-full">
            <div class="flex border-b border-gray-300 mb-6">
                    <button class='text-black py-2 font-semibold'>
                        Deskripsi
                    </button>
            </div>

            <p class="text-md"><?= nl2br($product['deskripsi']) ?></p>
        </div>

        <?php if (!empty($randomProducts)) : ?>
        <div class="mt-20">
            <h2 class="text-2xl font-semibold text-slate-800 mb-6">Kamu mungkin suka</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-14">
                <?php foreach ($randomProducts as $item) : ?>
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


                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

    </div>
<?php
    } else {
        echo "<div class='mt-20 max-w-[1400px] mx-auto px-4'>Product not found</div>";
    }

} else {
    echo "<div class='mt-20 max-w-[1400px] mx-auto px-4'>Invalid request</div>";
}

include("includes/footer.php");
?>

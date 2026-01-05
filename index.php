<?php
session_start();
include("includes/header.php");
include("config/class-user.php");

$user = new User();
?>

<div class="mt-24 max-w-[1400px] mx-auto px-4">

    <div class=''>
        <div class='flex max-xl:flex-col gap-8  mx-auto my-10'>
            <div class='relative flex-1 flex flex-col bg-slate-300 rounded-3xl xl:min-h-100 group'>
                <div class='p-5 sm:p-16'>
                    <div class='inline-flex items-center gap-3 bg-slate-500 text-slate-900 pr-4 p-1 rounded-full text-xs sm:text-sm'>
                        <span class='bg-slate-700 px-3 py-1 max-sm:ml-1 rounded-full text-white text-xs'>NEWS</span> Free Shipping on Orders Above $50!
                        <ChevronRightIcon class='group-hover:ml-2 transition-all' size={16} />
                    </div>
                    <h2 class='text-3xl sm:text-5xl leading-[1.2] my-3 font-medium bg-gradient-to-r from-slate-700 to-blue-400 bg-clip-text text-transparent max-w-xs  sm:max-w-md'>
                        Gadgets you'll love. Prices you'll trust.
                    </h2>
                    <div class='text-slate-800 text-sm font-medium mt-4 sm:mt-8'>
                        <p>Starts from</p>
                        <p class='text-3xl'>Rp. 10.000.000</p>
                    </div>
                    <button class='bg-slate-800 text-white text-sm py-2.5 px-7 sm:py-5 sm:px-12 mt-4 sm:mt-10 rounded-md hover:bg-slate-900 hover:scale-103 active:scale-95 transition'>LEARN MORE</button>
                </div>
                <img src="assets/img/dina-bg.png" alt="" class='sm:absolute bottom-0 right-0 md:right-10 w-full sm:max-w-sm'>
            </div>

            <div class='flex flex-col md:flex-row xl:flex-col gap-5 w-full xl:max-w-sm text-sm text-slate-600'>
                <div class='flex-1 flex items-center justify-between w-full bg-slate-300 rounded-3xl p-6 px-8 group'>
                    <div>
                        <p class='text-3xl font-medium bg-gradient-to-r from-slate-700  to-blue-400 bg-clip-text text-transparent max-w-40'>Best products</p>
                        <div class="flex items-center gap-1 mt-4">
                            <p>View more
                            </p>
                            <i class="ri-arrow-right-line flex items"></i>
                        </div>
                    </div>
                    <img src="assets/img/hero-p-2.png" alt="hero" class="w-32">

                </div>
                <div class='flex-1 flex items-center justify-between w-full bg-slate-300 rounded-3xl p-6 px-8 group'>
                    <div>
                        <p class='text-3xl font-medium bg-gradient-to-r from-slate-700 to-blue-400 bg-clip-text text-transparent max-w-40'>20% discounts</p>
                        <div class="flex items-center gap-1 mt-4">
                            <p>View more
                            </p>
                            <i class="ri-arrow-right-line flex items"></i>
                        </div>
                    </div>
                    <img src="assets/img/hero-p-1.png" alt="" class="w-32">
                </div>
            </div>
        </div>
    </div>

<div class="relative w-fulll mx-auto mt-16">

    <!-- SLIDER -->
    <div class="overflow-hidden">
        <div id="categoryCarousel"
            class="flex transition-transform duration-500 ease-out">

            <?php
            $categories = $user->getAllActive('tb_kategori');
            if (!empty($categories)) {
                foreach ($categories as $item) {
            ?>
                    <a href="products.php?category=<?= $item['slug'] ?>"
                        class="min-w-[50%] sm:min-w-[33.333%] md:min-w-[16.666%] px-6 group">

                        <div class="flex flex-col items-center text-center">
                            <div
                                class="w-24 h-24 flex items-center justify-center mb-4
                                transition-transform duration-300 group-hover:scale-105">
                                <img
                                    src="uploads/<?= $item['gambar'] ?>"
                                    alt="<?= $item['nama_kategori'] ?>"
                                    class="object-contain opacity-90 group-hover:opacity-100">
                            </div>

                            <h4 class="text-sm font-medium text-gray-900">
                                <?= $item['nama_kategori'] ?>
                            </h4>

                            <p class="text-xs text-gray-400 mt-1 leading-relaxed">
                                <?= $item['deskripsi'] ?>
                            </p>
                        </div>
                    </a>
            <?php
                }
            }
            ?>
        </div>
    </div>

    <!-- BUTTON -->
    <button id="prevCat"
        class="absolute left-0 top-1/2 -translate-y-1/2
        backdrop-blur-md bg-white/70 text-gray-600
        w-10 h-10 rounded-full shadow-sm
        hover:bg-white hover:text-black transition">
        ❮
    </button>

    <button id="nextCat"
        class="absolute right-0 top-1/2 -translate-y-1/2
        backdrop-blur-md bg-white/70 text-gray-600
        w-10 h-10 rounded-full shadow-sm
        hover:bg-white hover:text-black transition">
        ❯
    </button>
</div>

    <div class='flex flex-col items-center mt-24'>
        <h2 class='text-2xl font-semibold text-slate-800'>Trending Products</h2>
        <a href="trending.php" class='flex items-center gap-5 text-sm text-slate-600 mt-2'>
            <p class='max-w-lg text-center'>Showing 4 of 12 products</p>
            <button class='text-green-500 flex items-center gap-1'>View more
                <i class="ri-arrow-right-line flex items"></i>
            </button>
        </a>
    </div>



    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-14 mt-14">

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

    <div class='flex flex-col items-center mt-24'>
        <h2 class='text-2xl font-semibold text-slate-800'>Our Specifications</h2>
        <a href="#" class='flex items-center gap-5 text-sm text-slate-600 mt-2'>
            <p class='max-w-lg text-center'> We offer top-tier service and convenience to ensure your shopping experience is smooth, secure and completely hassle-free.</p>
        </a>
    </div>

    <div class='grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7 gap-y-10 mt-14'>
        <div class='relative h-44 px-8 flex flex-col items-center justify-center w-full text-center border rounded-lg group bg-green-200'>
            <h3 class='text-slate-800 font-medium'>Free Shipping</h3>
            <p class='text-sm text-slate-600 mt-3'>Enjoy fast, free delivery on every order no conditions, just reliable doorstep.</p>
            <div class='absolute -top-5 text-white size-10 flex items-center justify-center rounded-md group-hover:scale-105 transition bg-green-400'>
                <i class="ri-send-plane-line"></i>
            </div>
        </div>

        <div class='relative h-44 px-8 flex flex-col items-center justify-center w-full text-center border rounded-lg group bg-orange-200'>
            <h3 class='text-slate-800 font-medium'>7 Days easy Return</h3>
            <p class='text-sm text-slate-600 mt-3'>Change your mind? No worries. Return any item within 7 days.</p>
            <div class='absolute -top-5 text-white size-10 flex items-center justify-center rounded-md group-hover:scale-105 transition bg-orange-400'>
                <i class="ri-time-line text-white"></i>
            </div>
        </div>

        <div class='relative h-44 px-8 flex flex-col items-center justify-center w-full text-center border rounded-lg group bg-purple-200'>
            <h3 class='text-slate-800 font-medium'>24/7 Customer Support</h3>
            <p class='text-sm text-slate-600 mt-3'>We're here for you. Get expert help with our customer support.</p>
            <div class='absolute -top-5 text-white size-10 flex items-center justify-center rounded-md group-hover:scale-105 transition bg-purple-400'>
                <i class="ri-customer-service-2-line text-white"></i>
            </div>
        </div>
    </div>


</div>



<?php include("includes/footer.php") ?>
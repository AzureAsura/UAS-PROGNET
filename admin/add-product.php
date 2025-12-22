<?php include('../middleware/adminMiddleware.php') ?>
<?php include('functions/adminFunctions.php') ?>
<?php include('template/header.php') ?>
<?php include('template/sidebar.php') ?>


<main class=" p-8 md:pt-8 pt-24 flex-1 ">

    <h1 class="text-3xl font-bold text-[#3C3F58] mb-6">Add Product</h1>

    <form action="code.php" method="POST" enctype="multipart/form-data"
        class="bg-white shadow-lg rounded-xl p-6 space-y-6">

        <!-- NAME -->
        <div class="flex flex-col gap-1">
            <label class="font-medium text-gray-700">Name</label>
            <input type="text" name="nama_produk" placeholder="Enter Product Name" required
                class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#3bba9c] focus:outline-none">
        </div>

        <!-- SLUG -->
        <div class="flex flex-col gap-1">
            <label class="font-medium text-gray-700">Slug</label>
            <input type="text" name="slug" placeholder="Enter Product Slug" required
                class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#3bba9c] focus:outline-none">
        </div>

        <!-- HEADLINE -->
        <div class="flex flex-col gap-1">
            <label class="font-medium text-gray-700">Headline</label>
            <textarea rows="3" name="headline" placeholder="Enter Headline" required
                class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#3bba9c] focus:outline-none"></textarea>
        </div>

        <!-- DESCRIPTION -->
        <div class="flex flex-col gap-1">
            <label class="font-medium text-gray-700">Description</label>
            <textarea rows="3" name="deskripsi" placeholder="Enter Product Description" required
                class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#3bba9c] focus:outline-none"></textarea>
        </div>

        <!-- ORIGINAL PRICE -->
        <div class="flex flex-col gap-1">
            <label class="font-medium text-gray-700">Original Price</label>
            <input type="text" name="harga_asli" placeholder="Enter Original Price" required
                class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#3bba9c] focus:outline-none">
        </div>

        <!-- SELLING PRICE -->
        <div class="flex flex-col gap-1">
            <label class="font-medium text-gray-700">Selling Price</label>
            <input type="text" name="harga_jual" placeholder="Masukkan Harga Jual" required
                class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#3bba9c] focus:outline-none">
        </div>

        <!-- IMAGE -->
        <div class="flex flex-col gap-1">
            <label class="font-medium text-gray-700">Upload Image</label>
            <input type="file" name="gambar[]" required
                class="border border-gray-300 rounded-lg px-3 py-2 bg-white" multiple>
        </div>

        <!-- CATEGORY -->
        <div class="flex flex-col gap-1">
            <label class="font-medium text-gray-700">Select Category</label>
            <select name="id_kategori" required
                class="border border-gray-300 rounded-lg px-3 py-2 bg-white focus:ring-2 focus:ring-[#3bba9c] focus:outline-none">
                <option value="">Select Category</option>
                <?php
                $categories = getAll("tb_kategori");

                if (mysqli_num_rows($categories) > 0) {
                    foreach ($categories as $item) {
                ?>
                        <option value="<?= $item['id_kategori'] ?>"><?= $item['nama_kategori'] ?></option>
                <?php
                    }
                } else {
                    echo "<option>No category available</option>";
                }
                ?>
            </select>
        </div>

        <!-- QUANTITY -->
        <div class="flex flex-col gap-1">
            <label class="font-medium text-gray-700">Quantity</label>
            <input type="text" name="qty" placeholder="Enter quantity" required
                class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#3bba9c] focus:outline-none">
        </div>

        <!-- STATUS -->
        <div class="flex items-center gap-3">
            <input type="checkbox" name="status"
                class="w-5 h-5 text-[#3bba9c] border-gray-300 rounded focus:ring-2 focus:ring-[#3bba9c]">
            <label class="font-medium text-gray-700">Empty</label>
        </div>

        <!-- POPULAR -->
        <div class="flex items-center gap-3">
            <input type="checkbox" name="popularitas"
                class="w-5 h-5 text-[#3bba9c] border-gray-300 rounded focus:ring-2 focus:ring-[#3bba9c]">
            <label class="font-medium text-gray-700">Popular</label>
        </div>


        <!-- META TITLE -->
        <div class="flex flex-col gap-1">
            <label class="font-medium text-gray-700">Meta Title</label>
            <input type="text" name="meta_title" placeholder="Enter Meta Title" required
                class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#3bba9c] focus:outline-none">
        </div>

        <!-- META DESCRIPTION -->
        <div class="flex flex-col gap-1">
            <label class="font-medium text-gray-700">Meta Description</label>
            <textarea rows="3" name="meta_description" placeholder="Enter Meta Description" required
                class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#3bba9c] focus:outline-none"></textarea>
        </div>

        <!-- META KEYWORDS -->
        <div class="flex flex-col gap-1">
            <label class="font-medium text-gray-700">Meta Keywords</label>
            <input type="text" name="meta_keywords" placeholder="Enter Meta Keywords" required
                class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#3bba9c] focus:outline-none">
        </div>

        <!-- SUBMIT BUTTON -->
        <button type="submit"
            name="add_product_btn"
            class="w-full bg-[#3bba9c] text-black font-semibold py-3 rounded-lg hover:bg-[#34a489] transition">
            Submit Products
        </button>

    </form>

</main>

<?php include('template/footer.php') ?>
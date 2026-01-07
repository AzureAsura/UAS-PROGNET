<?php include('../middleware/adminMiddleware.php') ?>
<?php include('functions/adminFunctions.php') ?>
<?php include('template/header.php') ?>
<?php include('template/sidebar.php') ?>


<main class="w-full min-h-screen p-3 sm:p-6 lg:p-8 pt-20 sm:pt-24 md:pt-8">
    <div class="w-full max-w-4xl mx-auto">
        
        <div class="mb-4 sm:mb-6">
            <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mb-1">Add Product</h1>
            <p class="text-xs sm:text-sm text-gray-500">Isi form di bawah untuk menambahkan produk baru</p>
        </div>

        <form action="code.php" method="POST" enctype="multipart/form-data" 
              class="w-full bg-white border border-gray-200 rounded-lg p-3 sm:p-5 md:p-6 space-y-4 sm:space-y-5">

            <div class="w-full">
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-1.5">Product Name</label>
                <input type="text" name="nama_produk" placeholder="Enter product name" required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 sm:py-2.5 text-xs sm:text-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
            </div>

            <div class="w-full">
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-1.5">Slug</label>
                <input type="text" name="slug" placeholder="product-slug" required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 sm:py-2.5 text-xs sm:text-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
            </div>

            <div class="w-full">
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-1.5">Headline</label>
                <textarea rows="2" name="headline" placeholder="Short product headline..." required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 sm:py-2.5 text-xs sm:text-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition resize-none"></textarea>
            </div>

            <div class="w-full">
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-1.5">Description</label>
                <textarea rows="4" name="deskripsi" placeholder="Full product description..." required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 sm:py-2.5 text-xs sm:text-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition resize-none"></textarea>
            </div>

            <div class="w-full grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-5">
                <div class="w-full">
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-1.5">Original Price</label>
                    <input type="text" name="harga_asli" placeholder="100000" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 sm:py-2.5 text-xs sm:text-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                </div>

                <div class="w-full">
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-1.5">Selling Price</label>
                    <input type="text" name="harga_jual" placeholder="80000" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 sm:py-2.5 text-xs sm:text-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                </div>

                <div class="w-full">
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-1.5">Quantity</label>
                    <input type="text" name="qty" placeholder="50" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 sm:py-2.5 text-xs sm:text-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                </div>
            </div>

           <div class="w-full">
            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-1.5">Category</label>
            <select name="kategori_id" required class="w-full border border-gray-300 rounded-md px-3 py-2 sm:py-2.5 text-xs sm:text-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
            <option value="">Select Category</option>
            <?php
            try {
                require_once 'app/Model/category_model.php';
                require_once 'config/db-config.php';
                
                $db = Database::getInstance()->getConnection();
                
                if (!$db) {
                    echo '<option value="">Database connection failed</option>';
                } else {
                    $categoryModel = new CategoryModel($db);
                    $categoriesResult = $categoryModel->getAll();
                    
                    if (!$categoriesResult) {
                        echo '<option value="">Query failed: ' . mysqli_error($db) . '</option>';
                    } else {
                        $count = 0;
                        while ($category = mysqli_fetch_assoc($categoriesResult)) {
                            $count++;
                            echo '<option value="' . $category['id_kategori'] . '">' 
                                . htmlspecialchars($category['nama_kategori']) 
                                . '</option>';
                        }
                        
                        if ($count == 0) {
                            echo '<option value="">No categories found in database</option>';
                        }
                    }
                }
            } catch (Exception $e) {
                echo '<option value="">Error: ' . $e->getMessage() . '</option>';
            }
            ?>
            </select>
        </div>

            <div class="w-full">
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-1.5">Upload Image</label>
                <input type="file" name="gambar" accept="image/*" required
                    class="w-full border border-gray-300 rounded-md px-2 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm file:mr-2 sm:file:mr-3 file:py-1 sm:file:py-1.5 file:px-2 sm:file:px-3 file:rounded file:border-0 file:text-xs sm:file:text-sm file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 transition">
            </div>

            <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5">
                <div class="w-full">
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-1.5">Meta Title</label>
                    <input type="text" name="meta_title" placeholder="SEO Title" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 sm:py-2.5 text-xs sm:text-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                </div>

                <div class="w-full">
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-1.5">Meta Keywords</label>
                    <input type="text" name="meta_keywords" placeholder="keyword1, keyword2" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 sm:py-2.5 text-xs sm:text-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                </div>
            </div>

            <div class="w-full">
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-1.5">Meta Description</label>
                <textarea rows="2" name="meta_description" placeholder="SEO description..." required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 sm:py-2.5 text-xs sm:text-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition resize-none"></textarea>
            </div>

            <div class="w-full flex flex-col sm:flex-row gap-3 sm:gap-4 pt-2">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="status" class="w-4 h-4 border-gray-300 rounded text-blue-600 focus:ring-1 focus:ring-blue-500">
                    <span class="text-xs sm:text-sm text-gray-700">Empty</span>
                </label>

                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="popularitas" class="w-4 h-4 border-gray-300 rounded text-blue-600 focus:ring-1 focus:ring-blue-500">
                    <span class="text-xs sm:text-sm text-gray-700">Popular</span>
                </label>
            </div>

            <div class="w-full border-t border-gray-200 pt-4 sm:pt-5 mt-4 sm:mt-6">
                <button type="submit" name="add_product_btn"
                    class="w-full sm:w-auto px-5 sm:px-6 py-2 sm:py-2.5 bg-blue-600 text-white text-xs sm:text-sm font-medium rounded-md hover:bg-blue-700 transition">
                    Submit Product
                </button>
            </div>

        </form>
    </div>
</main>

<?php include('template/footer.php') ?>
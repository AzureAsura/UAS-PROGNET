<?php include('../middleware/adminMiddleware.php') ?>
<?php include('template/header.php') ?>
<?php include('template/sidebar.php') ?>


<main class=" p-8 md:pt-8 pt-24 flex-1 "> 

  <h1 class="text-3xl font-bold text-[#3C3F58] mb-6">Add Category</h1>

  <form action="code.php" method="POST" enctype="multipart/form-data"
        class="bg-white shadow-lg rounded-xl p-6 space-y-6">

    <!-- NAME -->
    <div class="flex flex-col gap-1">
        <label class="font-medium text-gray-700">Name</label>
        <input type="text" name="nama_kategori" placeholder="Enter Category Name"
            class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#3bba9c] focus:outline-none">
    </div>

    <!-- SLUG -->
    <div class="flex flex-col gap-1">
        <label class="font-medium text-gray-700">Slug</label>
        <input type="text" name="slug" placeholder="Enter Category Slug"
            class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#3bba9c] focus:outline-none">
    </div>

    <!-- DESCRIPTION -->
    <div class="flex flex-col gap-1">
        <label class="font-medium text-gray-700">Description</label>
        <textarea rows="3" name="deskripsi" placeholder="Enter Category Description"
            class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#3bba9c] focus:outline-none"></textarea>
    </div>

    <!-- IMAGE -->
    <div class="flex flex-col gap-1">
        <label class="font-medium text-gray-700">Upload Image</label>
        <input type="file" name="gambar"
            class="border border-gray-300 rounded-lg px-3 py-2 bg-white">
    </div>

    <!-- META TITLE -->
    <div class="flex flex-col gap-1">
        <label class="font-medium text-gray-700">Meta Title</label>
        <input type="text" name="meta_title" placeholder="Enter Meta Title"
            class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#3bba9c] focus:outline-none">
    </div>

    <!-- META DESCRIPTION -->
    <div class="flex flex-col gap-1">
        <label class="font-medium text-gray-700">Meta Description</label>
        <textarea rows="3" name="meta_description" placeholder="Enter Meta Description"
            class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#3bba9c] focus:outline-none"></textarea>
    </div>

    <!-- META KEYWORDS -->
    <div class="flex flex-col gap-1">
        <label class="font-medium text-gray-700">Meta Keywords</label>
        <input type="text" name="meta_keywords" placeholder="Enter Meta Keywords"
            class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#3bba9c] focus:outline-none">
    </div>

    <!-- STATUS -->
    <div class="flex items-center gap-3">
        <input type="checkbox" name="status"
            class="w-5 h-5 text-[#3bba9c] rounded">
        <label class="font-medium text-gray-700">Empty</label>
    </div>

    <!-- POPULAR -->
    <div class="flex items-center gap-3">
        <input type="checkbox" name="popularitas"
            class="w-5 h-5 text-[#3bba9c] rounded">
        <label class="font-medium text-gray-700">Popular</label>
    </div>

    <!-- SUBMIT BUTTON -->
    <button type="submit"
        name="add_category_btn"
        class="w-full bg-[#3bba9c] text-black font-semibold py-3 rounded-lg hover:bg-[#34a489] transition">
        Submit Category
    </button>

  </form>

</main>

<?php include('template/footer.php') ?>

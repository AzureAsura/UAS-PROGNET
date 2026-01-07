<?php include('../middleware/adminMiddleware.php') ?>
<?php include('functions/adminFunctions.php') ?>
<?php include('template/header.php') ?>
<?php include('template/sidebar.php') ?>

<main class="p-4 md:p-8 md:pt-8 pt-20 flex-1 min-h-screen">

  <div class="mx-auto">
    
    <!-- Header -->
    <div class="mb-6">
      <h1 class="text-2xl md:text-3xl font-bold text-slate-800">Edit Kategori</h1>
      <p class="text-slate-600 text-sm mt-1">Perbarui informasi kategori produk</p>
    </div>

    <?php
    if (isset($_GET['id'])) {

        $id = $_GET['id'];
        $category = getById("tb_kategori", $id, "id_kategori");

        if (mysqli_num_rows($category) > 0 ) {
            $data = mysqli_fetch_array($category);
            ?>
            
            <!-- Form Card -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200">
              <form action="proses/proses-category.php" method="POST" enctype="multipart/form-data" class="p-4 md:p-6">

                <input type="hidden" name="category_id" value="<?= $data['id_kategori'] ?>">

                <div class="space-y-5">
                  
                  <!-- Basic Information Section -->
                  <div class="pb-4 border-b border-slate-200">
                    <h2 class="text-lg font-semibold text-slate-800 mb-4">Informasi Dasar</h2>
                    
                    <div class="space-y-4">
                      <!-- NAME -->
                      <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">
                          Nama Kategori <span class="text-red-500">*</span>
                        </label>
                        <input 
                          type="text" 
                          name="nama_kategori" 
                          value="<?= $data['nama_kategori'] ?>"
                          placeholder="Contoh: Elektronik, Fashion, Rumah & Taman"
                          class="w-full border border-slate-300 rounded-lg px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-slate-400 focus:border-transparent outline-none transition"
                          required
                        >
                      </div>

                      <!-- SLUG -->
                      <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">
                          Slug <span class="text-red-500">*</span>
                        </label>
                        <input 
                          type="text" 
                          name="slug" 
                          value="<?= $data['slug'] ?>"
                          placeholder="Contoh: elektronik, fashion, rumah-taman"
                          class="w-full border border-slate-300 rounded-lg px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-slate-400 focus:border-transparent outline-none transition"
                          required
                        >
                        <p class="text-xs text-slate-500 mt-1">Versi URL-friendly (huruf kecil, tanpa spasi)</p>
                      </div>

                      <!-- DESCRIPTION -->
                      <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Deskripsi</label>
                        <textarea 
                          rows="3" 
                          name="deskripsi" 
                          placeholder="Deskripsi singkat kategori ini..."
                          class="w-full border border-slate-300 rounded-lg px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-slate-400 focus:border-transparent outline-none transition resize-none"
                        ><?= $data['deskripsi'] ?></textarea>
                      </div>

                      <!-- IMAGE -->
                      <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Gambar Kategori</label>
                        
                        <!-- Current Image Preview -->
                        <?php if (!empty($data['gambar'])): ?>
                        <div class="mb-3 p-3 bg-slate-50 rounded-lg border border-slate-200">
                          <p class="text-xs font-medium text-slate-600 mb-2">Gambar Saat Ini:</p>
                          <img 
                            src="../uploads/<?= $data['gambar'] ?>" 
                            alt="Current category image" 
                            class="w-full max-w-xs rounded-lg shadow-sm border border-slate-200"
                          >
                        </div>
                        <?php endif; ?>

                        <input 
                          type="file" 
                          name="gambar"
                          accept="image/*"
                          class="w-full border border-slate-300 rounded-lg px-3.5 py-2.5 text-sm bg-white file:mr-4 file:py-1.5 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 cursor-pointer"
                        >
                        <input type="hidden" name="old_image" value="<?= $data['gambar'] ?>">
                        <p class="text-xs text-slate-500 mt-1">Kosongkan jika tidak ingin mengubah gambar. Rekomendasi: 500x500px, maks 2MB</p>
                      </div>
                    </div>
                  </div>

                  <!-- SEO Section -->
                  <div class="pb-4 border-b border-slate-200">
                    <h2 class="text-lg font-semibold text-slate-800 mb-4">Pengaturan SEO</h2>
                    
                    <div class="space-y-4">
                      <!-- META TITLE -->
                      <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Meta Title</label>
                        <input 
                          type="text" 
                          name="meta_title" 
                          value="<?= $data['meta_title'] ?>"
                          placeholder="Judul SEO untuk mesin pencari"
                          class="w-full border border-slate-300 rounded-lg px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-slate-400 focus:border-transparent outline-none transition"
                        >
                      </div>

                      <!-- META DESCRIPTION -->
                      <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Meta Description</label>
                        <textarea 
                          rows="2" 
                          name="meta_description" 
                          placeholder="Deskripsi singkat untuk hasil pencarian"
                          class="w-full border border-slate-300 rounded-lg px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-slate-400 focus:border-transparent outline-none transition resize-none"
                        ><?= $data['meta_description'] ?></textarea>
                        <p class="text-xs text-slate-500 mt-1">Rekomendasi: 150-160 karakter</p>
                      </div>

                      <!-- META KEYWORDS -->
                      <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Meta Keywords</label>
                        <input 
                          type="text" 
                          name="meta_keywords" 
                          value="<?= $data['meta_keywords'] ?>"
                          placeholder="kata-kunci1, kata-kunci2, kata-kunci3"
                          class="w-full border border-slate-300 rounded-lg px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-slate-400 focus:border-transparent outline-none transition"
                        >
                        <p class="text-xs text-slate-500 mt-1">Pisahkan kata kunci dengan koma</p>
                      </div>
                    </div>
                  </div>

                  <!-- Settings Section -->
                  <div>
                    <h2 class="text-lg font-semibold text-slate-800 mb-4">Pengaturan</h2>
                    
                    <div class="space-y-3">
                      <!-- STATUS -->
                      <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-lg border border-slate-200">
                        <input 
                          type="checkbox" 
                          name="status"
                          id="status"
                          <?= $data['status'] ? "checked":"" ?>
                          class="w-4 h-4 text-slate-600 rounded border-slate-300 focus:ring-2 focus:ring-slate-400 cursor-pointer"
                        >
                        <label for="status" class="text-sm font-medium text-slate-700 cursor-pointer flex-1">
                          Status Kosong
                          <span class="block text-xs text-slate-500 font-normal mt-0.5">Tandai kategori ini sebagai kosong</span>
                        </label>
                      </div>

                      <!-- POPULAR -->
                      <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-lg border border-slate-200">
                        <input 
                          type="checkbox" 
                          name="popularitas"
                          id="popularitas"
                          <?= $data['popularitas'] ? "checked":"" ?>
                          class="w-4 h-4 text-slate-600 rounded border-slate-300 focus:ring-2 focus:ring-slate-400 cursor-pointer"
                        >
                        <label for="popularitas" class="text-sm font-medium text-slate-700 cursor-pointer flex-1">
                          Kategori Populer
                          <span class="block text-xs text-slate-500 font-normal mt-0.5">Tampilkan di bagian kategori populer</span>
                        </label>
                      </div>
                    </div>
                  </div>

                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col-reverse sm:flex-row gap-3 mt-6 pt-6 border-t border-slate-200">
                  <button 
                    type="button"
                    onclick="window.history.back()"
                    class="w-full sm:w-auto px-6 py-2.5 border border-slate-300 text-slate-700 font-medium text-sm rounded-lg hover:bg-slate-50 transition"
                  >
                    Batal
                  </button>
                  <button 
                    type="submit"
                    name="update_category_btn"
                    class="w-full sm:flex-1 bg-slate-800 text-white font-medium py-2.5 px-6 text-sm rounded-lg hover:bg-slate-700 transition shadow-sm"
                  >
                    Perbarui Kategori
                  </button>
                </div>

              </form>
            </div>

            <?php
        } else {
            ?>
            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
              <p class="text-red-800 text-sm font-medium">Kategori tidak ditemukan</p>
            </div>
            <?php
        }

    } else {
        ?>
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
          <p class="text-yellow-800 text-sm font-medium">ID kategori tidak ada di URL</p>
        </div>
        <?php
    }
    ?>

  </div>

</main>

<?php include('template/footer.php') ?>
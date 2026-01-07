<?php include('../middleware/adminMiddleware.php') ?>
<?php include('template/header.php');?>
<?php include('functions/adminFunctions.php') ?>

<!-- SIDEBAR -->
<?php include('template/sidebar.php')?>

<!-- CONTENT -->
<main class="flex-1 p-4 md:p-8 md:pt-8 pt-20 bg-slate-100 min-h-screen">

    <div class=" mx-auto">
        
        <!-- Header Section -->
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-slate-800">Daftar Kategori</h1>
                <p class="text-slate-600 text-sm mt-1">Kelola semua kategori produk</p>
            </div>
            <a 
                href="add-category.php" 
                class="inline-flex items-center justify-center px-5 py-2.5 bg-slate-800 text-white text-sm font-medium rounded-lg hover:bg-slate-700 transition shadow-sm"
            >
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Kategori
            </a>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
            
            <!-- Table Wrapper for Responsive -->
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead class="bg-slate-800 border-b border-slate-700">
                        <tr>
                            <th class="px-4 md:px-6 py-3 font-semibold text-white text-xs md:text-sm">ID</th>
                            <th class="px-4 md:px-6 py-3 font-semibold text-white text-xs md:text-sm">Nama</th>
                            <th class="px-4 md:px-6 py-3 font-semibold text-white text-xs md:text-sm">Gambar</th>
                            <th class="px-4 md:px-6 py-3 font-semibold text-white text-xs md:text-sm">Status</th>
                            <th class="px-4 md:px-6 py-3 font-semibold text-white text-xs md:text-sm text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-200">
                        <?php
                            $category = getAll("tb_kategori");

                            if(mysqli_num_rows($category) > 0){
                                foreach ($category as $item) {
                        ?>
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-4 md:px-6 py-4 text-slate-700 font-medium"><?= $item['id_kategori']; ?></td>
                                <td class="px-4 md:px-6 py-4 text-slate-800 font-medium"><?= $item['nama_kategori']; ?></td>
                                
                                <td class="px-4 md:px-6 py-4">
                                    <img 
                                        src="../uploads/<?= $item['gambar']; ?>" 
                                        alt="<?= $item['nama_kategori']; ?>" 
                                        class="h-12 w-12 object-cover rounded-lg shadow-sm border border-slate-200"
                                    >
                                </td>

                                <td class="px-4 md:px-6 py-4">
                                    <?php if($item['status'] == '0'): ?>
                                        <span class="inline-flex items-center px-2.5 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">
                                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span>
                                            Terlihat
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-2.5 py-1 bg-red-100 text-red-700 text-xs font-medium rounded-full">
                                            <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1.5"></span>
                                            Tersembunyi
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <td class="px-4 md:px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- Edit Button -->
                                        <a 
                                            href="edit-category.php?id=<?= $item['id_kategori']; ?>" 
                                            class="inline-flex items-center px-3 py-1.5 bg-blue-100 text-blue-700 text-xs font-medium rounded-lg hover:bg-blue-200 transition"
                                            title="Edit"
                                        >
                                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            <span class="hidden sm:inline">Edit</span>
                                        </a>

                                        <!-- Delete Button -->
                                        <form action="proses/proses-category.php" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                                            <input type="hidden" name="category_id" value="<?= $item['id_kategori']; ?>">
                                            <button 
                                                type="submit" 
                                                name="delete_category_btn"
                                                class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 text-xs font-medium rounded-lg hover:bg-red-200 transition"
                                                title="Hapus"
                                            >
                                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                <span class="hidden sm:inline">Hapus</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php
                                }
                            } else {
                        ?>
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-slate-500">
                                        <svg class="w-16 h-16 mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                        </svg>
                                        <p class="text-sm font-medium">Tidak ada data kategori</p>
                                        <p class="text-xs mt-1">Mulai dengan menambahkan kategori baru</p>
                                        <a 
                                            href="add-category.php" 
                                            class="mt-4 inline-flex items-center px-4 py-2 bg-slate-800 text-white text-xs font-medium rounded-lg hover:bg-slate-700 transition"
                                        >
                                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                            </svg>
                                            Tambah Kategori
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Footer Info (Optional) -->
            <?php if(mysqli_num_rows($category) > 0): ?>
            <div class="px-6 py-3 bg-slate-50 border-t border-slate-200">
                <p class="text-xs text-slate-600">
                    Total: <span class="font-semibold"><?= mysqli_num_rows($category); ?></span> kategori
                </p>
            </div>
            <?php endif; ?>

        </div>

    </div>

</main>

<?php include('template/footer.php')?>
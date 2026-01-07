<?php include('../middleware/adminMiddleware.php') ?>
<?php include('template/header.php');?>
<?php include('functions/adminFunctions.php') ?>




    <!-- SIDEBAR -->
    <?php include('template/sidebar.php')?>

    <!-- CONTENT -->
 <style>
.badge-green {
  padding: 4px 10px;
  background-color: #dcfce7;
  color: #15803d;
  font-size: 12px;
  border-radius: 9999px;
  font-weight: 500;
}

.badge-red {
  padding: 4px 10px;
  background-color: #fee2e2;
  color: #b91c1c;
  font-size: 12px;
  border-radius: 9999px;
  font-weight: 500;
}
</style>


<!-- CONTENT -->
<main class="flex-1 p-4 sm:p-6 md:p-8 md:pt-8 pt-24">

  <h4 class="text-2xl font-bold text-[#3C3F58] mb-6">Products</h4>

  <!-- DESKTOP TABLE (md+) -->
  <div class="hidden md:block bg-white rounded-xl shadow overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full text-left text-sm">
        <thead class="bg-black">
          <tr>
            <th class="px-6 py-3 text-white">ID</th>
            <th class="px-6 py-3 text-white">Name</th>
            <th class="px-6 py-3 text-white">Image</th>
            <th class="px-6 py-3 text-white">Status</th>
            <th class="px-6 py-3 text-white">Edit</th>
            <th class="px-6 py-3 text-white">Delete</th>
          </tr>
        </thead>

        <tbody>
          <?php 
          $products = getAll("tb_produk");
          if(mysqli_num_rows($products) > 0): ?>
            <?php foreach($products as $item): ?>
            <tr class="border-b hover:bg-gray-50 transition">
              <td class="px-6 py-4"><?= $item['id_produk']; ?></td>
              <td class="px-6 py-4 font-medium"><?= $item['nama_produk']; ?></td>

              <td class="px-6 py-4">
                <img src="../uploads/<?= $item['gambar']; ?>"
                  alt="<?= $item['nama_produk']; ?>"
                  class="h-12 w-12 object-cover rounded-md shadow">
              </td>

              <td class="px-6 py-4">
                <?php if($item['status'] == '0'): ?>
                  <span class="badge-green">Visible</span>
                <?php else: ?>
                  <span class="badge-red">Hidden</span>
                <?php endif; ?>
              </td>

              <td class="px-6 py-4">
                <a href="edit-products.php?id=<?= $item['id_produk']; ?>"
                  class="text-blue-600 hover:underline font-medium">
                  Edit
                </a>
              </td>

              <td class="px-6 py-4">
                <form action="code.php" method="POST">
                  <input type="hidden" name="id_produk" value="<?= $item['id_produk']; ?>">
                  <button name="delete_products_btn"
                    class="text-red-600 hover:underline font-medium">
                    Delete
                  </button>
                </form>
              </td>
            </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="6" class="text-center py-6 text-gray-500">
                No records found
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- MOBILE CARD VIEW -->
  <div class="md:hidden space-y-4">
    <?php 
    $products = getAll("tb_produk");
    if(mysqli_num_rows($products) > 0): 
    ?>
      <?php foreach($products as $item): ?>
      <div class="bg-white rounded-xl shadow p-4 flex gap-4">

        <img src="../uploads/<?= $item['gambar']; ?>"
          alt="<?= $item['nama_produk']; ?>"
          class="w-16 h-16 rounded-lg object-cover">

        <div class="flex-1">
          <h5 class="font-semibold text-gray-800">
            <?= $item['nama_produk']; ?>
          </h5>

          <p class="text-xs text-gray-500 mt-1">
            ID: <?= $item['id_produk']; ?>
          </p>

          <div class="mt-2">
            <?php if($item['status'] == '0'): ?>
              <span class="badge-green">Visible</span>
            <?php else: ?>
              <span class="badge-red">Hidden</span>
            <?php endif; ?>
          </div>

          <div class="mt-3 flex gap-4 text-sm">
            <a href="edit-products.php?id=<?= $item['id_produk']; ?>"
              class="text-blue-600 font-medium">
              Edit
            </a>

            <form action="code.php" method="POST">
              <input type="hidden" name="id_produk" value="<?= $item['id_produk']; ?>">
              <button name="delete_products_btn"
                class="text-red-600 font-medium">
                Delete
              </button>
            </form>
          </div>
        </div>

      </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="text-center text-gray-500">No records found</p>
    <?php endif; ?>
  </div>

</main>


  <?php include('template/footer.php')?>

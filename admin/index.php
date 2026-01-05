<?php include('../middleware/adminMiddleware.php'); ?>
<?php include('functions/adminFunctions.php'); ?>
<?php include('template/header.php');?>



    <!-- SIDEBAR -->
    <?php include('template/sidebar.php');
    $statistik = getStatistik();
    $revenue = 0;
    if (mysqli_num_rows($statistik) > 0) {
      foreach ($statistik as $stats) {
        $revenue += $stats['tharga'];
      }
    }
    ?>

    <!-- CONTENT -->
    <main class="flex-1 p-8 md:pt-8 pt-24">
      <h1 class="text-4xl font-bold text-[#3C3F58] mb-2">Welcome, Human</h1>
      <p class="text-[#707793] mb-8">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Officia, explicabo!
      </p>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <p class="text-sm text-gray-500 uppercase font-bold">Total Revenue</p>
            <h3 class="text-3xl font-bold text-gray-800">Rp. <?php echo number_format($revenue, 0, ',', '.'); ?></h3>
            <span class="text-green-500 text-sm">↑ 12% from last month</span>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <p class="text-sm text-gray-500 uppercase font-bold">Active Users</p>
            <h3 class="text-3xl font-bold text-gray-800">1,240</h3>
            <span class="text-green-500 text-sm">↑ 5% from last week</span>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <p class="text-sm text-gray-500 uppercase font-bold">Bounce Rate</p>
            <h3 class="text-3xl font-bold text-gray-800">32.4%</h3>
            <span class="text-red-500 text-sm">↓ 2% improvement</span>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h3 class="font-bold text-gray-800">Recent Transactions</h3>
        </div>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-sm uppercase">
                    <th class="p-4 font-medium">Customer</th>
                    <th class="p-4 font-medium">Status</th>
                    <th class="p-4 font-medium">Date</th>
                    <th class="p-4 font-medium">Amount</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
              <?php
                  $orders = getOrderOnGoing();

                  if (mysqli_num_rows($orders) > 0) {
                    foreach ($orders as $item) {
              ?>
                <tr>
                    <td class="p-4 text-gray-800"><?= $item['nama_user'] ?></td>
                    <td class="p-4"><span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs">Completed</span></td>
                    <td class="p-4 text-gray-600">Oct 24, 2023</td>
                    <td class="p-4 font-semibold">$350.00</td>
                </tr>
            <?php
                    }
                } else {
                    echo '<tr><td colspan="4" class="p-4 text-gray-800">Data Order Tidak Tersedia</td></tr>';
                }
            ?>
            </tbody>
        </table>
    </div>

    </main>



  <?php include('template/footer.php')?>

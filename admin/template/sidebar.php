<!-- SIDEBAR -->
<aside id="sidebar"
       class="fixed inset-y-0 left-0 z-50 w-72 bg-black text-white transform -translate-x-full transition-transform duration-300 ease-in-out md:sticky md:top-0 md:h-screen md:translate-x-0 md:relative md:inset-auto md:overflow-y-auto">



  <div class="flex items-center justify-between px-6 py-5 border-b border-white/10">
    <h3 class="uppercase text-xs text-gray-400">Menu</h3>
  </div>

  <!-- NAV -->
  <nav class="flex-1 overflow-y-auto px-3 py-4">
    <a href="index.php" class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
      <i class="ri-home-line text-xl"></i>
      <span>Beranda</span>
    </a>

    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 1): ?>
      <a href="add-category.php" class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
        <i class="ri-add-circle-line text-xl"></i>
        <span>Tambah kategori</span>
      </a>
      <a href="category.php" class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
        <i class="ri-list-check-2 text-xl"></i>
        <span>Kategori</span>
      </a>
      <a href="add-product.php" class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
        <i class="ri-add-box-line text-xl"></i>
        <span>Tambah produk</span>
      </a>
      <a href="products.php" class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
        <i class="ri-boxing-line text-xl"></i>
        <span>Produk</span>
      </a>
      <a href="role.php" class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
        <i class="ri-shield-user-line text-xl"></i>
        <span>User Role</span>
      </a>
      <a href="log.php" class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
        <i class="ri-file-list-line text-xl"></i>
        <span>Order Log</span>
      </a>
    <?php endif; ?>

    <?php if (isset($_SESSION['role']) && in_array($_SESSION['role'], [1, 2])): ?>
      <a href="orders.php" class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
        <i class="ri-shopping-cart-line text-xl"></i>
        <span>Pesanan</span>
      </a>
      <a href="order-on-going.php" class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
        <i class="ri-time-line text-xl"></i>
        <span>Pesanan dalam proses</span>
      </a>
      <a href="order-history.php" class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
        <i class="ri-history-line text-xl"></i>
        <span>Riwayat pesanan</span>
      </a>
    <?php endif; ?>
  </nav>

  <!-- LOGOUT -->
  <div class="border-t border-white/10 ">
    <a href="../logout.php" class="flex items-center gap-3 px-6 py-5 hover:bg-white/5 transition">
      <i class="ri-logout-box-line text-xl"></i>
      <span>Logout</span>
    </a>
  </div>
</aside>



<!-- JavaScript Toggle -->
<script>
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('sidebarOverlay');
  const openBtn = document.getElementById('openSidebar');
  const closeBtn = document.getElementById('closeSidebar');

  // Buka sidebar
  openBtn.addEventListener('click', () => {
    sidebar.classList.remove('-translate-x-full');
    overlay.classList.remove('opacity-0', 'pointer-events-none');
    overlay.classList.add('opacity-100', 'pointer-events-auto');
  });

  // Tutup sidebar (tombol X atau overlay)
  function closeSidebar() {
    sidebar.classList.add('-translate-x-full');
    overlay.classList.add('opacity-0', 'pointer-events-none');
    overlay.classList.remove('opacity-100', 'pointer-events-auto');
  }

  closeBtn.addEventListener('click', closeSidebar);
  overlay.addEventListener('click', closeSidebar);
</script>

<style>
  .nav-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 1.5rem;
    border-radius: 0.5rem;
    transition: all 0.3s;
  }
  .nav-item:hover {
    background: rgba(255,255,255,0.05);
    color: #3bba9c;
  }
  @media (min-width: 768px) {
    .nav-item:hover {
      border-right: 4px solid #3bba9c;
    }
  }
</style>
<aside id="sidebar"
  class="fixed md:sticky top-0 left-0
         w-[280px] h-screen
         bg-black text-white z-50
         flex flex-col
         transition-transform duration-300
         -translate-x-full md:translate-x-0">

  <!-- HEADER -->
  <div class="flex items-center justify-between px-6 py-5">
    <h3 class="uppercase text-xs text-gray-400">Menu</h3>

    <!-- CLOSE BUTTON (MOBILE ONLY) -->
    <button onclick="closeSidebar()" class="md:hidden">
      <i class="ri-close-line text-2xl"></i>
    </button>
  </div>

  <!-- NAV -->
  <nav class="flex-1 overflow-y-auto">
    <a href="index.php" class="nav-item">Home</a>
    <a href="add-category.php" class="nav-item">Add Category</a>
    <a href="category.php" class="nav-item">Category</a>
    <a href="add-product.php" class="nav-item">Add Product</a>
    <a href="products.php" class="nav-item">Products</a>
    <a href="orders.php" class="nav-item">Orders</a>
    <a href="order-on-going.php" class="nav-item">Order On Going</a>
    <a href="order-history.php" class="nav-item">Order History</a>
  </nav>

  <!-- LOGOUT -->
  <a href="../logout.php"
     class="px-6 py-4 border-t border-white/10 hover:bg-white/5">
     Logout
  </a>
</aside>

<style>
.nav-item {
  display: block;
  padding: 1rem 1.5rem;
  transition: 0.3s;
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

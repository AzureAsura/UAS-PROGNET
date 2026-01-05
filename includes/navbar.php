    <nav class="bg-white shadow-sm fixed w-full top-0 left-0 z-50">
        <div class="">
            <div class="flex items-center justify-between max-w-[1400px] mx-auto px-4 py-3 transition-all">

                <a href="index.php" class="relative text-4xl font-semibold text-slate-700">
                    <img src="assets/img/ALDYN.png" alt="" class="h-10">
                </a>

                <!-- {/* Desktop Menu */} -->
                <div class="hidden sm:flex items-center gap-3 lg:gap-6 text-slate-600">

                    <a href="search.php" class="relative flex items-center gap-2 text-slate-600">
                      <i class="ri-search-line text-2xl"></i>
                    </a>

                    <a href="cart.php" class="relative flex items-center gap-2 text-slate-600">
                        <i class="ri-shopping-cart-line text-2xl"></i>
                    </a>

                    <a href="profile.php" class="relative flex items-center gap-2 text-slate-600">
                        <i class="ri-user-line text-2xl"></i>
                    </a>

                    <?php
                    if (isset($_SESSION['role']) && $_SESSION['role'] == 1) {
                    ?>
                    <a href="admin/" class="relative flex items-center gap-2 text-slate-600">
                        <i class="ri-login-circle-line text-2xl"></i>
                    </a>
                    <?php } ?>

                </div>

                <!-- {/* Mobile User Button  */} -->
                <div class="sm:hidden flex items-center gap-4">

                    <a href="search.php" class="relative flex items-center gap-2 text-slate-600">
                      <i class="ri-search-line"></i>
                    </a>

                    <a href="cart.php" class="relative flex items-center gap-2 text-slate-600">
                        <i class="ri-shopping-cart-line text-xl"></i>
                    </a>

                    <a href="profile.php" class="relative flex items-center gap-2 text-slate-600">
                        <i class="ri-user-line text-xl"></i>
                    </a>
                    <?php
                    if (isset($_SESSION['role']) && $_SESSION['role'] == 1) {
                    ?>
                    <a href="admin/" class="relative flex items-center gap-2 text-slate-600">
                        <i class="ri-login-circle-line text-xl"></i>
                    </a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <hr class="border-gray-300" />
    </nav>









<script>
  const toggle = document.getElementById("nav-toggle");
  const menu = document.getElementById("mobile-menu");

  toggle.addEventListener("click", () => {
    menu.classList.toggle("hidden");
  });
</script>
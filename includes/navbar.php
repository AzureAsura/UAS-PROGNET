    <nav class="bg-white shadow-sm fixed w-full top-0 left-0 z-50">
        <div class="">
            <div class="flex items-center justify-between max-w-[1400px] mx-auto px-4 py-3 transition-all">

                <a href="index.php" class="relative text-4xl font-semibold text-slate-700">
                    <img src="assets/img/ALDYN.png" alt="" class="h-10">
                </a>

                <!-- {/* Desktop Menu */} -->
                <div class="hidden sm:flex items-center gap-3 lg:gap-6 text-slate-600">

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







<!-- 
<nav class="bg-white shadow-md fixed w-full top-0 left-0 z-50">
  <div class="max-w-[1400px] mx-auto px-4 py-3 flex justify-between items-center">
    Logo
    <a href="index.php">
      <h1 class="text-xl font-bold text-gray-800">Aldyné</h1>
    </a>

    Desktop Menu
    <ul class="hidden md:flex gap-6 text-gray-700 font-medium">
      <li><a href="index.php" class="hover:text-blue-600">Home</a></li>

      If Login Return Logout Button
      <?php
      if (isset($_SESSION['auth'])) {
      ?>
        <li><a href="cart.php" class="hover:text-blue-600">Cart</a></li>
        <li><a href="logout.php" class="hover:text-blue-600">Logout</a></li>
        <li><a href="profile.php" class="hover:text-blue-600">
            <?= $_SESSION['auth_user']['nama_user']; ?>
          </a></li>
      <?php
      } else {
      ?>
        <li><a href="register.php" class="hover:text-blue-600">Register</a></li>
        <li><a href="login.php" class="hover:text-blue-600">Login</a></li>
      <?php
      }
      ?>
    </ul>

    Hamburger Button
    <button id="nav-toggle" class="md:hidden focus:outline-none">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M4 6h16M4 12h16M4 18h16" />
      </svg>
    </button>
  </div>

  Mobile Menu
  <ul id="mobile-menu" class="md:hidden hidden flex-col bg-white px-4 pb-4 shadow-md">
    <li><a href="index.php" class="block py-2 text-gray-700 hover:text-blue-600">Home</a></li>

    <?php
    if (isset($_SESSION['auth'])) {
    ?>
      <li><a href="cart.php" class="block py-2 text-gray-700 hover:text-blue-600">Cart</a></li>
      <li><a href="logout.php" class="block py-2 text-gray-700 hover:text-blue-600">Logout</a></li>
    <?php
    } else {
    ?>
      <li><a href="register.php" class="block py-2 text-gray-700 hover:text-blue-600">Register</a></li>
      <li><a href="login.php" class="block py-2 text-gray-700 hover:text-blue-600">Login</a></li>
    <?php
    }
    ?>
  </ul>
</nav> -->

<script>
  const toggle = document.getElementById("nav-toggle");
  const menu = document.getElementById("mobile-menu");

  toggle.addEventListener("click", () => {
    menu.classList.toggle("hidden");
  });
</script>
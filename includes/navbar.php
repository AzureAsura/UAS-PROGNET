<?php

require_once 'config/class-cart.php';   


$cart = new Cart(); 

$cartCount = 0;

if (isset($_SESSION['auth_user']) && !empty($_SESSION['auth_user'])) {
    $userId = $_SESSION['auth_user']['id_user'];         
    $cartCount = $cart->getCartCount($userId);
}
?>

<nav class="bg-white shadow-sm fixed w-full top-0 left-0 z-50">
    <div class="">
        <div class="flex items-center justify-between max-w-[1400px] mx-auto px-4 py-3 transition-all">

            <a href="index.php" class="relative text-4xl font-semibold text-slate-700">
                <img src="assets/img/ALDYN.png" alt="" class="h-10">
            </a>

            <div class="hidden sm:flex items-center gap-3 lg:gap-6 text-slate-600">

                <a href="search.php" class="relative flex items-center gap-2 text-slate-600">
                    <i class="ri-search-line text-2xl"></i>
                </a>

                <a href="cart.php" class="relative flex items-center gap-2 text-slate-600 hover:text-blue-600 transition">
                    <div id="cart-badge-container" class="relative">
                        <i class="ri-shopping-cart-line text-2xl"></i>
                        <?php if ($cartCount > 0): ?>
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                            <?= $cartCount > 99 ? '99+' : $cartCount ?>
                        </span>
                        <?php endif; ?>
                    </div>
                </a>

                <a href="profile.php" class="relative flex items-center gap-2 text-slate-600">
                    <i class="ri-user-line text-2xl"></i>
                </a>

                <?php if (isset($_SESSION['role']) && in_array($_SESSION['role'], [1, 2])): ?>
                <a href="admin/" class="relative flex items-center gap-2 text-slate-600">
                    <i class="ri-login-circle-line text-2xl"></i>
                </a>
                <?php endif; ?>

            </div>

            <!-- Mobile Menu -->
            <div class="sm:hidden flex items-center gap-4">

                <a href="search.php" class="relative flex items-center gap-2 text-slate-600">
                    <i class="ri-search-line"></i>
                </a>

                <!-- Cart mobile dengan badge -->
                <a href="cart.php" class="relative flex items-center gap-2 text-slate-600 hover:text-blue-600 transition">
                    <div  class="relative">
                        <i class="ri-shopping-cart-line text-xl"></i>
                        <?php if ($cartCount > 0): ?>
                        <span class="absolute -top-1 -right-2 bg-red-500 text-white text-[10px] font-bold rounded-full h-4 w-4 flex items-center justify-center">
                            <?= $cartCount > 99 ? '99+' : $cartCount ?>
                        </span>
                        <?php endif; ?>
                    </div>
                </a>

                <a href="profile.php" class="relative flex items-center gap-2 text-slate-600">
                    <i class="ri-user-line text-xl"></i>
                </a>

                <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 1): ?>
                <a href="admin/" class="relative flex items-center gap-2 text-slate-600">
                    <i class="ri-login-circle-line text-xl"></i>
                </a>
                <?php endif; ?>

            </div>
        </div>
    </div>
    <hr class="border-gray-300" />
</nav>
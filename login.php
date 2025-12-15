<?php 

session_start();

if (isset($_SESSION['auth'])) {
    $_SESSION['message'] = "You are already Logged In";
    header('Location: index.php');
    exit();
}

include("includes/header.php") 

?>

<div class="min-h-screen flex flex-col items-center justify-center bg-gray-100">


    <?php if (isset($_SESSION['message'])): ?>
        <div class="w-full max-w-sm mb-4">
            <div class="flex items-center justify-between bg-red-100 text-red-700 px-4 py-3 rounded-lg shadow">
                <div class="flex items-center gap-2">
                    
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.12 0 2.042-.993 1.815-2.09L13.815 4.09A2 2 0 0011.184 4.09L4.268 16.91C4.04 18.007 4.963 19 6.083 19z" />
                    </svg>

                    <span class="text-sm font-medium">
                        <?= $_SESSION['message'] ?>
                    </span>

                </div>

                <button onclick="this.parentElement.parentElement.remove()" class="text-red-600 hover:text-red-800">✕</button>
            </div>
        </div>
    <?php 
        unset($_SESSION['message']);
    endif; 
    ?>


  <form class="bg-white p-6 rounded-lg shadow-md w-full max-w-sm space-y-4" action="functions/authcode.php" method="POST">
    <h2 class="text-2xl font-bold text-gray-800 text-center">Login</h2>

    <!-- Email -->
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
      <input 
        type="email" 
        class="w-full px-3 py-2 rounded-md border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300 outline-none"
        placeholder="Enter your email"
        required
        name="email"
      >
    </div>

    <!-- Password -->
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
      <input 
        type="password" 
        class="w-full px-3 py-2 rounded-md border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-300 outline-none"
        placeholder="Enter your password"
        required
        name="password"
      >
    <!-- Submit -->
    <button 
      type="submit"
      class="w-full py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 transition"
      name="login_btn"
    >
      Login
    </button>
  </form>
        <div class="text-center text-sm text-gray-600 mt-4">
        <p>Belum punya akun? 
            <a href="register.php" class="text-blue-600 hover:text-blue-800 font-medium underline">
                Daftar sekarang
            </a>
        </p>
    </div>
</div>



<?php include("includes/footer.php") ?>



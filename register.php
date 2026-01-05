<?php 

session_start();

if (isset($_SESSION['auth'])) {
    $_SESSION['message'] = "You are already Logged In";
    header('Location: index.php');
    exit();
}

include("includes/header.php") 
?>

<div class="mt-28 flex items-center justify-center px-4">

  <div class="w-full max-w-5xl bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden grid grid-cols-1 md:grid-cols-2">

    <!-- LEFT : FORM -->
    <div class="p-8 md:p-12">

      <h2 class="text-3xl font-semibold text-gray-900 mb-2">
        Create account
      </h2>
      <p class="text-sm text-gray-500 mb-8">
        Register to get started
      </p>

      <form 
        action="proses/proses-auth-register.php" 
        method="POST" 
        class="space-y-6"
      >

        <!-- Name -->
        <div>
          <label class="block text-sm text-gray-600 mb-1">
            Name
          </label>
          <input
            type="text"
            name="name"
            required
            class="w-full h-11 border-b border-gray-300 bg-transparent text-gray-900 focus:outline-none focus:border-gray-900"
            placeholder="Your name"
          />
        </div>

        <!-- Phone -->
        <div>
          <label class="block text-sm text-gray-600 mb-1">
            Phone Number
          </label>
          <input
            type="number"
            name="phone"
            required
            class="w-full h-11 border-b border-gray-300 bg-transparent text-gray-900 focus:outline-none focus:border-gray-900"
            placeholder="08xxxxxxxx"
          />
        </div>

        <!-- Email -->
        <div>
          <label class="block text-sm text-gray-600 mb-1">
            Email address
          </label>
          <input
            type="email"
            name="email"
            required
            class="w-full h-11 border-b border-gray-300 bg-transparent text-gray-900 focus:outline-none focus:border-gray-900"
            placeholder="name@email.com"
          />
        </div>

        <!-- Password -->
        <div>
          <label class="block text-sm text-gray-600 mb-1">
            Password
          </label>
          <input
            type="password"
            name="password"
            required
            class="w-full h-11 border-b border-gray-300 bg-transparent text-gray-900 focus:outline-none focus:border-gray-900"
            placeholder="••••••••"
          />
        </div>

        <!-- Confirm -->
        <div>
          <label class="block text-sm text-gray-600 mb-1">
            Confirm password
          </label>
          <input
            type="password"
            name="cpassword"
            required
            class="w-full h-11 border-b border-gray-300 bg-transparent text-gray-900 focus:outline-none focus:border-gray-900"
            placeholder="••••••••"
          />
        </div>

        <!-- Submit -->
        <button
          type="submit"
          name="register_btn"
          class="w-full h-11 rounded-lg bg-gray-900 text-white font-medium hover:bg-black transition"
        >
          Create account
        </button>

      </form>

    </div>

    <!-- RIGHT : IMAGE -->
    <div class="hidden md:block relative">
      <img 
        src="assets/img/dina.png"
        alt="Register Illustration"
        class="w-full h-full object-cover"
      />
    </div>

  </div>
</div>

<?php include("includes/footer.php") ?>

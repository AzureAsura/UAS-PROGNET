  </div>

  <!-- Toast Notification -->
    <?php 

    // session_start();

    if (isset($_SESSION['message'])): ?>
        <div id="toast-success" 
            class="fixed bottom-6 right-6 z-50 flex items-center w-[300px] p-4 mb-4 text-green-700 bg-green-100 rounded-lg shadow-lg animate-slide-up">
            
            <!-- Icon -->
            <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M5 13l4 4L19 7" />
            </svg>

            <!-- Message -->
            <span class="text-sm font-medium">
                <?= $_SESSION['message'] ?>
            </span>

            <!-- Close button -->
            <button onclick="document.getElementById('toast-success').remove()" 
                class="ml-auto text-green-700 hover:text-green-900">
                ✕
            </button>
        </div>

        <script>
            // Auto hide after 4 seconds
            setTimeout(() => {
                const toast = document.getElementById('toast-success');
                if (toast) toast.remove();
            }, 4000);
        </script>

    <?php
        unset($_SESSION['message']);
    endif;
    ?>

  <script src="js/main.js"></script>
</body>
</html>

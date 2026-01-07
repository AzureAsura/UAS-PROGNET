    </div> <!-- END flex layout -->

    <!-- TOAST NOTIFICATION -->
    <?php if (isset($_SESSION['message'])): ?>
        <div id="toast-success"
            class="fixed bottom-6 right-6 z-[999]
                   flex items-start gap-3
                   w-[320px] p-4
                   text-green-700 bg-green-100
                   rounded-lg shadow-lg
                   animate-slide-up">

            <!-- ICON -->
            <svg class="w-6 h-6 mt-0.5 flex-shrink-0"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M5 13l4 4L19 7" />
            </svg>

            <!-- MESSAGE -->
            <span class="text-sm font-medium flex-1">
                <?= htmlspecialchars($_SESSION['message']); ?>
            </span>

            <!-- CLOSE -->
            <button onclick="document.getElementById('toast-success')?.remove()"
                class="text-green-700 hover:text-green-900 font-bold">
                ✕
            </button>
        </div>

        <script>
          setTimeout(() => {
            document.getElementById('toast-success')?.remove();
          }, 4000);
        </script>

    <?php unset($_SESSION['message']); endif; ?>

    <!-- MAIN JS -->
    <script src="js/main.js"></script>

  </body>
</html>

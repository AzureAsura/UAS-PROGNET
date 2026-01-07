document.addEventListener("DOMContentLoaded", () => {
  const sidebar = document.getElementById("sidebar");
  const overlay = document.getElementById("sidebar-overlay");
  const toggleBtn = document.getElementById("toggleBtn");
  const toggleIcon = document.getElementById("toggleIcon");

  if (!sidebar || !toggleBtn) return;

  function openSidebar() {
    sidebar.classList.remove("-translate-x-full");
    overlay?.classList.remove("hidden");
    toggleIcon?.classList.replace("ri-menu-line", "ri-close-line");
  }

  function closeSidebar() {
    sidebar.classList.add("-translate-x-full");
    overlay?.classList.add("hidden");
    toggleIcon?.classList.replace("ri-close-line", "ri-menu-line");
  }

  toggleBtn.addEventListener("click", () => {
    const isOpen = !sidebar.classList.contains("-translate-x-full");
    isOpen ? closeSidebar() : openSidebar();
  });

  overlay?.addEventListener("click", closeSidebar);

  window.addEventListener("resize", () => {
    if (window.innerWidth >= 768) {
      sidebar.classList.remove("-translate-x-full");
      overlay?.classList.add("hidden");
    } else {
      sidebar.classList.add("-translate-x-full");
      toggleIcon?.classList.replace("ri-close-line", "ri-menu-line");
    }
  });
});

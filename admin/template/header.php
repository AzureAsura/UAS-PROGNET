<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

<!-- MOBILE TOGGLE BUTTON (SATU-SATUNYA OPEN BUTTON) -->
<button id="toggleBtn"
  class="md:hidden fixed top-5 left-5 z-50
         w-12 h-12 rounded-full
         bg-black text-white text-2xl
         flex items-center justify-center shadow-lg">
  <i id="toggleIcon" class="ri-menu-line"></i>
</button>

<!-- OVERLAY -->
<div id="sidebar-overlay"
  onclick="closeSidebar()"
  class="fixed inset-0 bg-black/50 z-40 hidden md:hidden">
</div>

<div class="flex min-h-screen">

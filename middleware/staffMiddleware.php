<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include('../functions/reuseableFunction.php');

// Daftar halaman yang boleh diakses oleh role 2 (Pekerja)
// Tambah/hapus sesuai kebutuhan kamu
$allowedPagesForStaff = [
    'index.php',          // dashboard
    'orders.php',         // daftar order
    'order-details.php',  // detail order
    'order-history.php',  // detail order
    'order-on-going.php',  // detail order
    // tambah halaman lain misal: 'products.php', 'category.php', dll
];

// Cek apakah user sudah login
if (!isset($_SESSION['auth'])) {
    redirect("../login.php", "Login untuk akses");
    exit();
}

// Cek role
$role = $_SESSION['role'] ?? 0;

if ($role == 1) {
    // Admin boleh akses semua → lanjut
} elseif ($role == 2) {
    // Pekerja → cek apakah halaman saat ini diizinkan
    $currentPage = basename($_SERVER['PHP_SELF']);

    if (!in_array($currentPage, $allowedPagesForStaff)) {
        redirect("index.php", "Anda tidak memiliki akses ke halaman ini");
        exit();
    }
} else {
    // Role 0 (Klien) atau role lain → redirect ke depan
    redirect("../index.php", "Akses hanya untuk admin/staff");
    exit();
}
?>
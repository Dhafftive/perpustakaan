<?php
session_start();

// Periksa apakah pengguna telah login
if (!isset($_SESSION["user_id"])) {
    // Jika pengguna belum login, redirect ke halaman login
    header("Location: ../index.php");
    exit();
}

// Periksa waktu kadaluarsa
if (isset($_SESSION["expire_time"]) && time() > $_SESSION["expire_time"]) {
    // Jika waktu sesi sudah habis, hapus semua variabel sesi dan redirect ke halaman login
    session_unset();
    session_destroy();
    header("Location: ../index.php");
    exit();
}

// Perbarui waktu kadaluarsa
$_SESSION["expire_time"] = time() + 5 * 60 * 60; // Sesuaikan sesuai kebutuhan

// Jika pengguna telah login dan sesi masih berlaku, lanjutkan eksekusi halaman
?>
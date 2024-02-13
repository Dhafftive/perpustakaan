<?php
// 1. Lakukan koneksi ke database menggunakan file "koneksi.php".
include "../../koneksi.php";
include "cek_login.php";

// Memeriksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    // Jika belum login, kirim respons error
    http_response_code(401); // Unauthorized
    exit("Anda belum login.");
}

// Memeriksa apakah bukuID telah diterima dari request POST
if (!empty($_POST['bukuID'])) {
    // Tangkap data bukuID dari request POST
    $bukuID = $_POST['bukuID'];
    
    // Tangkap userID dari session
    $userID = $_SESSION['user_id'];

    // Query untuk menambahkan buku ke koleksi pribadi
    $query = "INSERT INTO koleksipribadi (userID, bukuID) VALUES ('$userID', '$bukuID')";

    // Jalankan query
    if (mysqli_query($koneksi, $query)) {
        // Jika berhasil, kirim respons 'success'
        echo 'success';
        exit;
    } else {
        // Jika terjadi kesalahan, kirim pesan kesalahan
        http_response_code(500); // Internal Server Error
        exit("Terjadi kesalahan saat menambahkan buku ke koleksi pribadi: " . mysqli_error($koneksi));
    }
} else {
    // Jika bukuID tidak diterima, kirim respons error
    http_response_code(400); // Bad Request
    exit("ID buku tidak diberikan.");
}
?>

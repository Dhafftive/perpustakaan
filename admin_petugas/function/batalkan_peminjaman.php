<?php
    // 1. Lakukan koneksi ke database menggunakan file "koneksi.php".
    include "../../koneksi.php";
    include "cek_login.php";

    // Memeriksa apakah form telah disubmit
    if (!empty($_POST)) {
        // Tangkap data dari AJAX
        $bukuID = $_POST['bukuID'];
        $userID = $_POST['userID'];

        // Buat kueri SQL untuk menghapus data peminjaman dari tabel peminjaman
        $query = "DELETE FROM peminjaman WHERE bukuID = $bukuID AND userID = $userID";

        if (mysqli_query($koneksi, $query)) {
            echo 'success'; // Kirim pesan kesuksesan
            exit;
        } else {
            $errorMessage = mysqli_error($koneksi);
            echo 'Error: ' . $errorMessage; // Kirim pesan kesalahan MySQL
            exit;
        }
    }
?>

<?php
    // Lakukan koneksi ke database menggunakan file "koneksi.php".
    include "../../koneksi.php";
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Periksa apakah indeks 'edit-kategoriID' dan 'edit-namakategori' tersedia dalam data POST
        if(isset($_POST['edit-kategoriID']) && isset($_POST['edit-namakategori'])) {
            $kategoriID = $_POST['edit-kategoriID'];
            $namakategori = $_POST['edit-namakategori'];

            // Buat kueri SQL untuk memperbarui data kategori
            $query = "UPDATE kategoribuku SET namakategori = '$namakategori' WHERE kategoriID = $kategoriID";

            // Eksekusi kueri SQL
            if (mysqli_query($koneksi, $query)) {
                // Jika berhasil, kirimkan respons 'success'
                echo 'success';
            } else {
                // Jika terjadi kesalahan saat menjalankan kueri, kirimkan pesan kesalahan MySQL
                echo 'Error updating category: ' . mysqli_error($koneksi);
            }
        } else {
            // Jika salah satu atau kedua indeks tidak tersedia dalam data POST, kirimkan pesan kesalahan
            echo 'Missing index: edit-kategoriID or edit-namakategori';
        }
    } else {
        // Jika permintaan bukan metode POST, kirimkan pesan kesalahan
        echo 'Invalid request method. Only POST requests are allowed.';
    }
?>

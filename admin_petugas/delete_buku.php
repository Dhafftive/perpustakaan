<?php
    // Lakukan koneksi ke database menggunakan file "koneksi.php"
    include "../koneksi.php";
    include "function/cek_login.php";

    // Periksa apakah ada form yang di-submit
    if (!empty($_POST['bukuID'])) {
        // Tangkap ID buku yang akan dihapus
        $bukuID = $_POST['bukuID'];

        // Query untuk menghapus buku dari tabel buku
        $query_hapus_buku = "DELETE FROM buku WHERE bukuID = $bukuID";

        // Eksekusi kueri
        if (mysqli_query($koneksi, $query_hapus_buku)) {
            // Jika berhasil dihapus, kirim respons 'success'
            echo 'success';
            exit; // Berhenti di sini untuk menghindari eksekusi kode berikutnya
        } else {
            // Jika terjadi kesalahan, kirim pesan kesalahan
            echo 'Error menghapus buku: ' . mysqli_error($koneksi);
            exit; // Berhenti di sini untuk menghindari eksekusi kode berikutnya
        }
    } else {
        // Jika tidak ada data yang dikirim, kirim pesan error
        echo 'Error: Data buku tidak diterima.';
        exit; // Berhenti di sini untuk menghindari eksekusi kode berikutnya
    }
?>

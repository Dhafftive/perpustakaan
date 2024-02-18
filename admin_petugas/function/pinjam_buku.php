<?php
    // 1. Lakukan koneksi ke database menggunakan file "koneksi.php".
    include "../../koneksi.php";
    include "cek_login.php";

    // Memeriksa apakah form telah disubmit
    if (!empty($_POST)) {
        // Tangkap data dari AJAX
        $bukuID = $_POST['bukuID'];
        $perpusID = $_POST['perpusID'];
        $userID = $_SESSION['user_id'];

        // Buat kueri SQL untuk memeriksa apakah buku sudah dipinjam sebelumnya oleh pengguna saat ini
        $query_check = "SELECT * FROM peminjaman WHERE bukuID = $bukuID AND userID = $userID AND status_pinjam = 'diajukan'";
        $result_check = mysqli_query($koneksi, $query_check);

        if(mysqli_num_rows($result_check) > 0) {
            echo 'Buku sudah diajukan sebelumnya'; // Kirim pesan jika buku telah diajukan sebelumnya
            exit;
        }

        // Buat kueri SQL untuk memasukkan data peminjaman ke dalam tabel peminjaman
        $query = "INSERT INTO peminjaman (bukuID, perpusID, userID, status_pinjam) 
                VALUES ($bukuID, $perpusID, $userID, 'diajukan')";

        if (mysqli_query($koneksi, $query)) {
            echo 'success'; // Kirim pesan kesuksesan
            exit;
        } else {
            echo 'Error: ' . mysqli_error($koneksi); // Kirim pesan kesalahan MySQL
            exit;
        }
    }
?>

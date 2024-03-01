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
        
        // Mulai transaksi
        mysqli_autocommit($koneksi, false);
        
        // Buat kueri SQL untuk memeriksa apakah buku sudah dipinjam sebelumnya oleh pengguna saat ini
        $query_check = "SELECT * FROM peminjaman WHERE bukuID = $bukuID AND userID = $userID AND status_pinjam = 'dipinjam'";
        $result_check = mysqli_query($koneksi, $query_check);
        
        if(mysqli_num_rows($result_check) > 0) {
            echo 'Buku sudah dipinjam sebelumnya'; // Kirim pesan jika buku telah diajukan sebelumnya
            exit;
        }
        
        $tanggal_sekarang = date("Y-m-d"); // Menghasilkan tanggal dalam format "YYYY-MM-DD"

        // Buat kueri SQL untuk memasukkan data peminjaman ke dalam tabel peminjaman
        $query_pinjam = "INSERT INTO peminjaman (bukuID, perpusID, userID, status_pinjam, tanggal_pinjam) 
                        VALUES ($bukuID, $perpusID, $userID, 'dipinjam', '$tanggal_sekarang')";
        $result_pinjam = mysqli_query($koneksi, $query_pinjam);
        // Buat kueri SQL untuk mengurangi stok buku dari tabel buku
        $query_buku = "UPDATE buku SET stok = stok - 1 WHERE bukuID = '$bukuID'";
        $result_update_stok = mysqli_query($koneksi, $query_buku);


        if ($result_pinjam && $result_update_stok) {
            mysqli_commit($koneksi);
            echo "succes";
            exit;
        } else {
            mysqli_rollback($koneksi);
            echo 'Error: ' . mysqli_error($koneksi); // Kirim pesan kesalahan MySQL
            exit;
        }

        // Aktifkan kembali autocommit
        mysqli_autocommit($koneksi, true);
    }
?>

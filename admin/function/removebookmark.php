<?php
// 1. Lakukan koneksi ke database menggunakan file "koneksi.php".
include "../../koneksi.php";
include "cek_login.php"; // Pastikan Anda memiliki file cek_login.php yang berisi logika sesi login.

// 2. Tangkap data bukuID yang dikirim melalui metode POST.
$bukuID = $_POST['bukuID'];

// 3. Buat kueri SQL untuk menghapus entri buku dari tabel koleksi pribadi.
$query = "DELETE FROM koleksipribadi WHERE bukuID = $bukuID AND userID = " . $_SESSION['user_id'];

// 4. Jalankan kueri SQL.
if (mysqli_query($koneksi, $query)) {
    // Jika berhasil dihapus, kirim respons 'success' ke JavaScript.
    echo 'success';
} else {
    // Jika terjadi kesalahan, kirim pesan kesalahan ke JavaScript.
    echo mysqli_error($koneksi);
}
?>

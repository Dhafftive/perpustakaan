<?php
// Koneksi ke database
include '../../koneksi.php';

// Cek apakah peminjamanID telah diterima dari permintaan POST
if (isset($_POST['peminjamanID'])) {
    // Ambil nilai peminjamanID dari permintaan POST
    $peminjamanID = $_POST['peminjamanID'];

    // Kueri SQL untuk memperbarui status_pinjam menjadi 'dikembalikan' dan tanggal_kembali menjadi tanggal sekarang
    $updateQuery = "UPDATE peminjaman SET status_pinjam = 'dikembalikan', tanggal_kembali = CURRENT_DATE() WHERE peminjamanID = $peminjamanID";

    // Eksekusi kueri update
    if (mysqli_query($koneksi, $updateQuery)) {
        // Jika berhasil, kirimkan respons "success"
        echo "success";
    } else {
        // Jika terjadi kesalahan, kirimkan respons "error"
        echo "error";
    }
} else {
    // Jika peminjamanID tidak diterima, kirimkan respons "error"
    echo "error";
}

// Menutup koneksi database
mysqli_close($koneksi);
?>

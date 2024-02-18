<?php
// Koneksi ke database
include '../../koneksi.php';

// Pastikan Anda telah terkoneksi ke database dan memproses koneksi

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["peminjamanID"])) {
    // Tangkap peminjamanID dari permintaan POST
    $peminjamanID = $_POST["peminjamanID"];

    // Kueri SQL untuk mengupdate status_pinjam dan tanggal_pinjam
    $updateQuery = "UPDATE peminjaman SET status_pinjam = 'dipinjam', tanggal_pinjam = NOW() WHERE peminjamanID = $peminjamanID";

    // Kueri SQL untuk menghapus pengajuan yang sama
    $deleteQuery = "DELETE FROM peminjaman WHERE bukuID IN (SELECT bukuID FROM peminjaman WHERE peminjamanID = $peminjamanID) AND status_pinjam = 'diajukan'";

    // Eksekusi kueri secara bersamaan
    mysqli_begin_transaction($koneksi);
    if (mysqli_query($koneksi, $updateQuery) && mysqli_query($koneksi, $deleteQuery)) {
        mysqli_commit($koneksi);
        echo "success";
    } else {
        mysqli_rollback($koneksi);
        echo "error";
    }

    // Tutup koneksi database
    mysqli_close($koneksi);
}

?>

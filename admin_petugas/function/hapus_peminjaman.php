<?php
// Pastikan Anda telah terkoneksi ke database
include '../../koneksi.php';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["peminjamanID"])) {
    // Tangkap peminjamanID dari permintaan POST
    $peminjamanID = $_POST["peminjamanID"];

    // Kueri SQL untuk menghapus peminjaman
    $deleteQuery = "DELETE FROM peminjaman WHERE peminjamanID = $peminjamanID";

    // Eksekusi kueri
    if (mysqli_query($koneksi, $deleteQuery)) {
        echo "success";
    } else {
        echo "error";
    }

    // Tutup koneksi database
    mysqli_close($koneksi);
}
?>

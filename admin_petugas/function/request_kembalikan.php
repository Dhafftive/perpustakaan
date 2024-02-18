<?php
// Melakukan koneksi ke database
include '../../koneksi.php';

// Memeriksa apakah metode permintaan adalah POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil ID peminjaman dari data yang dikirim melalui permintaan POST
    $peminjamanID = $_POST['peminjamanID'];

    // Update status peminjaman menjadi 'tertunda' berdasarkan peminjamanID
    $updateQuery = "UPDATE peminjaman SET status_pinjam = 'tertunda' WHERE peminjamanID = $peminjamanID";
    $updateResult = mysqli_query($koneksi, $updateQuery);

    // Menutup koneksi database
    mysqli_close($koneksi);

    // Memeriksa apakah update berhasil
    if ($updateResult) {
        echo "Peminjaman berhasil dikembalikan.";
    } else {
        echo "Gagal mengembalikan peminjaman.";
    }
} else {
    echo "Metode permintaan tidak valid.";
}
?>

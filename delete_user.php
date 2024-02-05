<?php
require 'koneksi.php';

if (isset($_GET['userID'])) {
    $userID = $_GET['userID'];

    // Lakukan query DELETE untuk menghapus data user berdasarkan userID
    $deleteQuery = "DELETE FROM user WHERE userID = '$userID'";
    $deleteResult = mysqli_query($koneksi, $deleteQuery);

    if (!$deleteResult) {
        die('Error in SQL query: ' . mysqli_error($koneksi));
    }

    // Mengirim tanggapan ke klien (opsional)
    echo "User berhasil dihapus.";

    // Selesai tanpa mengembalikan HTML (karena ini adalah tanggapan AJAX)
    exit();
} else {
    // Jika tidak ada userID, kirim pesan error
    echo "Invalid request.";
    exit();
}
?>

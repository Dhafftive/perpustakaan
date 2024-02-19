<?php
// Include file koneksi ke database
include '../../koneksi.php';

// Pastikan request yang diterima adalah POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil nilai dari form
    $peminjamanID = $_POST['peminjamanID'];
    $userID = $_POST['userID'];
    $bukuID = $_POST['bukuID'];
    $ulasan = $_POST['ulasan'];
    $rating = $_POST['rating'];

    // Query untuk menyimpan ulasan ke dalam database
    $query = "INSERT INTO ulasanbuku (peminjamanID, userID, bukuID, ulasan, rating) 
              VALUES ($peminjamanID, $userID, $bukuID, '$ulasan', $rating)";
    
    // Eksekusi query
    if (mysqli_query($koneksi, $query)) {
        // Jika berhasil, kirim respon "success"
        echo "success";
    } else {
        // Jika gagal, kirim respon "error"
        echo "error";
    }
}
?>

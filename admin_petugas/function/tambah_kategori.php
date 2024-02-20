<?php
// 1. Lakukan koneksi ke database menggunakan file "koneksi.php".
include "../../koneksi.php";

// Pastikan metode yang digunakan adalah POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Tangkap data yang dikirimkan melalui AJAX
    $namaKategori = $_POST['nama-kategori'];

    // Buat kueri SQL untuk menambahkan kategori baru
    $query = "INSERT INTO kategoribuku (namakategori) VALUES ('$namaKategori')";

    // Eksekusi kueri
    if (mysqli_query($koneksi, $query)) {
        // Jika berhasil, kirimkan respon JSON dengan status sukses
        echo json_encode(array("status" => "success"));
    } else {
        // Jika terjadi kesalahan, kirimkan respon JSON dengan status error
        echo json_encode(array("status" => "error", "message" => mysqli_error($koneksi)));
    }
} else {
    // Jika metode yang digunakan bukan POST, kirimkan respon JSON dengan status error
    echo json_encode(array("status" => "error", "message" => "Metode tidak diizinkan"));
}
?>

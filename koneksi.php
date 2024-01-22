<?php
// Menghubungkan ke database
    $host = "localhost"; 
    $username = "root"; 
    $password = ""; 
    $database = "perpustakaan";
    $koneksi = mysqli_connect($host, $username, $password, $database);
    
    // Mengecek koneksi database
    if (!$koneksi) {
        die("Koneksi database gagal: " . mysqli_connect_error());
    }
?>
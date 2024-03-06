<?php
// Koneksi ke database
include '../../koneksi.php';

// Tangkap tanggal sekarang dari permintaan POST
$tanggalSekarang = $_POST['tanggal_sekarang'];

// Kueri SQL untuk menghitung jumlah peminjaman yang harus dikembalikan hari ini
$jumlahPeminjamanHariIniSQL = "SELECT COUNT(*) AS total FROM peminjaman WHERE status_pinjam = 'dipinjam' AND tanggal_kembali = '$tanggalSekarang'";
$resultJumlahPeminjamanHariIni = mysqli_query($koneksi, $jumlahPeminjamanHariIniSQL);

// Ambil jumlah peminjaman
$totalPeminjamanHariIni = mysqli_fetch_assoc($resultJumlahPeminjamanHariIni)['total'];

// Jika tidak ada buku yang harus dikembalikan, kirim respons 'no_book'
if ($totalPeminjamanHariIni == 0) {
    echo "no_book";
} else {
    // Kueri SQL untuk melakukan update status peminjaman
    $updateSQL = "UPDATE peminjaman SET status_pinjam = 'dikembalikan' WHERE tanggal_kembali = '$tanggalSekarang' AND status_pinjam = 'dipinjam'";

    // Eksekusi kueri
    if(mysqli_query($koneksi, $updateSQL)) {
        echo "success";
    } else {
        // Jika terjadi kesalahan, kirim pesan error ke JavaScript
        echo "error: " . mysqli_error($koneksi);
    }
}

// Menutup koneksi database
mysqli_close($koneksi);
?>

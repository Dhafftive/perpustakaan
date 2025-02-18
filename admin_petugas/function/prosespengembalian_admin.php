<?php
// Koneksi ke database
include '../../koneksi.php';

// Cek apakah peminjamanID telah diterima dari permintaan POST
if (isset($_POST['peminjamanID'])) {
    // Ambil nilai peminjamanID dari permintaan POST
    $peminjamanID = $_POST['peminjamanID'];

    // Kueri SQL untuk mengambil bukuID dari tabel peminjaman berdasarkan peminjamanID
    $query_get_bukuID = "SELECT bukuID FROM peminjaman WHERE peminjamanID = $peminjamanID";
    $result_get_bukuID = mysqli_query($koneksi, $query_get_bukuID);

    // Memeriksa apakah kueri berhasil dieksekusi
    if ($result_get_bukuID) {
        // Ambil baris hasil kueri
        $row = mysqli_fetch_assoc($result_get_bukuID);
        
        // Ambil bukuID dari baris hasil kueri
        $bukuID = $row['bukuID'];

        // Kueri SQL untuk memperbarui status_pinjam menjadi 'dikembalikan'
        $query_kembalikan = "UPDATE peminjaman SET status_pinjam = 'dikembalikan' WHERE peminjamanID = $peminjamanID";
        $result_kembalikan = mysqli_query($koneksi, $query_kembalikan);

        // Buat kueri SQL untuk mengurangi stok buku dari tabel buku
        $query_buku = "UPDATE buku SET stok = stok + 1 WHERE bukuID = '$bukuID'";
        $result_update_stok = mysqli_query($koneksi, $query_buku);

        // Eksekusi kueri update
        if ($result_kembalikan && $result_update_stok) {
            // Jika berhasil, kirimkan respons "success"
            echo "success";
        } else {
            // Jika terjadi kesalahan, kirimkan respons "error"
            echo "error";
        }
    } else {
        // Jika terjadi kesalahan saat mengambil bukuID, kirimkan respons "error"
        echo "error";
    }
} else {
    // Jika peminjamanID tidak diterima, kirimkan respons "error"
    echo "error";
}

// Menutup koneksi database
mysqli_close($koneksi);
?>

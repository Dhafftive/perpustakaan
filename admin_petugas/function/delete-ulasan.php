<?php
    // Include file koneksi
    require '../../koneksi.php';

    // Memeriksa apakah ada data yang dikirimkan melalui metode POST
    if(isset($_POST['ulasanID'])) {
        // Menangkap ulasanID dari data POST
        $ulasanID = $_POST['ulasanID'];

        // Query untuk menghapus ulasan
        $sql = "DELETE FROM ulasanbuku WHERE ulasanID = $ulasanID";

        // Eksekusi query
        if ($koneksi->query($sql) === TRUE) {
            echo "Ulasan berhasil dihapus!";
        } else {
            echo "Terjadi kesalahan saat menghapus ulasan: " . $koneksi->error;
        }
    } else {
        // Jika tidak ada data POST, kirim pesan kesalahan
        echo "Tidak ada data yang dikirimkan.";
    }

    // Tutup koneksi
    $koneksi->close();
?>

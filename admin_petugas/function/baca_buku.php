<?php
include('../../koneksi.php');
session_start();

if (isset($_GET['id'])) {
    $bookId = $_GET['id'];

    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];
        
        // Periksa apakah pengguna telah meminjam buku
        $checkQuery = "SELECT * FROM peminjaman WHERE bukuID = $bookId AND userID = $userId";
        $checkResult = mysqli_query($koneksi, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            // Pengguna telah meminjam buku, maka berikan akses
            $query = "SELECT * FROM buku WHERE bukuID = $bookId";
            $result = mysqli_query($koneksi, $query);
            $book = mysqli_fetch_assoc($result);

            $pdfFilePath = "../../books-library/{$book['isibuku']}";

            if (file_exists($pdfFilePath)) {
                // Set header untuk menampilkan PDF di browser tanpa opsi cetak atau unduh
                header("Content-type: application/pdf");
                header("Content-Disposition: inline; filename=\"" . $book['isibuku'] . "\"");
                header("Content-Length: " . filesize($pdfFilePath));

                // Output the PDF file
                readfile($pdfFilePath);
                exit;
            } else {
                echo "PDF file not found.";
            }
            exit;
        } else {
            echo "Anda belum meminjam buku ini.";
        }
    } else {
        echo "Anda harus login untuk mengakses buku ini.";
    }
} else {
    echo "Parameter ID buku tidak ditemukan.";
}
?>

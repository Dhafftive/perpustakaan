<?php
// Ambil parameter ID buku dari URL
$bookId = $_GET['id'];

// Lakukan query ke database untuk mendapatkan isi buku
// Misalnya, dengan menggunakan PDO
try {
    $dbh = new PDO('mysql:host=localhost;dbname=perpustakaan', 'root', '');
    $stmt = $dbh->prepare("SELECT isibuku FROM buku WHERE bukuID = :bookId");
    $stmt->bindParam(':bookId', $bookId);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Ubah hasil query menjadi JSON
    echo json_encode($result['isibuku']);
} catch (PDOException $e) {
    // Jika terjadi kesalahan saat menghubungi database, kembalikan pesan kesalahan
    echo json_encode(array('error' => $e->getMessage()));
}
?>

<?php
require '../koneksi.php';
require 'function/cek_login.php';

if (!empty($_POST)) {
    // Tangkap data dari form
    $book_id = $_POST['bukuID'];
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $kategoriID = $_POST['kategori'];
    $perpusID = $_POST['perpusID'];
    $tahun_terbit = $_POST['tahun-terbit'];
    $sinopsis = $_POST['sinopsis'];
    $username = $_SESSION['username'];
    $stok = $_POST['stok-buku'];
    $bukuFileBefore = $_POST['fileBookBefore'];
    $CoverBookBefore = $_POST['coverBookBefore'];

    // Dapatkan nama file dan path sementara dari file yang diunggah
    $nama_file_cover = $_FILES['cover']['name'];
    $tmp_file_cover = $_FILES['cover']['tmp_name'];

    // Dapatkan nama file dan path sementara dari file buku yang diunggah
    $nama_file_buku = $_FILES['buku_file']['name'];
    $tmp_file_buku = $_FILES['buku_file']['tmp_name'];

    // Tentukan direktori tujuan untuk menyimpan cover buku
    $targetDir = "../images/cover-buku/";
    // Tentukan direktori tujuan untuk menyimpan file buku
    $targetDirBuku = "../books-library/";

    // Periksa apakah ada file buku baru yang diunggah
    if (!empty($_FILES['buku_file']['name'])) {
        $nama_file_buku = $_FILES['buku_file']['name'];
        $tmp_file_buku = $_FILES['buku_file']['tmp_name'];
        $targetFileBuku = $targetDirBuku . basename($nama_file_buku);
    } else {
        $nama_file_buku = $bukuFileBefore;
        $targetFileBuku = $targetDirBuku . basename($bukuFileBefore); // Definisikan variabel targetFileBuku
    }

    // Periksa apakah ada file sampul buku baru yang diunggah
    if (!empty($_FILES['cover']['name'])) {
        $nama_file_cover = $_FILES['cover']['name'];
        $tmp_file_cover = $_FILES['cover']['tmp_name'];
        $targetFileCover = $targetDir . basename($nama_file_cover);
    } else {
        $nama_file_cover = $CoverBookBefore;
        $targetFileCover = $targetDir . basename($CoverBookBefore); // Definisikan variabel targetFileCover
    }


    // Update query
    $query = "UPDATE buku 
              SET judul = IF('$judul' != '', '$judul', judul), 
                  penulis = IF('$penulis' != '', '$penulis', penulis), 
                  penerbit = IF('$penerbit' != '', '$penerbit', penerbit), 
                  kategoriID = IF('$kategoriID' != '', '$kategoriID', kategoriID), 
                  tahunterbit = IF('$tahun_terbit' != '', '$tahun_terbit', tahunterbit), 
                  foto = IF('$nama_file_cover' != '', '$nama_file_cover', foto), 
                  deskripsi = IF('$sinopsis' != '', '$sinopsis', deskripsi), 
                  stok = IF('$stok' != '', '$stok', stok), 
                  isibuku = IF('$nama_file_buku' != '', '$nama_file_buku', isibuku) 
              WHERE bukuID = '$book_id'";
    
    // Menjalankan kueri
    if (mysqli_query($koneksi, $query)) {
        // Jika berhasil, pindahkan file ke direktori yang ditentukan
        move_uploaded_file($tmp_file_cover, $targetFileCover);
        move_uploaded_file($tmp_file_buku, $targetFileBuku);
        header('Location: data-buku.php');
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }
}
?>

<?php 
    include "function/cek_login.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ulasan - Bookshelf.Idn</title>
    <link rel="stylesheet" href="../css/ulasan.css?v=<?php echo time(); ?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<body>
    <?php require '../sidebar.php';?>
    <?php
    require '../koneksi.php';
    // Pastikan id buku telah diterima dari parameter GET
    if(isset($_GET['id'])) {
        // Ambil id buku dari parameter GET
        $id_buku = $_GET['id'];

        // Lakukan kueri SQL untuk mengambil data buku berdasarkan id
        $query_buku = "SELECT * FROM buku WHERE bukuID = $id_buku";
        $result_buku = mysqli_query($koneksi, $query_buku);

        // Lakukan kueri SQL untuk mengambil status pinjam dan userID dari tabel peminjaman berdasarkan bukuID
        $query_peminjaman = "SELECT status_pinjam, userID FROM peminjaman WHERE bukuID = $id_buku";
        $result_peminjaman = mysqli_query($koneksi, $query_peminjaman);

        // Default class
        $action_class = "pinjam";

        // Periksa apakah ada hasil peminjaman yang ditemukan
        if(mysqli_num_rows($result_peminjaman) > 0) {
            // Ambil data status_pinjam dan userID
            $row_peminjaman = mysqli_fetch_assoc($result_peminjaman);
            $status_pinjam = $row_peminjaman["status_pinjam"];
            $userID_peminjaman = $row_peminjaman["userID"];
            

            // Periksa status_pinjam untuk menentukan class yang sesuai
            if ($status_pinjam == "dipinjam" || $status_pinjam == "tertunda") {
                $action_class = "dipinjam";
            } elseif ($status_pinjam == "diajukan") {
                // Jika userID peminjaman sama dengan user yang sedang login, tampilkan class diajukan, jika tidak, tampilkan class pinjam
                if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $userID_peminjaman) {
                    $action_class = "diajukan";
                } else {
                    $action_class = "pinjam";
                }
            } elseif ($status_pinjam == "dikembalikan") {
                $action_class = "pinjam";
            }
        }

        // Periksa apakah ada data buku yang ditemukan
        if(mysqli_num_rows($result_buku) > 0) {
            // Ambil data buku
            $row_buku = mysqli_fetch_assoc($result_buku);
            $judul_buku = $row_buku["judul"];
            $penulis_buku = $row_buku["penulis"];
            $penerbit_buku = $row_buku["penerbit"];
            $deskripsi_buku = $row_buku["deskripsi"];
            $foto_buku = $row_buku["foto"];
            $idperpus = $row_buku["perpusID"];
    ?>
            <div class="book-container">
                <div class="cover-book">
                    <div class="img-container">
                        <img src="../images/cover-buku/<?php echo $foto_buku; ?>" alt="Cover Buku">
                    </div>
                </div>
                <div class="book-content">
                    <div class="books-desc">
                        <h1 class="judul"><?php echo $judul_buku; ?></h1>
                        <h3 class="penulis"><?php echo $penulis_buku; ?></h3>
                        <p class="penerbit"><?php echo $penerbit_buku; ?></p>
                    </div>
                    <div class="books-action">
                         <!-- Tampilkan tombol sesuai dengan kelas yang ditentukan -->
                         <?php if ($action_class === 'diajukan') : ?>
                            <div class="<?php echo $action_class; ?>" onclick="batalkanPeminjaman(<?php echo $id_buku; ?>, <?php echo $_SESSION['user_id']; ?>)">Diajukan</div>
                        <?php elseif ($action_class === 'dipinjam') : ?>
                            <div class="<?php echo $action_class; ?>">Dipinjam</div>
                        <?php else : ?>
                            <div class="<?php echo $action_class; ?>" onclick="pinjamBuku(<?php echo $id_buku; ?>, <?php echo $idperpus; ?>, <?php echo $_SESSION['user_id']; ?>)">Pinjam</div>
                        <?php endif; ?>
                        <?php 
                            // Periksa apakah pengguna sudah login
                            if(isset($_SESSION['user_id'])) {
                            // Lakukan kueri SQL untuk memeriksa apakah buku sudah di-bookmark oleh pengguna saat ini
                            $query_bookmarked = "SELECT bukuID FROM koleksipribadi WHERE userID = " . $_SESSION['user_id'] . " AND bukuID = $id_buku";
                            $result_bookmarked = mysqli_query($koneksi, $query_bookmarked);
                    
                            // Periksa apakah buku telah di-bookmark
                            if(mysqli_num_rows($result_bookmarked) > 0) {
                        ?>
                                    <!-- Tampilkan tombol 'bookmarked' -->
                                    <div class="bookmark" onclick="removeBookmark(<?php echo $id_buku; ?>)"><i class="fa-solid fa-bookmark"></i>Disimpan</div>
                        <?php   } else { ?>
                                    <!-- Tampilkan tombol 'bookmark' -->
                                    <div class="bookmark" onclick="addBookmark(<?php echo $id_buku; ?>)"><i class="fa-regular fa-bookmark"></i>Simpan</div>
                        <?php }} ?>
                        </div>
                    <div class="sinopsis">
                        <?php 
                            if(empty($deskripsi_buku)) {
                                echo '<p class="text-nothing">Tidak ada deskripsi apapun tentang buku ini</p>';
                            } else {
                                echo '<p class="text">' . $deskripsi_buku . '</p>';
                            }
                        ?>
                    </div>
                </div>
            </div>
    <?php
            // Lakukan kueri SQL untuk mengambil ulasan buku berdasarkan id buku
            $query_ulasan = "SELECT * FROM ulasanbuku WHERE bukuID = $id_buku";
            $result_ulasan = mysqli_query($koneksi, $query_ulasan);
    ?>
            <div class="ulasan-container">
                <h2 class="ulasan-header">Ulasan Buku</h2>
                <div class="ulasan-buku">
                    <?php
                    // Periksa apakah ada ulasan yang ditemukan
                    if(mysqli_num_rows($result_ulasan) > 0) {
                        // Mulai iterasi ulasan
                        while($row_ulasan = mysqli_fetch_assoc($result_ulasan)) {
                            $userID = $row_ulasan["userID"];
                            $created_at = $row_ulasan["created_at"];
                            $ulasan = $row_ulasan["ulasan"];

                            // Lakukan kueri SQL untuk mengambil username dari tabel user berdasarkan userID
                            $query_username = "SELECT namalengkap FROM user WHERE userID = $userID";
                            $result_username = mysqli_query($koneksi, $query_username);
                            $row_username = mysqli_fetch_assoc($result_username);
                            $username = $row_username["namalengkap"];
                    ?>
                            <!-- Tampilkan ulasan -->
                            <div class="ulasan">
                                <div class="username"><?php echo $username; ?> <div class="times"><?php echo $created_at; ?></div></div>
                                <div class="ulasan-text"><p><?php echo $ulasan; ?></p></div>
                            </div>
                    <?php
                        }
                        // Akhir iterasi ulasan
                    } else {
                        // Tampilkan pesan jika tidak ada ulasan yang ditemukan
                        echo '<div class="nothing">Belum ada ulasan apapun tentang buku ini.</div>';
                    }
                    ?>
                </div>
            </div>
    <?php
        } else {
            echo "Buku tidak ditemukan.";
        }
    } else {
        echo "ID buku tidak diberikan.";
    }
    ?>
    <script src="../js/batalpinjam.js"></script>
    <script src="../js/pinjambuku.js"></script>
    <script src="../js/ajaxbookmark.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ulasan - Bookshelf.Idn</title>
    <link rel="stylesheet" href="../css/ulasan.css?v=<?php echo time(); ?>">
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

        // Periksa apakah ada data buku yang ditemukan
        if(mysqli_num_rows($result_buku) > 0) {
            // Ambil data buku
            $row_buku = mysqli_fetch_assoc($result_buku);
            $judul_buku = $row_buku["judul"];
            $penulis_buku = $row_buku["penulis"];
            $penerbit_buku = $row_buku["penerbit"];
            $deskripsi_buku = $row_buku["deskripsi"];
            $foto_buku = $row_buku["foto"];
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
                        <div class="pinjam">Pinjam</div>
                        <div class="bookmark"><i class="fa-regular fa-bookmark"></i>Simpan</div>
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
                            $query_username = "SELECT username FROM user WHERE userID = $userID";
                            $result_username = mysqli_query($koneksi, $query_username);
                            $row_username = mysqli_fetch_assoc($result_username);
                            $username = $row_username["username"];
                    ?>
                            <!-- Tampilkan ulasan -->
                            <div class="ulasan">
                                <div class="username"><?php echo $username; ?> <div class="times"><?php echo $created_at; ?></div></div>
                                <div class="ulasan-text"><?php echo $ulasan; ?></div>
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
</body>
</html>

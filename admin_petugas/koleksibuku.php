<?php
require 'function/cek_login.php';
require '../koneksi.php';

// Query untuk mengambil data buku yang disimpan oleh user
$user_id = $_SESSION['user_id'];
$query = "SELECT buku.*, koleksipribadi.* FROM buku INNER JOIN koleksipribadi ON buku.bukuID = koleksipribadi.bukuID WHERE koleksipribadi.userID = $user_id";
$result = mysqli_query($koneksi, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/koleksi.css?v=<?php echo time(); ?>">
    <title>Koleksi - Bookshelf.Idn</title>
</head>
<body>
    <?php require '../sidebar.php'; ?>
    <h1 class="koleksi-header">Buku yang Disimpan</h1>
    <div class="koleksi-container">
        <?php if(mysqli_num_rows($result) == 0) : ?>
            <div class="nothing">Belum ada buku yang disimpan</div>
        <?php else : ?>
            <?php while($row = mysqli_fetch_assoc($result)) : ?>
                <div class="buku">
                    <div class="book-content">
                        <div class="cover-book">
                           <!-- Gunakan foto dari kolom 'foto' dalam tabel buku -->
                            <a href="ulasan.php?id=<?php echo $row['bukuID']; ?>"> <!-- Tambahkan link ke halaman ulasan.php dengan menyertakan bukuID sebagai parameter GET -->
                                <img src="../images/cover-buku/<?php echo $row['foto']; ?>" alt="">
                            </a>
                        </div>
                        <div class="books-title">
                            <div class="judul"><?php echo $row['judul']; ?></div>
                            <div class="penulis"><?php echo $row['penulis']; ?></div>
                        </div>
                    </div>
                    <div class="action-btn">
                        <div class="pinjam">Pinjam</div>
                        <div class="remove" onclick="removeBookmark(<?php echo $row['bukuID']; ?>)"><i class="fa-solid fa-bookmark"></i>Remove</div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>

    <!-- Bookmark JS -->
    <script src="../js/ajaxbookmark.js"></script>
</body>
</html>

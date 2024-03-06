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
    <?php require 'navbar.php'?>
    <h1 class="koleksi-header">Buku yang Disimpan</h1>
    <div class="koleksi-container">
        <?php if(mysqli_num_rows($result) == 0) : ?>
            <div class="nothing">Belum ada buku yang disimpan</div>
        <?php else : ?>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <?php
                // Query untuk memeriksa status pinjam buku berdasarkan bukuID dan userID
                $peminjamanQuery = "SELECT * FROM peminjaman WHERE bukuID = {$row['bukuID']} AND userID = {$_SESSION['user_id']}";
                $peminjamanResult = mysqli_query($koneksi, $peminjamanQuery);
                $idbuku = $row['bukuID'];

                // Periksa status peminjaman buku
                $btnClass = '';

                // Periksa status peminjaman buku dan stok buku
                $btnClass = 'pinjam'; // Default button class
                $stokQuery = "SELECT stok FROM buku WHERE bukuID = $idbuku";
                $stokResult = mysqli_query($koneksi, $stokQuery);

                if (mysqli_num_rows($stokResult) > 0) {
                    $stokData = mysqli_fetch_assoc($stokResult);
                    $stok = $stokData['stok'];
                }

                $peminjamanQuery = "SELECT status_pinjam, userID FROM peminjaman WHERE bukuID = $idbuku  AND userID = $user_id";
                $peminjamanResult = mysqli_query($koneksi, $peminjamanQuery);

                if (mysqli_num_rows($peminjamanResult) > 0) {
                    $btnClass = 'pinjam'; // Set default button class
                    while ($peminjamanData = mysqli_fetch_assoc($peminjamanResult)) {
                        if ($peminjamanData['status_pinjam'] == 'dipinjam') {
                            $btnClass = 'dipinjam';
                            // Jika status dipinjam ditemukan, keluar dari loop
                            break;
                        } elseif ($peminjamanData['status_pinjam'] == 'dikembalikan') {
                            $btnClass = 'pinjam';
                        }
                    }
                }

                if ($btnClass == 'pinjam' && $stok == 0) {
                    $btnClass = 'habis';
                }
                ?>
                <script>
                    console.log("User ID: <?php echo $_SESSION['user_id']; ?>, Buku ID: <?php echo $row['bukuID']; ?>, Status Pinjam: <?php echo isset($status_pinjam) ? $status_pinjam : ''; ?>, Button Class: <?php echo $btnClass; ?>");
                </script>
                <div class="buku">
                    <div class="book-content">
                        <div class="cover-book">
                            <a href="ulasan.php?id=<?php echo $row['bukuID']; ?>">
                                <img src="../images/cover-buku/<?php echo $row['foto']; ?>" alt="">
                            </a>
                        </div>
                        <div class="books-title">
                            <div class="judul"><?php echo $row['judul']; ?></div>
                            <div class="penulis"><?php echo $row['penulis']; ?></div>
                        </div>
                    </div>
                    <div class="action-btn">
                        <?php if ($btnClass === 'dipinjam') : ?>
                            <div class="<?php echo $btnClass; ?>">Dipinjam</div>
                        <?php elseif ($btnClass === 'habis') : ?>
                            <div class="<?php echo $btnClass; ?>">Mencapai Batas</div>
                        <?php else : ?>
                            <div class="<?php echo $btnClass; ?>" onclick="pinjamBuku(<?php echo $row['bukuID']; ?>, <?php echo $row['perpusID']; ?>, <?php echo $_SESSION['user_id']; ?>)">Pinjam</div>
                        <?php endif; ?>
                        <div class="remove" onclick="removeBookmark(<?php echo $row['bukuID']; ?>)"><i class="fa-solid fa-bookmark"></i>Hapus</div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>

    <!-- Peminjaman JS -->
    <script src="../js/konfirmpinjam.js"></script>
    <!-- Bookmark JS -->
    <script src="../js/ajaxbookmark.js"></script>
</body>
</html>

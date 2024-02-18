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
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <?php
                // Query untuk memeriksa status pinjam buku berdasarkan bukuID dan userID
                $peminjamanQuery = "SELECT * FROM peminjaman WHERE bukuID = {$row['bukuID']} AND userID = {$_SESSION['user_id']}";
                $peminjamanResult = mysqli_query($koneksi, $peminjamanQuery);

                // Inisialisasi tombol aksi sebagai "pinjam" secara default
                $btnClass = 'pinjam';

                // Jika ditemukan peminjaman dengan bukuID tersebut
                if (mysqli_num_rows($peminjamanResult) > 0) {
                    $peminjamanData = mysqli_fetch_assoc($peminjamanResult);
                    $status_pinjam = $peminjamanData['status_pinjam'];

                    // Jika status pinjam adalah "diajukan" dan user yang login sesuai dengan userID pada peminjaman
                    if ($status_pinjam === 'diajukan' && $_SESSION['user_id'] == $peminjamanData['userID']) {
                        $btnClass = 'diajukan';
                    }
                } else {
                    // Jika tidak ditemukan peminjaman, cek apakah ada buku dengan status "tertunda" atau "dipinjam"
                    $cekPeminjamanQuery = "SELECT * FROM peminjaman WHERE bukuID = {$row['bukuID']} AND (status_pinjam = 'tertunda' OR status_pinjam = 'dipinjam')";
                    $cekPeminjamanResult = mysqli_query($koneksi, $cekPeminjamanQuery);
                    
                    // Jika ditemukan peminjaman dengan status "tertunda" atau "dipinjam"
                    if (mysqli_num_rows($cekPeminjamanResult) > 0) {
                        $btnClass = 'dipinjam';
                    }
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
                        <?php if ($btnClass === 'diajukan') : ?>
                            <div class="<?php echo $btnClass; ?>" onclick="batalkanPeminjaman(<?php echo $row['bukuID']; ?>, <?php echo $_SESSION['user_id']; ?>)">Diajukan</div>
                        <?php elseif ($btnClass === 'dipinjam') : ?>
                            <div class="<?php echo $btnClass; ?>">Dipinjam</div>
                        <?php else : ?>
                            <div class="<?php echo $btnClass; ?>" onclick="pinjamBuku(<?php echo $row['bukuID']; ?>, <?php echo $row['perpusID']; ?>, <?php echo $_SESSION['user_id']; ?>)">Pinjam</div>
                        <?php endif; ?>
                        <div class="remove" onclick="removeBookmark(<?php echo $row['bukuID']; ?>)"><i class="fa-solid fa-bookmark"></i>Remove</div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>

    <!-- Peminjaman JS -->
    <script src="../js/batalpinjam.js"></script>
    <script src="../js/pinjambuku.js"></script>
    <!-- Bookmark JS -->
    <script src="../js/ajaxbookmark.js"></script>
</body>
</html>

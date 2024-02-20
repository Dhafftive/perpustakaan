<?php
include '../koneksi.php';
require 'function/cek_login.php';

// Query untuk mendapatkan semua peminjaman user berdasarkan userID dari session
$userID = $_SESSION['user_id'];
$pengajuanQuery = "SELECT * FROM peminjaman WHERE userID = $userID";
$pengajuanResult = mysqli_query($koneksi, $pengajuanQuery);
// Query untuk mendapatkan semua peminjaman user berdasarkan userID dari session
$userID = $_SESSION['user_id'];
$pinjamQuery = "SELECT * FROM peminjaman WHERE userID = $userID";
$pinjamResult = mysqli_query($koneksi, $pinjamQuery);
// Query untuk mendapatkan semua peminjaman yang telah dikembalikan oleh user
$userID = $_SESSION['user_id'];
$peminjamanQuery = "SELECT peminjaman.peminjamanID, peminjaman.tanggal_kembali, buku.judul, buku.penulis, buku.penerbit, buku.foto, buku.bukuID
                    FROM peminjaman
                    INNER JOIN buku ON peminjaman.bukuID = buku.bukuID
                    WHERE peminjaman.status_pinjam = 'dikembalikan' AND peminjaman.userID = $userID";
$peminjamanResult = mysqli_query($koneksi, $peminjamanQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Anda - Bookshelf.Idn</title>
    <link rel="stylesheet" href="../css/yourbook.css?v=<?= time() ?>">
</head>
<body>
    <?php include '../sidebar.php'; ?>

    <div class="data-buku">
        <!-- Buku yang sedang diajukan -->
        <div class="pengajuan-cont">
            <div class="pengajuan-hdr">
                <h1 class="header">Buku yang Diajukan</h1>
            </div>
            <div class="pengajuan">
                <?php while ($rowPengajuan = mysqli_fetch_assoc($pengajuanResult)): ?>
                    <?php if ($rowPengajuan['status_pinjam'] === 'diajukan'): ?>
                        <?php
                        // Ambil informasi buku dari tabel buku berdasarkan bukuID
                        $bukuID = $rowPengajuan['bukuID'];
                        $bukuQuery = "SELECT * FROM buku WHERE bukuID = $bukuID";
                        $bukuResult = mysqli_query($koneksi, $bukuQuery);
                        ?>
                        <?php if (mysqli_num_rows($bukuResult) > 0): ?>
                            <?php while ($rowBuku = mysqli_fetch_assoc($bukuResult)): ?>
                                <div class="books-content">
                                    <div class="books">
                                        <div class="books-cover">
                                            <a href="ulasanbuku.php?bukuID=<?= $rowBuku['bukuID'] ?>">
                                                <img src="../images/cover-buku/<?= $rowBuku['foto'] ?>" alt="">
                                            </a>
                                        </div>
                                        <div class="books-title">
                                            <div class="judul"><?= $rowBuku['judul'] ?></div>
                                            <div class="penulis"><?= $rowBuku['penulis'] ?></div>
                                        </div>
                                    </div>
                                    <div class="action-btn">
                                        <div class="batalkan-btn" onclick="batalkanPeminjaman(<?php echo $rowBuku['bukuID']; ?>, <?php echo $_SESSION['user_id']; ?>)">Batalkan</div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endwhile; ?>
            </div>
        </div>
    
        <!-- Buku yang sedang dipinjam -->
        <div class="yourbook-cont">
            <div class="yourbook-hdr">
                <h1 class="header">Buku yang Anda Pinjam</h1>
            </div>
            <div class="yourbook">
                <?php while ($rowpinjam = mysqli_fetch_assoc($pinjamResult)) : ?>
                    <?php if ($rowpinjam['status_pinjam'] === 'dipinjam') : ?>
                        <?php
                        // Ambil informasi buku dari tabel buku berdasarkan bukuID
                        $bukuID = $rowpinjam['bukuID'];
                        $bukuQuery = "SELECT * FROM buku WHERE bukuID = $bukuID";
                        $bukuResult = mysqli_query($koneksi, $bukuQuery);
                        ?>
                        <?php while ($rowBuku = mysqli_fetch_assoc($bukuResult)) : ?>
                            <div class="books-content">
                                <div class="books">
                                    <div class="books-cover">
                                        <a href="ulasanbuku.php?bukuID=<?= $rowBuku['bukuID'] ?>">
                                            <img src="../images/cover-buku/<?= $rowBuku['foto'] ?>" alt="">
                                        </a>
                                    </div>
                                    <div class="books-title">
                                        <div class="judul"><?= $rowBuku['judul'] ?></div>
                                        <div class="penulis"><?= $rowBuku['penulis'] ?></div>
                                    </div>
                                </div>
                                <div class="action-btn">
                                    <div class="kembalikan-btn"  onclick="kembalikanPeminjaman(<?php echo $rowpinjam['peminjamanID']; ?>)">Kembalikan</div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                <?php endwhile; ?>
            </div>
        </div>
        
        <!-- Data Peminjaman Selama Ini -->
        <div class="data-peminjaman">
            <div class="data-pinjam-hdr">
                <h1 class="header">Data Peminjaman Anda Selama Ini</h1>
            </div>
            <div class="data-pinjam-cont">
                <?php while ($rowPeminjaman = mysqli_fetch_assoc($peminjamanResult)): ?>
                    <div class="data-pinjam">
                        <a href="ulasan.php?id=<?php echo $rowPeminjaman['bukuID']; ?>">
                            <div class="cover-book">
                                <img src="../images/cover-buku/<?php echo $rowPeminjaman['foto']; ?>" alt="">
                            </div>
                        </a>
                        <div class="title-desc">
                            <div class="title">
                                <div class="judul"><?php echo $rowPeminjaman['judul']; ?></div>
                                <div class="penulis"><?php echo $rowPeminjaman['penulis']; ?></div>
                                <div class="penerbit"><?php echo $rowPeminjaman['penerbit']; ?></div>
                            </div>
                            <div class="desc">
                                <?php
                                    // Hitung rata-rata rating buku
                                    $bukuID = $rowPeminjaman['bukuID'];
                                    $ratingQuery = "SELECT AVG(rating) AS avg_rating FROM ulasanbuku WHERE bukuID = $bukuID";
                                    $ratingResult = mysqli_query($koneksi, $ratingQuery);
                                    $avgRating = mysqli_fetch_assoc($ratingResult)['avg_rating'];
                                    $formattedRating = $avgRating ? number_format($avgRating, 1) : '0.0';
                                ?>
                                <div class="rate"><i class="fa-solid fa-star"></i><?php echo $formattedRating; ?></div>
                                <div class="tanggal-kembali"><?php echo date('d F Y', strtotime($rowPeminjaman['tanggal_kembali'])); ?></div>
                                <div class="label-kembali">Dikembalikan</div>
                            </div>
                        </div>
                        <div class="ulasan-btn">
                            <a href="beri-ulasan.php?peminjamanID=<?php echo $rowPeminjaman['peminjamanID']; ?>">
                                <div class="beri-ulasan"><i class="fa-solid fa-comments"></i>Kasih Ulasan</div>
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>

    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.querySelector('.pengajuan');
            const pinjamScrollbar = new PerfectScrollbar(container);
        });

        document.addEventListener('DOMContentLoaded', function() {
            const container = document.querySelector('.yourbook');
            const kembalikanScrollbar = new PerfectScrollbar(container);
        });
    </script>
    <script src="../js/requestkembalikan.js"></script>
    <script src="../js/batalpinjam.js"></script>
    <script src="../libs/perfect-scrollbar/dist/perfect-scrollbar.js"></script>
</body>
</html>

<?php
include '../koneksi.php';
require 'function/cek_login.php';

// Query untuk mendapatkan semua peminjaman user berdasarkan userID dari session
$userID = $_SESSION['user_id'];
$pinjamQuery = "SELECT * FROM peminjaman WHERE userID = $userID";
$pinjamResult = mysqli_query($koneksi, $pinjamQuery);
// Query untuk mendapatkan semua peminjaman yang telah dikembalikan oleh user
$userID = $_SESSION['user_id'];
$peminjamanQuery = "SELECT peminjaman.peminjamanID, peminjaman.tanggal_kembali, buku.judul, buku.penulis, buku.penerbit, buku.foto, buku.bukuID
                    FROM peminjaman
                    INNER JOIN buku ON peminjaman.bukuID = buku.bukuID
                    WHERE peminjaman.status_pinjam = 'dikembalikan' AND peminjaman.userID = $userID
                    ORDER BY peminjaman.tanggal_kembali DESC"; // Urutkan berdasarkan tanggal_kembali secara descending
$peminjamanResult = mysqli_query($koneksi, $peminjamanQuery);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Anda - Bookshelf.Idn</title>
    <link rel="stylesheet" href="../css/yourbook.css?v=<?= time() ?>">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>


</head>
<body>
    <?php include '../sidebar.php'; ?>
    <?php include 'navbar.php'; ?>

    <div class="data-buku">
        <!-- Buku yang sedang dipinjam -->
        <div class="yourbook-cont">
            <div class="yourbook-hdr">
                <h1 class="header">Buku yang Anda Pinjam</h1>
            </div>
            <div class="yourbook">
                <?php
                // Variable untuk menandai apakah ada peminjaman atau tidak
                $peminjamanExist = false;

                while ($rowpinjam = mysqli_fetch_assoc($pinjamResult)) :
                    if ($rowpinjam['status_pinjam'] === 'dipinjam') :
                        // Set peminjamanExist menjadi true jika ada peminjaman
                        $peminjamanExist = true;
                        // Ambil informasi buku dari tabel buku berdasarkan bukuID
                        $bukuID = $rowpinjam['bukuID'];
                        $bukuQuery = "SELECT * FROM buku WHERE bukuID = $bukuID";
                        $bukuResult = mysqli_query($koneksi, $bukuQuery);
                        while ($rowBuku = mysqli_fetch_assoc($bukuResult)) :
                ?>
                            <div class="books-content">
                                <div class="books">
                                    <div class="books-cover">
                                        <a href="ulasan.php?id=<?php echo $rowBuku['bukuID'] ?>">
                                            <img src="../images/cover-buku/<?= $rowBuku['foto'] ?>" alt="">
                                        </a>
                                    </div>
                                    <div class="books-title">
                                        <div class="judul"><?= $rowBuku['judul'] ?></div>
                                        <div class="penulis"><?= $rowBuku['penulis'] ?></div>
                                    </div>
                                </div>
                                <div class="action-btn">
                                    <a href="funtion/baca_buku.php?id=<?= $rowBuku['bukuID']; ?>" target="_blank">
                                        <div class="baca-btn">Baca</div>
                                    </a>
                                    <div class="kembalikan-btn" onclick="kembalikanPeminjaman(<?php echo $rowpinjam['peminjamanID']; ?>)">Kembalikan</div>
                                </div>
                            </div>
                <?php
                        endwhile;
                    endif;
                endwhile;

                // Jika tidak ada peminjaman, tampilkan teks "Belum ada buku yang anda pinjam saat ini"
                if (!$peminjamanExist) :
                ?>
                    <p style="color: #999; font-style: italic;">Belum ada buku yang anda pinjam saat ini</p>
                <?php endif; ?>
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
                        <a href="javascript:void(0);">
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
                            <?php
                                $peminjamanID = $rowPeminjaman['peminjamanID'];
                                $cekUlasanQuery = "SELECT * FROM ulasanbuku WHERE peminjamanID = $peminjamanID";
                                $cekUlasanResult = mysqli_query($koneksi, $cekUlasanQuery);
                                if (mysqli_num_rows($cekUlasanResult) > 0) {
                                    // Jika terdapat ulasan, tampilkan kelas 'diulas'
                                    echo '<div class="diulas">Telah Diulas</div>';
                                } else {
                                    // Jika tidak terdapat ulasan, tampilkan kelas 'beri-ulasan'
                                    echo '<a href="beri-ulasan.php?peminjamanID='.$rowPeminjaman['peminjamanID'].'"><div class="beri-ulasan"><i class="fa-solid fa-comments"></i>Kasih Ulasan</div></a>';
                                }
                            ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
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
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.querySelector('.data-pinjam-cont');
            const peminjamanScrollbar = new PerfectScrollbar(container);
        });
    </script>
    <script src="../js/request_kembalikan.js"></script>
    <script src="../libs/perfect-scrollbar/dist/perfect-scrollbar.js"></script>
</body>
</html>

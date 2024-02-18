<?php
// Koneksi ke database
include '../koneksi.php';

// Kueri SQL untuk mengambil data
$ajukansql = "SELECT peminjaman.peminjamanID, peminjaman.userID, peminjaman.bukuID, buku.judul, buku.foto, user.namalengkap
        FROM peminjaman
        INNER JOIN buku ON peminjaman.bukuID = buku.bukuID
        INNER JOIN user ON peminjaman.userID = user.userID
        WHERE peminjaman.status_pinjam = 'diajukan'";
// Eksekusi kueri
$ajukanresult = mysqli_query($koneksi, $ajukansql);
// Kueri SQL untuk mengambil data
$sqltertunda = "SELECT peminjaman.peminjamanID, peminjaman.userID, peminjaman.bukuID, buku.judul, buku.foto, user.namalengkap
        FROM peminjaman
        INNER JOIN buku ON peminjaman.bukuID = buku.bukuID
        INNER JOIN user ON peminjaman.userID = user.userID
        WHERE peminjaman.status_pinjam = 'tertunda'";
// Eksekusi kueri
$tertundaresult = mysqli_query($koneksi, $sqltertunda);
// Kueri SQL untuk mengambil data
$peminjamansql = "SELECT peminjaman.peminjamanID, peminjaman.userID, peminjaman.tanggal_pinjam, peminjaman.tanggal_kembali, peminjaman.status_pinjam, peminjaman.bukuID, buku.judul, buku.foto, user.namalengkap
        FROM peminjaman
        INNER JOIN buku ON peminjaman.bukuID = buku.bukuID
        INNER JOIN user ON peminjaman.userID = user.userID
        WHERE peminjaman.status_pinjam != 'diajukan'";
// Eksekusi kueri
$resultPeminjaman = mysqli_query($koneksi, $peminjamansql);


// Menutup koneksi database
mysqli_close($koneksi);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman - Bookshelf.Idn</title>
    <link rel="stylesheet" href="../css/peminjaman.css?v=<?php echo time(); ?>">
</head>
<body>
    <?php require '../sidebar.php'?>
    <div class="data-konfirmasi">
        <!-- Peminjaman -->
        <div class="peminjaman-container">
            <div class="pinjam-hdr">
                <h1 class="header">Peminjaman</h1>
            </div>
            <div class="pinjam-confirm">
            <?php if (mysqli_num_rows($ajukanresult) > 0) : ?>
                <?php while ($rowpengajuan = mysqli_fetch_assoc($ajukanresult)) : ?>
                <div class="buku-content">
                        <div class="buku">
                            <div class="cover-img">
                                <img src="../images/cover-buku/<?php echo $rowpengajuan['foto']; ?>" alt="">
                            </div>
                            <div class="book-title">
                                <div class="judul"><?php echo $rowpengajuan['judul']; ?></div>
                                <div class="peminjam"><?php echo $rowpengajuan['namalengkap']; ?></div>
                            </div>
                        </div>
                        <div class="konfirmasi-btn">Konfirmasi</div>
                    </div>
                    <?php endwhile; ?>
            <?php else : ?>
                <div class="diajukan-nothing">Tidak ada peminjaman diajukan</div>
            <?php endif; ?>
            </div>
        </div>

        <!-- Pengembalian -->
        <div class="pengembalian-container">
            <div class="kembalikan-hdr">
                <h1 class="header">Pengembalian</h1>
            </div>
            <div class="kembalikan-confirm">
            <?php if (mysqli_num_rows($tertundaresult) > 0) : ?>
                <?php while ($rowtertunda = mysqli_fetch_assoc($tertundaresult)) : ?>
                <div class="buku-content">
                    <div class="buku">
                        <div class="cover-img">
                            <img src="../images/cover-buku/<?php echo $rowtertunda['foto']; ?>" alt="">
                        </div>
                        <div class="book-title">
                            <div class="judul"><?php echo $rowtertunda['judul']; ?></div>
                            <div class="peminjam"><?php echo $rowtertunda['namalengkap']; ?></div>
                        </div>
                    </div>
                    <div class="konfirmasi-btn">Konfirmasi</div>
                </div>
                <?php endwhile; ?>
            <?php else : ?>
                <div class="tertunda-nothing">Belum ada buku dikembalikan</div>
            <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="data-peminjaman">
        <div class="card">
            <h5 class="card-header">Data Peminjaman Buku</h5>
            <div class="table-responsive">
                <table class="table-hover">
                    <thead class="head-table">
                        <tr>
                            <th>Judul Buku</th>
                            <th>Nama Lengkap</th>
                            <th>Tanggal Pinjam</th>
                            <th>Status</th>
                            <th>Tanggal Kembali</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-body">
                    <?php if (mysqli_num_rows($resultPeminjaman) > 0) : ?>
                        <?php while ($row = mysqli_fetch_assoc($resultPeminjaman)) : ?>
                            <?php
                                // Determine status label based on status_pinjam
                                $statusLabel = '';
                                if ($row['status_pinjam'] === 'tertunda') {
                                    $statusLabel = '<div class="tertunda-label">Tertunda</div>';
                                } elseif ($row['status_pinjam'] === 'dikembalikan') {
                                    $statusLabel = '<div class="dikembalikan-label">Dikembalikan</div>';
                                } elseif ($row['status_pinjam'] === 'dipinjam') {
                                    $statusLabel = '<div class="dipinjam-label">Dipinjam</div>';
                                }
                            ?>
                            <tr>
                                <td><?= $row['judul'] ?></td>
                                <td><?= $row['namalengkap'] ?></td>
                                <td>
                                <?php
                                    // Ubah format tanggal pinjam jika tidak kosong
                                    if ($row['tanggal_pinjam'] != '0000-00-00') {
                                        echo date('d F Y', strtotime($row['tanggal_pinjam']));
                                    } else {
                                        echo '-';
                                    }
                                ?>
                                </td>
                                <td><?= $statusLabel ?></td>
                                <td>
                                <?php
                                    // Ubah format tanggal kembali jika tidak kosong
                                    if ($row['tanggal_kembali'] != '0000-00-00') {
                                        echo date('d F Y', strtotime($row['tanggal_kembali']));
                                    } else {
                                        echo '-';
                                    }
                                ?>
                                </td>
                                <td>
                                    <div class="delete">
                                        <button type="button">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else : ?>
                            <tr>
                                <td colspan="6" class="data-nothing" style="text-align: center; color: grey; font-style: italic;">Tidak ada data peminjaman apapun</td>
                            </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.querySelector('.pinjam-confirm');
            const pinjamScrollbar = new PerfectScrollbar(container);
        });

        document.addEventListener('DOMContentLoaded', function() {
            const container = document.querySelector('.kembalikan-confirm');
            const kembalikanScrollbar = new PerfectScrollbar(container);
        });
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.querySelector('.table-responsive');
            const tableScrollbar = new PerfectScrollbar(container);
        });
    </script>
    <script src="../libs/perfect-scrollbar/dist/perfect-scrollbar.js"></script>
</body>
</html>
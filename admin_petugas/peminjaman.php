<?php
// Koneksi ke database
include '../koneksi.php';
require 'function/cek_login.php';

// Kueri SQL untuk menghitung jumlah peminjaman yang masih dipinjam
$jumlahPeminjamanDipinjamSQL = "SELECT COUNT(*) AS total FROM peminjaman WHERE status_pinjam = 'dipinjam'";
$resultJumlahPeminjamanDipinjam = mysqli_query($koneksi, $jumlahPeminjamanDipinjamSQL);
$totalPeminjamanDipinjam = mysqli_fetch_assoc($resultJumlahPeminjamanDipinjam)['total'];

// Kueri SQL untuk menghitung jumlah peminjaman yang harus dikembalikan hari ini
$today = date("Y-m-d");
$jumlahPeminjamanHariIniSQL = "SELECT COUNT(*) AS total FROM peminjaman WHERE status_pinjam = 'dipinjam' AND tanggal_kembali = '$today'";
$resultJumlahPeminjamanHariIni = mysqli_query($koneksi, $jumlahPeminjamanHariIniSQL);
$totalPeminjamanHariIni = mysqli_fetch_assoc($resultJumlahPeminjamanHariIni)['total'];


// Kueri SQL untuk mengambil data
$ajukansql = "SELECT peminjaman.peminjamanID, peminjaman.userID, peminjaman.bukuID, buku.judul, buku.foto, user.namalengkap
        FROM peminjaman
        INNER JOIN buku ON peminjaman.bukuID = buku.bukuID
        INNER JOIN user ON peminjaman.userID = user.userID
        WHERE peminjaman.status_pinjam = 'dipinjam'";
// Eksekusi kueri
$ajukanresult = mysqli_query($koneksi, $ajukansql);
// Kueri SQL untuk mengambil data
$peminjamansql = "SELECT peminjaman.peminjamanID, peminjaman.userID, peminjaman.tanggal_pinjam, peminjaman.tanggal_kembali, peminjaman.status_pinjam, peminjaman.bukuID, buku.judul, buku.foto, user.namalengkap
        FROM peminjaman
        INNER JOIN buku ON peminjaman.bukuID = buku.bukuID
        INNER JOIN user ON peminjaman.userID = user.userID
        WHERE peminjaman.status_pinjam = 'dipinjam' OR peminjaman.status_pinjam = 'dikembalikan'
        ORDER BY peminjaman.tanggal_pinjam DESC";

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
    <?php require 'navbar.php'?>
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
                        <!-- <div class="kembalikan-btn" onclick="konfirmasiPengembalian(<?= $rowpengajuan['peminjamanID']?>)">Kembalikan</div> -->
                    </div>
                <?php endwhile; ?>
            <?php else : ?>
                <div class="diajukan-nothing">Tidak ada peminjaman diajukan</div>
            <?php endif; ?>
            </div>
            <div class="peminjaman-info">
                <div class="deadline-cont">
                    <div class="deadline-data">
                        <div class="deadline-hdr">Buku yang harus dikembalikan hari ini : <span class="total-buku"><?php echo $totalPeminjamanHariIni > 0 ? $totalPeminjamanHariIni : 'Belum ada'; ?> Buku</span></div>
                    </div>
                    <div class="deadline-btn" onclick="kembalikanBuku()">Kembalikan</div>
                </div>
                <div class="total-peminjaman-cont">
                    <div class="total-header">Total peminjaman buku saat ini</div>
                    <div class="total-data"><?php echo $totalPeminjamanDipinjam; ?> Buku</div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- Script Peminjaman -->
    <script>
        function kembalikanBuku() {
            // Kirim permintaan AJAX
            $.ajax({
                type: "POST",
                url: "function/update_peminjaman.php",
                data: {
                    tanggal_sekarang: '<?php echo date("Y-m-d"); ?>'
                },
                success: function(response) {
                    // Tampilkan pesan sukses atau error dengan SweetAlert
                    if (response === "success") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Peminjaman berhasil diperbarui.',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            // Refresh halaman
                            location.reload();
                        });
                    } else if (response === "no_book") {
                        Swal.fire({
                            icon: 'info',
                            title: 'Belum ada buku yang harus dikembalikan.',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal memperbarui peminjaman.',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi kesalahan saat mengirim permintaan.',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        }
    </script>
    <!-- Script Rekap data peminjaman -->
    <script>
        $(document).ready(function() {
            $('.delete-btn').on('click', function() {
                var peminjamanID = $(this).data('peminjamanid');
                deletePeminjaman(peminjamanID);
            });
        });

        function deletePeminjaman(peminjamanID) {
            Swal.fire({
                title: "Konfirmasi Penghapusan",
                text: "Apakah Anda yakin ingin menghapus peminjaman ini?",
                icon: "warning",
                showCancelButton: true,
                cancelButtonText: "Batal",
                confirmButtonText: "Ya",
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim permintaan AJAX
                    $.ajax({
                        type: "POST",
                        url: "function/hapus_peminjaman.php",
                        data: {
                            peminjamanID: peminjamanID
                        },
                        success: function(response) {
                            if (response === "success") {
                                Swal.fire({
                                    icon: "success",
                                    title: "Peminjaman berhasil dihapus.",
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(() => {
                                    // Refresh halaman
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: "Oops...",
                                    text: "Ada kesalahan saat memproses permintaan."
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Terjadi kesalahan saat mengirim permintaan."
                            });
                        }
                    });
                }
            });
        }



        document.addEventListener('DOMContentLoaded', function() {
            const container = document.querySelector('.pinjam-confirm');
            const pinjamScrollbar = new PerfectScrollbar(container);
        });

        document.addEventListener('DOMContentLoaded', function() {
            const container = document.querySelector('.table-responsive');
            const tableScrollbar = new PerfectScrollbar(container);
        });

    </script>
    <!-- SweetAlert2 JS -->
    <script src="../libs/perfect-scrollbar/dist/perfect-scrollbar.js"></script>
    <script>
        function downloadExcel() {
            window.location.href = 'download_excel.php';
        }
    </script>

</body>
</html>
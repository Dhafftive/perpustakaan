<?php
// Koneksi ke database
include '../koneksi.php';
require 'function/cek_login.php';

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
    <title>Rekap Data Peminjaman</title>
    <link rel="stylesheet" href="../css/rekap-peminjaman.css?v=<?php echo time(); ?>">
</head>
<body>
    <?php require '../sidebar.php'?>
    <?php require 'navbar.php'?>
    <div class="data-peminjaman">
        <div class="card">
            <h5 class="card-header">Data Peminjaman Buku  
                <div class="filter-data">
                    <div class="filter-input">
                        <div class="tanggal-awal"><input type="date" id="tanggal-awal" name="tanggal-awal"></div>
                        <div class="tanggal-akhir"><input type="date" id="tanggal-akhir" name="tanggal-akhir"></div>
                        <button onclick="filterTanggal()" class="filter-btn">Filter</button>
                    </div>
                    <div class="download-btn" onclick="downloadExcel()" style="font-size: 16px;"><i class="fa-solid fa-file-arrow-down"></i></div>
                </div>
            </h5>
            <div class="table-responsive">
                <table class="table-hover" id="bookTable">
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
                                if ($row['status_pinjam'] === 'dikembalikan') {
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
                                    <div class="delete-btn" data-peminjamanid="<?= $row['peminjamanID'] ?>">
                                        <button type="button" class="delete">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- Script Rekap data peminjaman -->
    <script>
function filterTanggal() {
    var start = document.getElementById("tanggal-awal").value;
    var end = document.getElementById("tanggal-akhir").value;
    var table = document.getElementById("bookTable");
    var rows = table.getElementsByTagName("tr");
    
    for (var i = 1; i < rows.length; i++) {
        var row = rows[i];
        var borrowCell = row.getElementsByTagName("td")[2]; // Mengubah index menjadi 1 karena kita ingin memeriksa tanggal pinjam
        var borrowDate = new Date(borrowCell.textContent);
        var rowVisible = true;
        
        if (start) {
            if (borrowDate < new Date(start)) {
                rowVisible = false;
            }
        }
        
        if (end) {
            if (borrowDate > new Date(end)) {
                rowVisible = false;
            }
        }
        
        // Menambahkan kondisi untuk memeriksa apakah tanggal pinjam sama dengan tanggal awal atau akhir
        if (borrowDate.toDateString() === new Date(start).toDateString() || borrowDate.toDateString() === new Date(end).toDateString()) {
            rowVisible = true;
        }
        
        if (rowVisible) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    }
}
</script>


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
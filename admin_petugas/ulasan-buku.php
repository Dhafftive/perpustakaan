<?php 
    require '../koneksi.php';
    require 'function/cek_login.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ulasan Buku</title>
    <link rel="stylesheet" href="../css/ulasan-buku.css?v=<?php echo time(); ?>">

</head>
<body>
<?php 
    require '../sidebar.php';
?>
    <div class="ulasan-header">
        <h1 class="header">Data Ulasan Buku</h1>
    </div>
    <div class="data-ulasan">
        <div class="ulasan-cont">
            <div class="ulasan-user">
    <?php
    // Mengambil ID dari URL
        if(isset($_GET['id'])) {
            $bukuID = $_GET['id'];
    
            // Mengambil data ulasan berdasarkan bukuID
            $sql = " SELECT ub.*, u.namalengkap
                    FROM ulasanbuku ub
                    INNER JOIN user u ON ub.userID = u.userID
                    WHERE ub.bukuID = ? AND ub.ulasan <> ''";
    
            $stmt = $koneksi->prepare($sql);
            $stmt->bind_param("i", $bukuID);
            $stmt->execute();
            $result = $stmt->get_result();
    
            // Memeriksa apakah ada ulasan yang ditemukan
            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) { ?>
                    <div class="ulasan-card">
                        <div class="ulasan-desc">
                            <div class="username"><?php echo $row['namalengkap']; ?> <div class="delete-btn" data-ulasanid="<?php echo $row['ulasanID']; ?>"><i class="fa-regular fa-trash-can"></i></div></div>
                            <div class="ulasan-text"><?php echo $row['ulasan']; ?></div>
                        </div>
                    </div>
                <?php }
            } else {
                echo "Tidak ada ulasan untuk buku ini.";
            }
            $stmt->close();
        } else {
            echo "ID buku tidak ditemukan.";
        }
    ?>
         
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Fungsi untuk menghapus ulasan berdasarkan ulasanID
        function hapusUlasan(ulasanID) {
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin menghapus ulasan ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim permintaan AJAX untuk menghapus ulasan
                    $.ajax({
                        type: 'POST',
                        url: 'function/delete-ulasan.php', // Ganti 'hapus_ulasan.php' dengan nama file PHP yang sesuai
                        data: {
                            ulasanID: ulasanID
                        },
                        success: function(response) {
                            // Tampilkan notifikasi sukses
                            Swal.fire({
                                title: 'Berhasil',
                                text: 'Ulasan berhasil dihapus!',
                                icon: 'success'
                            }).then(() => {
                                // Muat ulang halaman setelah menutup notifikasi
                                location.reload();
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error(error); // Cetak pesan kesalahan ke console
                            // Tampilkan pesan kesalahan
                            Swal.fire({
                                title: 'Gagal',
                                text: 'Terjadi kesalahan saat menghapus ulasan: ' + error,
                                icon: 'error'
                            });
                        }
                    });
                }
            });
        }

        // Mengikat fungsi hapusUlasan pada setiap tombol hapus
        $(document).ready(function() {
            $('.delete-btn').click(function() {
                // Dapatkan ulasanID dari atribut data
                var ulasanID = $(this).data('ulasanid');
                hapusUlasan(ulasanID);
            });
        });
    </script>

</body>
</html>
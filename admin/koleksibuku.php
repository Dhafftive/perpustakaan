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
    <script>
        // Fungsi untuk menghapus buku dari koleksi pribadi
        function removeBookmark(bukuID) {
            // Lakukan request Ajax
            $.ajax({
                type: 'POST',
                url: 'function/removebookmark.php', // Ganti 'removebookmark.php' dengan nama file PHP yang sesuai
                data: { bukuID: bukuID }, // Kirim data bukuID
                success: function(response) {
                    // Tampilkan notifikasi SweetAlert
                    Swal.fire({
                        title: 'Berhasil',
                        text: 'Buku berhasil dihapus dari koleksi pribadi!',
                        icon: 'success',
                        customClass: {
                            container: 'sweetalert-font sweetalert-background',
                            title: 'sweetalert-title',
                            content: 'sweetalert-text'
                        }
                    }).then(() => {
                        // Setelah SweetAlert ditutup, muat ulang halaman untuk memperbarui tampilan buku
                        console.log(response);
                        location.reload();
                    });
                },
                error: function(xhr, status, error) {
                    // Tangkap pesan kesalahan dari server
                    var errorMessage = xhr.responseText;
                    console.error(errorMessage);
                    // Tampilkan pesan kesalahan menggunakan SweetAlert
                    Swal.fire({
                        title: 'Gagal',
                        text: 'Terjadi kesalahan saat menghapus buku dari koleksi pribadi: ' + errorMessage,
                        icon: 'error',
                        customClass: {
                            container: 'sweetalert-font sweetalert-background',
                            title: 'sweetalert-title',
                            content: 'sweetalert-text'
                        }
                    });
                }
            });
        }

    </script>
</body>
</html>

<?php
// Koneksi ke database
include '../koneksi.php';
require 'function/cek_login.php';
// 2. Buat kueri SQL untuk mengambil data dari tabel "kategoribuku".
$query_kategori = "SELECT kategoriID, namakategori FROM kategoribuku";
$result_kategori = mysqli_query($koneksi, $query_kategori);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/list-kategori.css?v=<?php echo time(); ?>">
    <title>List Kategori</title>
</head>
<body>
    <?php require '../sidebar.php'?>
    <?php require 'navbar.php'?>
        <!-- Kategori -->
        <div class="card">
        <h1 class="card-header">
            <div class="addcontent-icon" id="addkategori-icon" onclick="showAddkategoriPopup()">
                <i class="fa-solid fa-plus"></i>
            </div>
            Kategori
        </h1>
        <div class="table-responsive">
            <table class="table-hover">
                <thead class="head-table">
                    <tr>
                        <th>Nama Kategori</th>
                        <th style="width: 100px;">Jumlah Buku</th>
                        <th style="width: 120px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-body">
                    <?php while ($row_kategori = $result_kategori->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $row_kategori['namakategori']; ?></td>
                            <?php 
                                $kategori_id = $row_kategori['kategoriID'];
                                // Query untuk menghitung jumlah buku berdasarkan kategoriID
                                $sql_jumlah_buku = "SELECT COUNT(*) AS jumlah FROM buku WHERE kategoriID = $kategori_id";
                                $result_jumlah_buku = $koneksi->query($sql_jumlah_buku);
                                $row_jumlah_buku = $result_jumlah_buku->fetch_assoc();
                                $jumlah_buku = $row_jumlah_buku['jumlah'];
                            ?>
                            <td><?php echo $jumlah_buku; ?> Buku</td>
                            <td style="width: 125px; display: flex; gap: 5px; justify-content: space-between; align-items: center; flex-direction: row;">
                                <button class="edit-btn" onclick="showEditForm(<?php echo $row_kategori['kategoriID']; ?>, '<?php echo $row_kategori['namakategori']; ?>')"><i class="fa-solid fa-wand-magic-sparkles"></i></button>
                                <button class="deletecategory-btn" onclick="deleteCategory(<?php echo $row_kategori['kategoriID']; ?>)"><i class="fa-regular fa-trash-can"></i></button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
    <!-- Addkategori form (hidden) -->
    <div class="addkategori-cont" id="addkategori-container">
        <div class="header">
            <h1>Tambahkan Kategori</h1>
        </div>
        <form method="post" id="kategoriForm">
            <input type="text" class="kategori-name" name="nama-kategori" placeholder="Masukkan kategori">
            <div class="action-btn">
                <button type="button" class="batalkan" id="close-popup-addkategori" onclick="hideAddkategoriPopup()">Batal</button>
                <button type="button" class="submit" onclick="submitKategoriForm()">Simpan</button>
            </div>
        </form>
    </div>
    <div class="addkategori-cont" id="edit-form-container">
        <div class="header">
            <h2>Edit Kategori</h2>
        </div>
        <form id="editForm" method="post" style="width: 100%;">
            <input type="hidden" id="edit-kategoriID" name="edit-kategoriID" class="kategori-name">
            <input type="text" id="edit-namakategori" name="edit-namakategori" class="kategori-name">
            <div class="action-btn">
                <button type="button" onclick="submitEditKategoriForm()" class="submit">Simpan</button>
                <button type="button" onclick="hideEditForm()" class="batalkan">Batal</button>
            </div>
        </form>
    </div>

    <script>
        const addkategoriIcon = document.getElementById('addkategori-icon');
        const overlay = document.getElementById('overlay');
        const addkategoriContainer = document.getElementById('addkategori-container');

        function showAddkategoriPopup() {
            addkategoriContainer.style.display = 'block'; // Tampilkan popup
            overlay.style.display = 'block'; // Tampilkan overlay
            addkategoriContainer.classList.add('animate__animated', 'animate__bounceIn'); // Tambahkan animasi bounce in
        }

        function hideAddkategoriPopup() {
            addkategoriContainer.classList.remove('animate__bounceIn'); // Hapus animasi bounce in jika ada
            addkategoriContainer.classList.add('animate__bounceOut'); // Tambahkan animasi bounce out
            setTimeout(() => {
                addkategoriContainer.style.display = 'none'; // Sembunyikan popup setelah animasi selesai
                overlay.style.display = 'none'; // Sembunyikan overlay
                addkategoriContainer.classList.remove('animate__bounceOut'); // Hapus kelas animasi bounce out setelah selesai
            }, 500); // Sesuaikan dengan durasi animasi bounceOut (dalam milidetik)
        }


        function showEditForm(kategoriID, namakategori) {
            document.getElementById('edit-kategoriID').value = kategoriID;
            document.getElementById('edit-namakategori').value = namakategori;
            document.getElementById('overlay').style.display = 'block';
            document.getElementById('edit-form-container').style.display = 'block';
        }

        function hideEditForm() {
            document.getElementById('overlay').style.display = 'none';
            document.getElementById('edit-form-container').style.display = 'none';
        }

        // Event listener untuk menampilkan popup ketika ikon "Add Book" diklik
        addkategoriIcon.onclick = showAddkategoriPopup;
        // Event listener untuk menyembunyikan popup ketika ikon "X" diklik
        closePopupKategori.onclick = hideAddkategoriPopup;

    </script>
    <script src="../js/submitkategori.js"></script>
    <script src="../js/editkategori.js"></script>
    <script src="../js/delete_kategori.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

</body>
</html>
<?php
    // 1. Lakukan koneksi ke database menggunakan file "koneksi.php".
    include "../koneksi.php";
    include "function/cek_login.php";

    // Tambahkan pengecekan tingkat akses pengguna di sini
    $access_level = $_SESSION['acces_level'];

    // 2. Buat kueri SQL untuk mengambil data dari tabel "kategoribuku".
    $query_kategori = "SELECT kategoriID, namakategori FROM kategoribuku";
    $result_kategori = mysqli_query($koneksi, $query_kategori);

    // 3. Buat kueri SQL untuk mengambil data dari tabel "perpus".
    $query_perpus = "SELECT perpusID FROM perpus"; // Anda bisa menyesuaikan kueri ini sesuai dengan kebutuhan.
    $result_perpus = mysqli_query($koneksi, $query_perpus);

    // Periksa apakah ada form yang di-submit
    if (!empty($_POST)) {
        // Tangkap data dari AJAX
        $judul = $_POST['judul'];
        $penulis = $_POST['penulis'];
        $penerbit = $_POST['penerbit'];
        $kategoriID = $_POST['kategori'];
        $perpusID = $_POST['perpusID'];
        $tahun_terbit = $_POST['tahun-terbit'];
        $sinopsis = $_POST['sinopsis'];
        $username = $_SESSION['username'];
        $stok = $_POST['stok-buku'];
    
        // Tentukan direktori tujuan untuk menyimpan file
        $targetDir = "../images/cover-buku/";
    
        // Dapatkan nama file dan path sementara dari file yang diunggah
        $nama_file_cover = $_FILES['cover']['name'];
        $tmp_file_cover = $_FILES['cover']['tmp_name'];
    
        // Gabungkan nama file dengan direktori tujuan untuk membentuk path file yang lengkap
        $targetFileCover = $targetDir . basename($nama_file_cover);
    
        // Tentukan direktori tujuan untuk menyimpan file buku
        $targetDirBuku = "../books-library/";
    
        // Dapatkan nama file dan path sementara dari file buku yang diunggah
        $nama_file_buku = $_FILES['bukuFile']['name'];
        $tmp_file_buku = $_FILES['bukuFile']['tmp_name'];
    
        // Gabungkan nama file dengan direktori tujuan untuk membentuk path file yang lengkap
        $targetFileBuku = $targetDirBuku . basename($nama_file_buku);
    
        // Periksa dan pindahkan file cover buku ke direktori tujuan
        if (move_uploaded_file($tmp_file_cover, $targetFileCover)) {
            // Pindahkan file buku ke direktori tujuan
            if (move_uploaded_file($tmp_file_buku, $targetFileBuku)) {
                // Query untuk memasukkan data ke dalam tabel buku
                $query = "INSERT INTO buku (judul, penulis, penerbit, kategoriID, perpusID, tahunterbit, foto, deskripsi, stok, isibuku) 
                        VALUES ('$judul', '$penulis', '$penerbit', '$kategoriID', '$perpusID', '$tahun_terbit', '$nama_file_cover', '$sinopsis', '$stok', '$nama_file_buku')";
    
                if (mysqli_query($koneksi, $query)) {
                    // Tambahkan logs aktivitas
                    $logs = "INSERT INTO c_logs (detail_histori) VALUES ('User $username telah menambahkan buku berjudul $judul')";
                    if (!mysqli_query($koneksi, $logs)) {
                        // Jika ada kesalahan, kirim pesan kesalahan logs
                        echo 'Error logs: ' . mysqli_error($koneksi);
                        exit;
                    }
    
                    // Jika berhasil disimpan, kirim respons 'success'
                    echo 'success';
                    exit; // Berhenti di sini untuk menghindari eksekusi kode berikutnya
                } else {
                    // Jika ada kesalahan, kirim pesan kesalahan
                    echo 'Error buku: ' . mysqli_error($koneksi);
                    exit; // Berhenti di sini untuk menghindari eksekusi kode berikutnya
                }
            } else {
                // Jika terjadi kesalahan saat mengunggah file buku, tampilkan pesan kesalahan
                echo 'Error uploading buku';
                exit; // Berhenti di sini untuk menghindari eksekusi kode berikutnya
            }
        } else {
            // Jika terjadi kesalahan saat mengunggah file cover buku, tampilkan pesan kesalahan
            echo 'Error uploading cover';
            exit; // Berhenti di sini untuk menghindari eksekusi kode berikutnya
        }
    }

    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Buku - Bookshelf.Idn</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css">
    <link rel="stylesheet" href="../css/data-buku.css?v=<?php echo time(); ?>">
</head>
<body>
    <?php require '../sidebar.php' ?>
    <?php require 'navbar.php'?>

<!-- Data Buku -->
<div class="card">
    <h5 class="card-header">
        <div class="addcontent-icon" onclick="showAddbookPopup()" id="addbook-icon"><i class="fa-solid fa-plus"></i></div>
        Data Buku
    </h5>
    <div class="table-responsive">
        <table class="table-hover" style="max-height: 40vh; overflow: scroll;">
            <thead class="head-table">
                <tr>
                    <th style="padding-right: 5px;">Judul Buku</th>
                    <th style="padding-left: 5px; padding-right: 5px;">Penulis</th>
                    <th style="width: 140px; padding-left: 5px; padding-right: 5px;">Penerbit</th>
                    <th style="width: 100px; padding-left: 5px; padding-right: 5px;">Kategori</th>
                    <th style="width: 70px; text-align: center; padding-left: 5px; padding-right: 5px;">Tahun</th>
                    <th style="width: 100px; padding-left: 5px; padding-right: 5px; text-align: center;">Ulasan</th>
                    <th style="width: 120px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody class="table-body">
            <?php
                // Mulai query untuk mengambil data buku
                $query = "SELECT buku.*, kategoribuku.namakategori FROM buku 
                          LEFT JOIN kategoribuku ON buku.kategoriID = kategoribuku.kategoriID";
                $result = mysqli_query($koneksi, $query);
            ?>
                <?php while ($row = mysqli_fetch_assoc($result)) : 
                    $bukuID = $row['bukuID'];
                    $sql_jumlah_ulasan = "SELECT COUNT(*) AS jumlah FROM ulasanbuku WHERE bukuID = $bukuID AND ulasan <> ''";
                    $result_jumlah_ulasan = $koneksi->query($sql_jumlah_ulasan);
                    $row_jumlah_ulasan = $result_jumlah_ulasan->fetch_assoc();
                    $jumlah_ulasan = $row_jumlah_ulasan['jumlah'];
                ?>
                    <tr>
                        <td style="padding-right: 5px;"><?php echo $row['judul']; ?></td>
                        <td styk="padding-left: 5px; padding-right: 5px;"><?php echo $row['penulis']; ?></td>
                        <td style="width: 140px; padding-left: 5px; padding-right: 5px;"><?php echo $row['penerbit']; ?></td>
                        <td style="width: 100px; padding-left: 5px; padding-right: 5px;"><?php echo $row['namakategori']; ?></td>
                        <td style="width: 70px; text-align: center; padding-left: 5px; padding-right: 5px;"><?php echo $row['tahunterbit']; ?></td>
                        <td style="width: 70px; text-align: center; padding-left: 5px; padding-right: 5px; text-align: center;">
                            <?php if ($jumlah_ulasan > 0) : ?>
                                <a href="ulasan-buku.php?id=<?= $bukuID; ?>" class="ulsasan-link">
                                    <?php echo $jumlah_ulasan . " Ulasan"; ?>
                                </a>
                            <?php else : ?>
                                <?php echo "Belum ada"; ?>
                            <?php endif; ?>
                        </td>
                        <td style="width: 125px; display: flex; gap: 5px; justify-content: space-between; align-items: center; flex-direction: row;">
                            <a href="editbuku.php?id=<?= $bukuID; ?>">
                                <button class="edit-btn"><i class="fa-solid fa-wand-magic-sparkles"></i></button>
                            </a>
                            <button class="deletebook-btn" data-id="<?php echo $bukuID; ?>"><i class="fa-regular fa-trash-can"></i></button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

</div>
    <!-- Addbook Form (hidden) -->
    <div class="addbook-container" id="addbook-container">
        <div class="addbook-hdr">
            <h1 class="header">Tambah Buku</h1>
            <span class="close-popup" id="close-popup-addbook" onclick="hideAddbookPopup()"><i class="fa-solid fa-xmark"></i></span>
        </div>
        <div class="addbook-form">
            <form id="bookForm" method="post">
                <div class="form">
                    <!-- Container for image preview and upload button -->
                    <div id="imagePreviewContainer">
                        <!-- Icon and paragraph -->
                        <div id="imagePlaceholder">
                            <div class="placeholder">
                                <i class="fa-solid fa-mountain-sun"></i>
                                <p>No file chosen</p>
                            </div>
                        </div>
                        <!-- Upload button -->
                        <div id="imageInputWrapper">
                            <label for="imageInput" class="custom-file-upload">
                                <i class="fa-solid fa-images"></i>Upload Image
                            </label>
                            <!-- Actual input file -->
                            <input type="file" id="imageInput" name="cover" accept="image/*" onchange="previewImage(event)" required>
                        </div>
                        <!-- Image preview -->
                        <img id="imagePreview">
                    </div>
                    <div class="input-form">
                        <label for="judul">Judul</label>
                        <input placeholder="Masukkan judul buku" id="judul" type="text" name="judul" class="input-group" required>
                        <label for="penulis">Penulis</label>
                        <input placeholder="Masukkan nama  penulis" type="text" id="penulis" name="penulis" class="input-group" required>
                        <label for="kategori">Kategori</label>
                        <select id="kategori" name="kategori" class="input-group">
                            <?php
                            // 2. Buat kueri SQL untuk mengambil data dari tabel "kategoribuku".
                            $query_kategori = "SELECT kategoriID, namakategori FROM kategoribuku";
                            $result_kategori = mysqli_query($koneksi, $query_kategori);
                            // Loop melalui hasil kueri untuk mengisi opsi dropdown
                            while($row = mysqli_fetch_assoc($result_kategori)) {
                                echo "<option value='" . $row['kategoriID'] . "'>" . $row['namakategori'] . "</option>";
                            }
                            ?>
                        </select>                    
                        <label for="penerbit">Penerbit</label>
                        <input placeholder="Masukkan penerbit" type="text" id="penerbit" name="penerbit" class="input-group" required>
                        <div class="input">
                            <div class="input-data">
                                <label for="tahun-terbit">Tahun terbit</label>
                                <input placeholder="Masukkan tahun terbit" type="text" id="tahun-terbit" name="tahun-terbit" class="input-group" required>
                            </div>
                            <!-- <div class="input-data">
                                <label for="tahun-terbit">Stok buku</label>
                                <input placeholder="Masukkan stok buku" type="text" id="tahun-terbit" name="stok-buku" class="input-group" required>
                            </div> -->
                        </div>
                        <input type="hidden" name="perpusID" value="<?php echo mysqli_fetch_assoc($result_perpus)['perpusID']; ?>">
                    </div>
                    <div class="sinopsis-input">
                        <label for="sinopsis">Sinopsis Buku</label>
                        <textarea name="sinopsis" id="" cols="30" rows="10"></textarea>
                        <div class="buku-file">
                            <label for="bukuFile" class="custom-file-input" style="color: #777;">
                                <i class="fas fa-file-pdf"></i> Pilih file
                                <input type="file" id="bukuFile" name="bukuFile" onchange="showFileName(this)">
                            </label>
                            <span id="fileName" class="file-name"></span>
                        </div>
                    </div>
                </div>
                <div class="submit-btn">
                    <div class="submit" onclick="submitBookForm()"><i class="fa-solid fa-check"></i>Upload Buku</div>
                </div>                
            </form>
        </div>
    </div>



    <script>
        // Ambil elemen-elemen yang diperlukan
        const addbookIcon = document.getElementById('addbook-icon');
        const addbookContainer = document.getElementById('addbook-container');
        const overlay = document.getElementById('overlay');
        const closePopupAddbook = document.getElementById('close-popup-addbook');
        const closePopupKategori = document.getElementById('close-popup-addkategori');

        // Fungsi untuk menampilkan popup dengan animasi bounce in
        function showAddbookPopup() {
            addbookContainer.style.display = 'block'; // Tampilkan popup
            overlay.style.display = 'block'; // Tampilkan overlay
            addbookContainer.classList.add('animate__animated', 'animate__bounceIn'); // Tambahkan animasi bounce in
        }
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

        // Fungsi untuk menyembunyikan popup dengan animasi bounce out
        function hideAddbookPopup() {
            addbookContainer.classList.remove('animate__bounceIn'); // Hapus animasi bounce in jika ada
            addbookContainer.classList.add('animate__bounceOut'); // Tambahkan animasi bounce out
            setTimeout(() => {
                addbookContainer.style.display = 'none'; // Sembunyikan popup setelah animasi selesai
                overlay.style.display = 'none'; // Sembunyikan overlay
                addbookContainer.classList.remove('animate__bounceOut'); // Hapus kelas animasi bounce out setelah selesai
            }, 500); // Sesuaikan dengan durasi animasi bounceOut (dalam milidetik)
        }

        // Event listener untuk menampilkan popup ketika ikon "Add Book" diklik
        addbookIcon.onclick = showAddbookPopup;

        // Event listener untuk menyembunyikan popup ketika ikon "X" diklik
        closePopupAddbook.onclick = hideAddbookPopup;

        function showFileName(input) {
            const fileNameElement = document.getElementById('fileName');
            if (input.files.length > 0) {
                fileNameElement.textContent = input.files[0].name;
            } else {
                fileNameElement.textContent = '';
            }
        }

        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('imagePreview');
            const placeholder = document.getElementById('imagePlaceholder');
            const iconImage = document.getElementById('iconImage');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block'; // Show the image
                placeholder.style.display = 'none'; // Hide the placeholder
                };

                reader.readAsDataURL(input.files[0]);
            } else {
                preview.src = '';
                preview.style.display = 'none'; // Hide the image
                placeholder.style.display = 'block'; // Show the placeholder
            }
        }

            // Event listener untuk tombol delete
    $('.deletebook-btn').on('click', function() {
        // Ambil ID buku dari atribut data-id pada tombol delete
        var bukuID = $(this).data('id');

        // Tampilkan konfirmasi penghapusan dengan SweetAlert
        Swal.fire({
            title: 'Anda yakin?',
            text: "Anda tidak akan dapat mengembalikan perintah ini! Buku akan dihapus secara permanen",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Kirim permintaan AJAX untuk menghapus buku
                $.ajax({
                    url: 'delete_buku.php', // Ganti dengan URL yang benar untuk menghapus buku
                    type: 'POST',
                    data: { bukuID: bukuID },
                    success: function(response) {
                        // Tampilkan pesan sukses atau refresh halaman jika perlu
                        if (response === 'success') {
                            Swal.fire(
                                'Terhapus!',
                                'Buku telah dihapus.',
                                'success'
                            );
                            // Beri jeda waktu sebelum refresh halaman
                            setTimeout(function() {
                                window.location.reload(); // Refresh halaman
                            }, 1000); // Jeda waktu dalam milidetik (misalnya 1000ms = 1 detik)
                        } else {
                            Swal.fire(
                                'Gagal!',
                                'Gagal menghapus buku.',
                                'error'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        Swal.fire(
                            'Error!',
                            'Terjadi kesalahan saat menghapus buku.',
                            'error'
                        );
                    }
                });
            }
        });
    });

        
    </script>

    <!-- script Library -->
    <script src="../js/submitbook.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js"></script>
    <script>
        $(document).ready(function() {
            // Inisialisasi Nice Select pada dropdown kategori
            $('#kategori').niceSelect();
        });
    </script>
</body>
</html>

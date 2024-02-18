<?php
    // 1. Lakukan koneksi ke database menggunakan file "koneksi.php".
    include "../koneksi.php";
    include "function/cek_login.php";

    // 2. Buat kueri SQL untuk mengambil data dari tabel "kategoribuku".
    $query_kategori = "SELECT kategoriID, namakategori FROM kategoribuku";
    $result_kategori = mysqli_query($koneksi, $query_kategori);

    // 3. Buat kueri SQL untuk mengambil data dari tabel "perpus".
    $query_perpus = "SELECT perpusID FROM perpus"; // Anda bisa menyesuaikan kueri ini sesuai dengan kebutuhan.
    $result_perpus = mysqli_query($koneksi, $query_perpus);

    // Memeriksa apakah form telah disubmit
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

        
        // Tentukan direktori tujuan untuk menyimpan file cover
        $targetDir = "../images/cover-buku/";

        // Dapatkan nama file dan path sementara dari file yang diunggah
        $nama_file = $_FILES['cover']['name'];
        $tmp_file = $_FILES['cover']['tmp_name'];

        // Gabungkan nama file dengan direktori tujuan untuk membentuk path file yang lengkap
        $targetFile = $targetDir . basename($nama_file);

        if (move_uploaded_file($tmp_file, $targetFile)) {
            // Query untuk memasukkan data ke dalam tabel buku
            $query = "INSERT INTO buku (judul, penulis, penerbit, kategoriID, perpusID, tahunterbit, foto, deskripsi) 
                    VALUES ('$judul', '$penulis', '$penerbit', '$kategoriID', '$perpusID', '$tahun_terbit', '$nama_file', '$sinopsis')";

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
            // Jika terjadi kesalahan saat mengunggah gambar, tampilkan pesan kesalahan
            echo 'Error uploading foto';
            exit; // Berhenti di sini untuk menghindari eksekusi kode berikutnya
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku - Bookshelf.Idn</title>
    <link rel="stylesheet" href="../css/buku.css?v=<?php echo time(); ?>">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

</head>
<body>
    <?php require '../sidebar.php'; ?>
    <div class="famous-card">
        <h1 class="card-header">Buku Ter populer</h1>
        <div class="card-container">
            <div class="card">
                <div class="book-cover">
                    <img src="../images/xiaoyan.jpeg" alt="">
                </div>
                <div class="books-title">
                    <h3 class="judul-buku">Apostle : The Backstory of Celestial</h3>
                    <div class="title">
                        <p>Jeremy Lincoln</p>
                        <p>-</p>
                        <p>Books Studio</p>
                        <p>-</p>
                        <p>2022</p>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="book-cover">
                    <img src="../images/xiaoyan.jpeg" alt="">
                </div>
                <div class="books-title">
                    <h3 class="judul-buku">Apostle : The Backstory of Celestial</h3>
                    <div class="title">
                        <p>Jeremy Lincoln</p>
                        <p>-</p>
                        <p>Books Studio</p>
                        <p>-</p>
                        <p>2022</p>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="book-cover">
                    <img src="../images/xiaoyan.jpeg" alt="">
                </div>
                <div class="books-title">
                    <h3 class="judul-buku">Apostle : The Backstory of Celestial</h3>
                    <div class="title">
                        <p>Jeremy Lincoln</p>
                        <p>-</p>
                        <p>Books Studio</p>
                        <p>-</p>
                        <p>2022</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bookshelf">
        <div class="books-hdr">
            <div class="addbook-icon" onclick="showAddbookPopup()"><i class="fa-solid fa-plus"></i></div><h1 class="header">Daftar Buku</h1>
        </div>

        <?php
            // Buat kueri SQL untuk mengambil data buku yang telah di-bookmark oleh pengguna saat ini
            $query_bookmarked = "SELECT bukuID FROM koleksipribadi WHERE userID = " . $_SESSION['user_id'];
            $result_bookmarked = mysqli_query($koneksi, $query_bookmarked);

            // Inisialisasi array untuk menyimpan ID buku yang telah di-bookmark
            $bookmarked_books = [];

            // Memasukkan ID buku yang telah di-bookmark ke dalam array
            while ($row_bookmarked = mysqli_fetch_assoc($result_bookmarked)) {
                $bookmarked_books[] = $row_bookmarked['bukuID'];
            }
        ?>

        <div class="books-collection">
            <?php
                // Buat kueri SQL untuk mengambil data dari tabel buku
                $query_buku = "SELECT bukuID, judul, penulis, foto, perpusID FROM buku";
                $result_buku = mysqli_query($koneksi, $query_buku);

                // Periksa apakah ada data buku yang ditemukan
                if (mysqli_num_rows($result_buku) > 0) {
                    // Loop melalui setiap baris hasil query dan tampilkan informasi buku
                    while($row = mysqli_fetch_assoc($result_buku)) {
                        $judul_buku = $row["judul"];
                        $penulis_buku = $row["penulis"];
                        $foto_buku = $row["foto"];
                        $idbuku = $row["bukuID"];
                        $idperpus = $row["perpusID"];

                        // Periksa status peminjaman buku
                        $status_pinjam = '';
                        $btnClass = 'pinjam-btn'; // Default button class

                        $peminjamanQuery = "SELECT status_pinjam, userID FROM peminjaman WHERE bukuID = $idbuku";
                        $peminjamanResult = mysqli_query($koneksi, $peminjamanQuery);

                        if (mysqli_num_rows($peminjamanResult) > 0) {
                            while ($peminjamanData = mysqli_fetch_assoc($peminjamanResult)) {
                                if ($peminjamanData['status_pinjam'] == 'dipinjam' || $peminjamanData['status_pinjam'] == 'tertunda') {
                                    $btnClass = 'dipinjam-btn';
                                } elseif ($peminjamanData['status_pinjam'] == 'diajukan') {
                                    if ($peminjamanData['userID'] == $_SESSION['user_id']) {
                                        $btnClass = 'diajukan-btn';
                                    } else {
                                        $btnClass = 'pinjam-btn';
                                    }
                                } elseif ($peminjamanData['status_pinjam'] == 'dikembalikan') {
                                    $btnClass = 'pinjam-btn';
                                }
                            }
                        }

                        // Jika tombol kelas adalah diajukan-btn, tentukan juga onclick function
                        $onclickFunction = '';
                        if ($btnClass == 'diajukan-btn') {
                            $onclickFunction = "batalkanPeminjaman($idbuku, {$_SESSION['user_id']})";
                        }
            ?>
                <div class="books">
                    <div class="books-cover">
                        <!-- Gunakan foto dari kolom 'foto' dalam tabel buku -->
                        <a href="ulasan.php?id=<?php echo $idbuku; ?>"> <!-- Tambahkan link ke halaman ulasan.php dengan menyertakan bukuID sebagai parameter GET -->
                            <img src="../images/cover-buku/<?php echo $foto_buku; ?>" alt="">
                        </a>
                    </div>
                    <div class="books-title">
                        <div class="judul-buku"><?php echo $judul_buku; ?></div>
                        <div class="penulis">
                            <p class="penulis-buku"><?php echo $penulis_buku; ?></p>
                        </div>
                    </div>
                    <div class="action-btn">
                        <!-- Tampilkan tombol sesuai dengan kelas yang ditentukan -->
                        <?php if ($btnClass === 'diajukan-btn') : ?>
                            <div class="<?php echo $btnClass; ?>" onclick="<?php echo $onclickFunction; ?>">Diajukan</div>
                        <?php elseif ($btnClass === 'dipinjam-btn') : ?>
                            <div class="<?php echo $btnClass; ?>">Dipinjam</div>
                        <?php else : ?>
                            <div class="<?php echo $btnClass; ?>" onclick="pinjamBuku(<?php echo $idbuku; ?>, <?php echo $idperpus; ?>, <?php echo $_SESSION['user_id']; ?>)">Pinjam</div>
                        <?php endif; ?>
                        <!-- Tampilkan tombol 'bookmark' atau 'remove bookmark' sesuai keadaan -->
                        <?php if (in_array($idbuku, $bookmarked_books)) : ?>
                            <div class="bookmarked" onclick="removeBookmark(<?php echo $idbuku; ?>)"><i class="fa-solid fa-bookmark"></i></div>
                        <?php else : ?>
                            <div class="bookmark" onclick="addBookmark(<?php echo $idbuku; ?>)"><i class="fa-regular fa-bookmark"></i></div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php
                    }
                } else {
                    echo "Tidak ada data buku yang ditemukan.";
                }
            ?>
        </div>


        </div>
    </div>

    <div class="addbook-container" id="addbook-container">
        <div class="addbook-hdr">
            <h1 class="header">Tambah Buku</h1>
            <span class="close-popup" id="close-popup" onclick="hideAddbookPopup()"><i class="fa-solid fa-xmark"></i></span>
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
                            // Loop melalui hasil kueri untuk mengisi opsi dropdown
                            while($row = mysqli_fetch_assoc($result_kategori)) {
                                echo "<option value='" . $row['kategoriID'] . "'>" . $row['namakategori'] . "</option>";
                            }
                            ?>
                        </select>                    
                        <label for="penerbit">Penerbit</label>
                        <input placeholder="Masukkan penerbit" type="text" id="penerbit" name="penerbit" class="input-group" required>
                        <label for="tahun-terbit">Tahun terbit</label>
                        <input placeholder="Masukkan tahun terbit" type="text" id="tahun-terbit" name="tahun-terbit" class="input-group" required>
                        <input type="hidden" name="perpusID" value="<?php echo mysqli_fetch_assoc($result_perpus)['perpusID']; ?>">
                    </div>
                    <div class="sinopsis-input">
                        <label for="sinopsis">Sinopsis Buku</label>
                        <textarea name="sinopsis" id="" cols="30" rows="10"></textarea>
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
        const addbookIcon = document.querySelector('.addbook-icon');
        const closePopup = document.getElementById('close-popup');
        const addbookContainer = document.getElementById('addbook-container');
        const overlay = document.getElementById('overlay');

        // Fungsi untuk menampilkan popup dengan animasi bounce in
        function showAddbookPopup() {
            addbookContainer.style.display = 'block'; // Tampilkan popup
            overlay.style.display = 'block'; // Tampilkan overlay
            addbookContainer.classList.add('animate__animated', 'animate__bounceIn'); // Tambahkan animasi bounce in
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
        closePopup.onclick = hideAddbookPopup;

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
        
    </script>

    <!-- script Library -->
    <script src="../js/submitbook.js"></script>
    <script src="../js/pinjambuku.js"></script>
    <script src="../js/batalpinjam.js"></script>
    <script src="../js/ajaxbookmark.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js"></script>
    
    <!-- Nice Select Init -->
    <script>
        $(document).ready(function() {
            $('select').niceSelect({
                direction: 'up' // Munculkan dropdown ke atas
            }); // Initialize Nice Select on all select elements
        });
    </script>
</body>
</html>
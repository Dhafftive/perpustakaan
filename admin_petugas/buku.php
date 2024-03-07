<?php
    // 1. Lakukan koneksi ke database menggunakan file "koneksi.php".
    include "../koneksi.php";
    include "function/cek_login.php";

    // Tambahkan pengecekan tingkat akses pengguna di sini
    $access_level = $_SESSION['acces_level'];

    // Buat kueri SQL untuk mengambil data rating dari ulasan buku untuk setiap buku dan menghitung rata-rata rating
    $query_rating = "SELECT bukuID, AVG(rating) AS avg_rating FROM ulasanbuku GROUP BY bukuID";
    // Eksekusi kueri
    $result_rating = mysqli_query($koneksi, $query_rating);
    // Inisialisasi array untuk menyimpan rata-rata rating setiap buku
    $ratings = [];
    // Memasukkan rata-rata rating ke dalam array
    while ($row = mysqli_fetch_assoc($result_rating)) {
        $ratings[$row['bukuID']] = $row['avg_rating'];
    }
    // Urutkan buku berdasarkan rating secara turun
    arsort($ratings);
    // Ambil tiga buku dengan rating tertinggi
    $top_three_books = array_slice($ratings, 0, 3, true);


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
    

    // Buat kueri SQL untuk mengambil data buku yang telah di-bookmark oleh pengguna saat ini
    $query_bookmarked = "SELECT bukuID FROM koleksipribadi WHERE userID = " . $_SESSION['user_id'];
    $result_bookmarked = mysqli_query($koneksi, $query_bookmarked);

    // Inisialisasi array untuk menyimpan ID buku yang telah di-bookmark
    $bookmarked_books = [];
    
    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etalase - Bookshelf.Idn</title>
    <link rel="stylesheet" href="../css/buku.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

</head>
<body>
    <?php require '../sidebar.php'; ?>
    <?php require 'navbar.php'?>
    <!-- Bagian HTML untuk menampilkan 3 buku dengan rating tertinggi -->
    <div class="famous-card">
        <h1 class="card-header">Buku Terpopuler</h1>
        <div class="card-container">
            <?php
            // Loop melalui tiga buku dengan rating tertinggi
            foreach ($top_three_books as $bukuID => $rating) {
                // Buat kueri SQL untuk mengambil data buku berdasarkan bukuID
                $query_buku = "SELECT judul, penulis, penerbit, tahunterbit, foto FROM buku WHERE bukuID = $bukuID";
                $result_buku = mysqli_query($koneksi, $query_buku);

                // Periksa apakah data buku ditemukan
                if (mysqli_num_rows($result_buku) > 0) {
                    // Ambil data buku
                    $row_buku = mysqli_fetch_assoc($result_buku);
                    $judul_buku = $row_buku['judul'];
                    $penulis_buku = $row_buku['penulis'];
                    $penerbit_buku = $row_buku['penerbit'];
                    $tahun_terbit = $row_buku['tahunterbit'];
                    $foto_buku = $row_buku['foto'];

                    // Tampilkan data buku dalam elemen card
                    ?>
                    <div class="card">
                        <div class="book-cover">
                            <img src="../images/cover-buku/<?php echo $foto_buku; ?>" alt="">
                        </div>
                        <div class="books-title">
                            <h3 class="judul-buku"><?php echo $judul_buku; ?></h3>
                            <div class="title">
                                <p class="penulis"><?php echo $penulis_buku; ?></p>
                                <p>-</p>
                                <p class="penerbit"><?php echo $penerbit_buku; ?></p>
                                <p>-</p>
                                <p class="tahunterbit"><?php echo $tahun_terbit; ?></p>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>

    <!-- Bookshelf -->
    <div class="bookshelf">

        <!-- Kategori -->
        <div class="books-hdr">
        <?php if ($access_level !== 'peminjam') : ?>
            <div class="addcontent-icon" id="addkategori-icon" onclick="showAddkategoriPopup()"><i class="fa-solid fa-plus"></i></div>
        <?php endif; ?>
            <h1 class="header"> Kategori</h1>
            <div class="action-btn">
                <button type="button" class="kategori" onclick="filterBooks(null)">Semua</button>
                <?php
                    // Buat kueri SQL untuk mengambil kategori yang unik dari buku
                    $query_kategori_unik = "SELECT DISTINCT kb.kategoriID, kb.namakategori 
                                            FROM buku b
                                            INNER JOIN kategoribuku kb ON b.kategoriID = kb.kategoriID";
                    $result_kategori_unik = mysqli_query($koneksi, $query_kategori_unik);
                ?>
                <?php while ($row = mysqli_fetch_assoc($result_kategori_unik)) : ?>
                    <button type="button" class="kategori" onclick="filterBooks(<?php echo $row['kategoriID']; ?>)" id="kategori<?php echo $row['kategoriID']; ?>"><?php echo $row['namakategori']; ?></button>
                <?php endwhile; ?>

            </div>
        </div>
        <?php
            // Memasukkan ID buku yang telah di-bookmark ke dalam array
            while ($row_bookmarked = mysqli_fetch_assoc($result_bookmarked)) {
                $bookmarked_books[] = $row_bookmarked['bukuID'];
            }
        ?>
        <div class="books-kategori" style="margin: 0 auto 10vh; flex-wrap: nowrap; display: flex; overflow: hidden; gap: 35px; height: 350px; position: relative; width: 68vw;">
            <?php
                // Buat kueri SQL untuk mengambil data dari tabel buku
                $query_buku = "SELECT bukuID, judul, penulis, penerbit, foto, perpusID, kategoriID FROM buku";
                $result_buku = mysqli_query($koneksi, $query_buku);

                // Periksa apakah ada data buku yang ditemukan
                if (mysqli_num_rows($result_buku) > 0) {
                    // Loop melalui setiap baris hasil query dan tampilkan informasi buku
                    while($row = mysqli_fetch_assoc($result_buku)) {
                        $judul_buku = $row["judul"];
                        $penulis_buku = $row["penulis"];
                        $foto_buku = $row["foto"];
                        $penerbit_buku = $row["penerbit"];
                        $idbuku = $row["bukuID"];
                        $idperpus = $row["perpusID"];
                        $kategoriID = $row["kategoriID"];

                        // Periksa status peminjaman buku
                        // Periksa status peminjaman buku
                        $btnClass = '';

                        // Periksa status peminjaman buku dan stok buku
                        $btnClass = 'pinjam-btn'; // Default button class
                        $stokQuery = "SELECT stok FROM buku WHERE bukuID = $idbuku";
                        $stokResult = mysqli_query($koneksi, $stokQuery);

                        if (mysqli_num_rows($stokResult) > 0) {
                            $stokData = mysqli_fetch_assoc($stokResult);
                            $stok = $stokData['stok'];
                        }

                        $peminjamanQuery = "SELECT status_pinjam, userID FROM peminjaman WHERE bukuID = $idbuku";
                        $peminjamanResult = mysqli_query($koneksi, $peminjamanQuery);

                        if (mysqli_num_rows($peminjamanResult) > 0) {
                            while ($peminjamanData = mysqli_fetch_assoc($peminjamanResult)) {                        
                                if ($peminjamanData['status_pinjam'] == 'dipinjam') {
                                    if ($peminjamanData['userID'] == $_SESSION['user_id']) {
                                        $btnClass = 'dipinjam-btn';
                                    } else {
                                        if ($stok == 0) {
                                            $btnClass = 'habis-btn'; // Ubah kelas tombol menjadi 'habis-btn' jika stok habis
                                        } else {
                                            $btnClass = 'pinjam-btn';
                                        }
                                    }
                                } elseif ($peminjamanData['status_pinjam'] == 'dikembalikan') {
                                    $btnClass = 'pinjam-btn';
                                }
                            }
                        }

                        // Tambahkan kondisi tambahan untuk memeriksa apakah pengguna yang masuk adalah pengguna yang meminjam buku tersebut
                        if ($btnClass == 'habis-btn' && isset($_SESSION['user_id'])) {
                            $peminjamQuery = "SELECT status_pinjam FROM peminjaman WHERE bukuID = $idbuku AND userID = {$_SESSION['user_id']}";
                            $peminjamResult = mysqli_query($koneksi, $peminjamQuery);
                            if (mysqli_num_rows($peminjamResult) > 0) {
                                $btnClass = 'dipinjam-btn'; // Jika pengguna yang masuk adalah pengguna yang meminjam buku tersebut, tampilkan tombol 'dipinjam-btn'
                            }
                        }
                ?>
                <div class="books-content searchable" style="height: 320px; display: flex; flex-direction: column; justify-content: space-between; width: 140px" data-category-id="<?php echo $kategoriID; ?>">
                    <div class="books" style="witdh: 150px">
                        <a href="ulasan.php?id=<?php echo $idbuku; ?>">
                            <div class="cover-kategori" style="width: 140px; height: 200px; background-color: #ffb000; border-radius: 5px; overflow: hidden">
                                <img src="../images/cover-buku/<?php echo $foto_buku; ?>" alt="" style="width: 100%; height: 100%; object-fit: cover">
                            </div>
                        </a>
                        <div class="books-title">
                            <p class="judul-buku" style="font-size: 13px"><?php echo $judul_buku; ?></p>
                            <p class="penulis" style="font-size: 12px"><?php echo $penulis_buku; ?></p>
                            <p class="penerbit" style="font-size: 12px; color: #aaa; font-family: var(--default)"><?php echo $penerbit_buku; ?></p>
                        </div>
                    </div>
                    <?php if ($access_level !== 'petugas') : ?>
                        <div class="action-btn" style="display: flex; justify-content: space-between">
                            <!-- Tampilkan tombol sesuai dengan kelas yang ditentukan -->
                                <?php if ($btnClass === 'dipinjam-btn') : ?>
                                    <div class="<?php echo $btnClass; ?>">Dipinjam</div>
                                <?php elseif ($btnClass === 'habis-btn')  : ?>
                                    <div class="<?php echo $btnClass; ?>">Habis</div>
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
                    <?php endif; ?>
                </div>
            <?php
                    }
                } else {
                    echo "Tidak ada data buku yang ditemukan.";
                }
            ?>
        </div>


        <!-- Daftar Buku -->
        <div class="books-hdr">
        <?php if ($access_level !== 'peminjam') : ?>
            <div class="addcontent-icon" onclick="showAddbookPopup()" id="addbook-icon"><i class="fa-solid fa-plus"></i></div>
        <?php endif; ?>
            <h1 class="header" style="display: flex; justify-content: space-between; align-items: center;  width: 100%;">Daftar Buku 
                <div class="search"><i class="fa-solid fa-magnifying-glass"></i><input type="search" name="search" id="searchInput" placeholder="cari buku..."></div>
            </h1>
        </div>
        <?php
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
                        $btnClass = '';
                        // Periksa status peminjaman buku dan stok buku
                        $btnClass = 'pinjam-btn'; // Default button class
                        $stokQuery = "SELECT stok FROM buku WHERE bukuID = $idbuku";
                        $stokResult = mysqli_query($koneksi, $stokQuery);

                        if (mysqli_num_rows($stokResult) > 0) {
                            $stokData = mysqli_fetch_assoc($stokResult);
                            $stok = $stokData['stok'];

                            if ($stok == 0) {
                                $btnClass = 'habis-btn'; // Ubah kelas tombol menjadi 'habis-btn' jika stok habis
                            }
                        }

                        $peminjamanQuery = "SELECT status_pinjam, userID FROM peminjaman WHERE bukuID = $idbuku";
                        $peminjamanResult = mysqli_query($koneksi, $peminjamanQuery);

                        if (mysqli_num_rows($peminjamanResult) > 0) {
                            $isBorrowed = false; // Inisialisasi status peminjaman
                            while ($peminjamanData = mysqli_fetch_assoc($peminjamanResult)) {
                                // Periksa terlebih dahulu apakah stok buku habis
                                if ($stok == 0) {
                                    $btnClass = 'habis-btn'; // Jika stok habis, langsung atur kelas tombol menjadi 'habis-btn'
                                }
                        
                                if ($peminjamanData['status_pinjam'] == 'dipinjam' && $peminjamanData['userID'] == $_SESSION['user_id']) {
                                    $btnClass = 'dipinjam-btn'; // Jika buku dipinjam oleh user yang sedang login
                                    $isBorrowed = true; // Set status peminjaman menjadi true
                                    break; // Keluar dari loop karena buku sudah ditemukan dipinjam oleh user yang sedang login
                                } elseif ($peminjamanData['status_pinjam'] == 'dipinjam') {
                                    $btnClass = 'pinjam-btn'; // Jika buku dipinjam oleh user lain
                                } elseif ($peminjamanData['status_pinjam'] == 'dikembalikan') {
                                    $btnClass = 'pinjam-btn';
                                }
                            }
                        
                            // Jika setelah iterasi buku belum ditemukan dipinjam oleh user yang sedang login
                            if (!$isBorrowed) {
                                // Periksa kembali apakah stok buku habis
                                if ($stok == 0) {
                                    $btnClass = 'habis-btn'; // Atur kelas tombol menjadi 'habis-btn'
                                }
                            }
                        } else {
                            // Jika tidak ada peminjaman untuk buku ini
                            // Periksa terlebih dahulu apakah stok buku habis
                            if ($stok == 0) {
                                $btnClass = 'habis-btn'; // Atur kelas tombol menjadi 'habis-btn'
                            }
                        }
                        
                        
            ?>
                <div class="books search-data">
                    <div class="books-cover">
                        <!-- Gunakan foto dari kolom 'foto' dalam tabel buku -->
                        <?php if ($access_level !== 'petugas') : ?>
                            <a href="ulasan.php?id=<?php echo $idbuku; ?>">
                        <?php endif; ?> <!-- Tambahkan link ke halaman ulasan.php dengan menyertakan bukuID sebagai parameter GET -->
                                <img src="../images/cover-buku/<?php echo $foto_buku; ?>" alt="">
                        <?php if ($access_level !== 'petugas') : ?>
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="books-title">
                        <div class="judul-buku"><?php echo $judul_buku; ?></div>
                        <div class="penulis">
                            <p class="penulis-buku"><?php echo $penulis_buku; ?></p>
                        </div>
                    </div>
                    <?php if ($access_level !== 'petugas') : ?>
                        <div class="action-btn">
                            <!-- Tampilkan tombol sesuai dengan kelas yang ditentukan -->
                            <?php if ($btnClass === 'habis-btn') : ?>
                                <div class="<?php echo $btnClass; ?>">Habis</div>
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
                    <?php endif; ?>
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
<?php if ($access_level !== 'peminjam') : ?>
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
                                <i class="fa-solid fa-images"></i>Upload Cover
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
                        <div class="input">
                            <div class="input-data">
                                <label for="tahun-terbit">Tahun terbit</label>
                                <input placeholder="Masukkan tahun terbit" type="text" id="tahun-terbit" name="tahun-terbit" class="input-group" required>
                            </div>
                            <div class="input-data">
                                <label for="tahun-terbit">Batas peminjaman buku</label>
                                <input placeholder="Masukkan batas peminjaman" type="text" id="tahun-terbit" name="stok-buku" class="input-group" required>
                            </div>
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

    <!-- Addkategori form (hidden) -->
    <div class="addkategori-cont" id="addkategori-container">
        <div class="header">
            <h1>Tambahkan Kategori</h1>
        </div>
        <form method="post" id="kategoriForm">
            <input type="text" class="kategori-name" name="nama-kategori" placeholder="Masukkan kategori">
            <div class="action-btn">
                <button type="button" class="batalkan" id="close-popup-addkategori" onclick="hideAddkategoriPopup()">Batal</button>
                <button type="button" class="submit" onclick="submitKategoriForm()">Kirim</button>
            </div>
        </form>
    </div>
    <script>
        // Ambil elemen-elemen yang diperlukan
        const addbookIcon = document.getElementById('addbook-icon');
        const addbookContainer = document.getElementById('addbook-container');
        const addkategoriIcon = document.getElementById('addkategori-icon');
        const addkategoriContainer = document.getElementById('addkategori-container');
        const closePopupAddbook = document.getElementById('close-popup-addbook');
        const closePopupKategori = document.getElementById('close-popup-addkategori');
        const overlay = document.getElementById('overlay');

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
        function hideAddkategoriPopup() {
            addkategoriContainer.classList.remove('animate__bounceIn'); // Hapus animasi bounce in jika ada
            addkategoriContainer.classList.add('animate__bounceOut'); // Tambahkan animasi bounce out
            setTimeout(() => {
                addkategoriContainer.style.display = 'none'; // Sembunyikan popup setelah animasi selesai
                overlay.style.display = 'none'; // Sembunyikan overlay
                addkategoriContainer.classList.remove('animate__bounceOut'); // Hapus kelas animasi bounce out setelah selesai
            }, 500); // Sesuaikan dengan durasi animasi bounceOut (dalam milidetik)
        }

        // Event listener untuk menampilkan popup ketika ikon "Add Book" diklik
        addbookIcon.onclick = showAddbookPopup;
        addkategoriIcon.onclick = showAddkategoriPopup;

        // Event listener untuk menyembunyikan popup ketika ikon "X" diklik
        closePopupAddbook.onclick = hideAddbookPopup;
        closePopupKategori.onclick = hideAddkategoriPopup;

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

        
    </script>

    <!-- script Library -->
    <script src="../js/submitbook.js"></script>
    <script src="../js/submitkategori.js"></script>
<?php endif; ?>
    <script src="../js/konfirmpinjam.js"></script>
    <script src="../js/batalpinjam.js"></script>
    <script src="../js/ajaxbookmark.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        $(document).ready(function() {
            // Inisialisasi Nice Select pada dropdown kategori
            $('#kategori').niceSelect();
        });
    </script>


    <script>
        function filterBooks(categoryId) {
            // Menghapus kelas selected-category dari semua tombol kategori
            $(".kategori").removeClass("selected-category");
            $(".searchable").each(function() {
                if (categoryId === null || $(this).data('category-id') == categoryId) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
            // Menambahkan kelas selected-category ke tombol kategori yang dipilih
            $("#kategori" + categoryId).addClass("selected-category");
        }


        document.addEventListener('DOMContentLoaded', function() {
            const container = document.querySelector('.books-kategori');
            const kategoriScrollbar = new PerfectScrollbar(container);
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#searchInput').on('keyup', function() {
                var value = $(this).val().toLowerCase(); // Ambil nilai input pencarian dan ubah menjadi lowercase
                $('.search-data').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1); // Tampilkan atau sembunyikan buku berdasarkan input pencarian
                });
            });
        });
    </script>
    <script src="../libs/perfect-scrollbar/dist/perfect-scrollbar.js"></script>
</body>
</html>
<?php
    // 1. Lakukan koneksi ke database menggunakan file "koneksi.php".
    include "../koneksi.php";
    include "function/cek_login.php";

    // Cek apakah parameter 'id' sudah ada dalam URL
    if(isset($_GET['id'])) {
        $book_id = $_GET['id'];
        echo "Nilai 'id' dari URL adalah: " . $book_id;
    } else {
        echo "Parameter 'id' tidak ditemukan dalam URL.";
    }




    // Query untuk mengambil data buku berdasarkan nilai 'id'
    $query_get_book = "SELECT * FROM buku WHERE bukuID = $book_id";
    $result_get_book = mysqli_query($koneksi, $query_get_book);

    // Memeriksa apakah query berhasil dieksekusi dan mendapatkan hasil
    if ($result_get_book) {
        // Memeriksa apakah ada data yang ditemukan
        if ($row = mysqli_fetch_assoc($result_get_book)) {
            // Mendapatkan data buku yang sesuai dari hasil query
            $getcover = $row['foto'];
            $getjudul = $row['judul'];
            $getpenulis = $row['penulis'];
            $getkategoriID = $row['kategoriID'];
            $getpenerbit = $row['penerbit'];
            $gettahun_terbit = $row['tahunterbit'];
            $getstok = $row['stok'];
            $getsinopsis = $row['deskripsi'];
            $getnama_file_buku = $row['isibuku'];
        } else {
            // Menampilkan pesan jika data tidak ditemukan
        }
    } else {
        // Menampilkan pesan jika terjadi kesalahan saat menjalankan query
        echo "Error: " . mysqli_error($koneksi);
    }



    // Tambahkan pengecekan tingkat akses pengguna di sini
    $access_level = $_SESSION['acces_level'];

    // 2. Buat kueri SQL untuk mengambil data dari tabel "kategoribuku".
    $query_kategori = "SELECT kategoriID, namakategori FROM kategoribuku";
    $result_kategori = mysqli_query($koneksi, $query_kategori);

    // 3. Buat kueri SQL untuk mengambil data dari tabel "perpus".
    $query_perpus = "SELECT perpusID FROM perpus"; // Anda bisa menyesuaikan kueri ini sesuai dengan kebutuhan.
    $result_perpus = mysqli_query($koneksi, $query_perpus);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku</title>
    <link rel="stylesheet" href="../css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../css/data-buku.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <!-- Add this in the head section of your HTML  (Toastr.JS Library)-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <!-- Perfect Scrollbar -->
    <link rel="stylesheet" href="../libs/perfect-scrollbar/css/perfect-scrollbar.css">

    <!-- JQuery Library -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

</head>
<body>
<div class="addbook-container" id="addbook-container" style="display: block!important;">
        <div class="addbook-hdr">
            <h1 class="header">Edit Buku</h1>
        </div>
        <div class="addbook-form">
            <form id="bookForm" method="post" action="submiteditbook.php"enctype="multipart/form-data">
                <div class="form">
                    <!-- Container for image preview and upload button -->
                    <div id="imagePreviewContainer">
                        <!-- Icon and paragraph -->
                        <div id="imagePlaceholder">
                            <div class="placeholder">
                                
                            </div>
                        </div>
                        <!-- Upload button -->
                        <div id="imageInputWrapper">
                            <label for="imageInput" class="custom-file-upload">
                                <i class="fa-solid fa-images"></i>Upload Image
                            </label>
                            <!-- Actual input file -->
                            <input type="file" id="imageInput" name="cover" accept="image/*" onchange="previewImage(event)">
                        </div>
                        <!-- Image preview -->
                        <img id="imagePreview" src="../images/cover-buku/<?php echo $getcover;?>">
                    </div>
                    <div class="input-form">
                        <label for="judul">Judul</label>
                        <input placeholder="Masukkan judul buku" id="judul" type="text" name="judul" class="input-group" value="<?php echo $getjudul;?>" required>
                        <label for="penulis">Penulis</label>
                        <input placeholder="Masukkan nama  penulis" type="text" id="penulis" name="penulis" class="input-group" value="<?php echo $getpenulis;?>"required>
                        <label for="kategori">Kategori</label>
                        <select id="kategori" name="kategori" class="input-group">
                            <?php while($row = mysqli_fetch_assoc($result_kategori)) { ?>
                                <option value="<?php echo $row['kategoriID']; ?>" <?php if ($row['kategoriID'] == $getkategoriID) { ?>selected<?php } ?>>
                                    <?php echo $row['namakategori']; ?>
                                </option>
                            <?php } ?>
                        </select>
                        <label for="penerbit">Penerbit</label>
                        <input placeholder="Masukkan penerbit" type="text" id="penerbit" name="penerbit" class="input-group" value="<?php echo $getpenerbit;?>" required>
                        <div class="input">
                            <div class="input-data">
                                <label for="tahun-terbit">Tahun terbit</label>
                                <input placeholder="Masukkan tahun terbit" type="text" id="tahun-terbit" name="tahun-terbit" class="input-group" value="<?php echo $gettahun_terbit;?>" required>
                            </div>
                            <div class="input-data">
                                <label for="stok-buku">Stok buku</label>
                                <input placeholder="Masukkan stok buku" type="text" id="stok-buku" name="stok-buku" class="input-group" value="<?php echo $getstok;?>" required>
                            </div>
                        </div>
                        <input type="hidden" name="perpusID" value="<?php echo mysqli_fetch_assoc($result_perpus)['perpusID']; ?>">
                        <input type="hidden" name="bukuID" value="<?php echo $book_id; ?>" id="bukuID">
                        <input type="hidden" name="coverBookBefore" value="<?php echo $getcover; ?>" id="cover-book-before">
                        <input type="hidden" name="fileBookBefore" value="<?php echo $getnama_file_buku; ?>" id="fole-book-before">
                    </div>
                    <div class="sinopsis-input">
                        <label for="sinopsis">Sinopsis Buku</label>
                        <textarea name="sinopsis" id="" cols="30" rows="10"><?php echo $getsinopsis;?></textarea>
                        <div class="buku-file">
                            <label for="bukuFile" class="custom-file-input" style="color: #777;">
                                <i class="fas fa-file-pdf"></i> Pilih file
                                <input type="file" id="bukuFile" name="buku_file" onchange="showFileName(this)">
                            </label>
                            <span id="fileName" class="file-name"></span>
                        </div>
                    </div>
                </div>
                <div class="submit-btn" style="display: flex; flex-direction: row!important; align-items: center;">
                    <a href="data-buku.php">
                        <div class="back" style="font-family: var(--default); font-size: 14px; padding: 10px 15px; background-color: var(--secondary); border-radius: 5px; color: #fff; margin-right: 10px;">Kembali</div>
                    </a>
                    <input type="submit" value="Upload Edit" class="submit" >
                        <!-- <div class="submit" onclick="submitBookForm()"><i class="fa-solid fa-check"></i>Upload Edit</div> -->
                </div>                
            </form>
        </div>
    </div>
    <script>
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
            
            // Check if there's a file selected
            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block'; // Show the image
                    placeholder.style.display = 'none'; // Hide the placeholder
                };

                reader.readAsDataURL(input.files[0]);
            } else {
                // If no file is selected, clear the preview and show the placeholder
                preview.src = '';
                preview.style.display = 'none'; // Hide the image
                placeholder.style.display = 'block'; // Show the placeholder
            }
        }

        // Fungsi untuk menampilkan pesan SweetAlert
        // function showSwal(title, message, icon, confirmButtonText) {
        //     Swal.fire({
        //         title: title,
        //         text: message,
        //         icon: icon,
        //         confirmButtonText: confirmButtonText
        //     });
        // }

        // // Fungsi untuk menangani submit form
        // function submitBookForm() {
        //     // Menampilkan konfirmasi SweetAlert sebelum submit
        //     Swal.fire({
        //         title: 'Konfirmasi',
        //         text: 'Apakah Anda yakin ingin menyimpan perubahan?',
        //         icon: 'question',
        //         showCancelButton: true,
        //         confirmButtonColor: '#3085d6',
        //         cancelButtonColor: '#d33',
        //         confirmButtonText: 'Ya',
        //         cancelButtonText: 'Batal'
        //     }).then((result) => {
        //         // Jika pengguna mengonfirmasi
        //         if (result.isConfirmed) {
        //             // Lakukan submit form menggunakan AJAX
        //             $.ajax({
        //                 type: 'POST',
        //                 url: 'submiteditbook.php', // Sesuaikan dengan lokasi file PHP yang sesuai
        //                 data: $('#bookForm').serialize(),
        //                 success: function(response) {
        //                     // Jika berhasil, tampilkan pesan sukses
        //                     if (response === 'success') {
        //                         showSwal('Success', 'Data buku berhasil diperbarui.', 'success', 'OK');
        //                         // Setelah tampil pesan sukses, arahkan user ke halaman data-buku.php
        //                         setTimeout(function(){
        //                             window.location.href = "data-buku.php";
        //                         }, 2000); // Mengarahkan setelah 2 detik
        //                     } else {
        //                         // Jika terjadi kesalahan, tampilkan pesan error
        //                         showSwal('Error', response, 'error', 'OK');
        //                     }
        //                 },
        //                 error: function(xhr, status, error) {
        //                     // Jika terjadi kesalahan AJAX, tampilkan pesan error
        //                     var errorMessage = xhr.status + ': ' + xhr.statusText;
        //                     console.error('AJAX Error: ' + errorMessage);
        //                     showSwal('Error', 'Terjadi kesalahan saat memproses data buku. Silakan coba lagi nanti.', 'error', 'OK');
        //                 }
        //             });
        //         }
        //     });
        // }


    </script>
    
    <script>
        $(document).ready(function() {
            // Inisialisasi Nice Select pada dropdown kategori
            $('#kategori').niceSelect();
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js"></script>
</body>
</html>
<?php
require '../koneksi.php';
include "function/cek_login.php";

$query = "SELECT u.userID, p.perpusID, u.username, p.nama_perpus, u.namalengkap, u.email, u.alamat, u.acces_level
          FROM user u
          INNER JOIN perpus p ON p.perpusID = u.perpusID";
$result = mysqli_query($koneksi, $query);
if (!$result) {
    die('Error in SQL query: ' . mysqli_error($koneksi));
}

$admin = $_SESSION['username'];


// Check if the form is submitted
if (!empty($_POST)) {
    // Tangkap data dari AJAX
    $username = $_POST['username'];
    $namalengkap = ucwords(strtolower($_POST['namalengkap'])); // Menggunakan ucwords untuk kapitalisasi
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];
    $email = $_POST['email'];
    $telepon = $_POST['telepon'];
    $alamat = $_POST['alamat'];
    $acces_level = isset($_POST['level-akses']) ? $_POST['level-akses'] : 'peminjam';  // Tambahkan ini
    $perpusID = $_POST['idperpus'];

    // Pengecekan apakah password dan konfirmasi password sama
    if ($password !== $confirm) {
        // Password tidak sesuai, kirim pesan kesalahan
        echo 'error_password_mismatch';
        exit;
    }
    // Check if username, nama lengkap, and email already exist
    $checkQuery = "SELECT * FROM user WHERE username = '$username' OR namalengkap = '$namalengkap' OR email = '$email'";
    $checkResult = mysqli_query($koneksi, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        $existingData = mysqli_fetch_assoc($checkResult);

        if ($existingData['username'] == $username) {
            // Username already exists, send error message
            echo 'error_username_exists';
        } elseif ($existingData['email'] == $email) {
            // Email already exists, send error message
            echo 'error_email_exists';
        } elseif ($existingData['namalengkap'] == $namalengkap) {
            // Nama lengkap already exists, send error message
            echo 'error_namalengkap_exists';
        }
        exit;
    } else {
        // Setelah validasi berhasil, lanjutkan dengan proses penyimpanan data
        $confirm = password_hash($password, PASSWORD_DEFAULT);
    
        // Query untuk memasukkan data ke dalam tabel user
        $query = "INSERT INTO user (username, namalengkap, password, email, no_hp, alamat, acces_level, perpusID) 
                  VALUES ('$username', '$namalengkap', '$confirm', '$email', '$telepon', '$alamat', '$acces_level', '$perpusID')";
    
        // Log atau konsol log untuk memeriksa nilai variabel
        error_log("Debug: Username - $username, PerpusID - $perpusID", 0);
    
        if (mysqli_query($koneksi, $query)) {
            // Tambahkan logs aktivitas
            $logs = "INSERT INTO c_logs (detail_histori) VALUES ('User bernama $username berhasil ditambahkan oleh $admin ke database')";
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
            echo 'Error user: ' . mysqli_error($koneksi);
            exit; // Berhenti di sini untuk menghindari eksekusi kode berikutnya
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data User - Bookshelf.Idn</title>
    <link rel="stylesheet" href="../css/data_user.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css">
</head>
<body>
    <?php require '../sidebar.php' ?>
    <?php require 'navbar.php'?>
    <div class="card">
        <h5 class="card-header">Data User <div class="user-add" onclick="showRegistrationForm()"><i class="fa-solid fa-user-plus"></i></div></h5>
        <div class="table-responsive">
            <table class="table-hover">
                <thead class="head-table">
                    <tr>
                        <th>USERNAME</th>
                        <th>PERPUSTAKAAN</th>
                        <th>NAMA LENGKAP</th>
                        <th>EMAIL</th>
                        <th>ALAMAT</th>
                        <th>ROLE</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody class="table-body">
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr id="row_<?php echo $row['userID']; ?>">
                            <td><?php echo $row['username']; ?></td>
                            <td><?php echo $row['nama_perpus']; ?></td>
                            <td><?php echo $row['namalengkap']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['alamat']; ?></td>
                            <td>
                                <?php if ($row['acces_level'] == 'admin') { ?>
                                    <div class="admin-label">
                                        <p class="role-admin">Admin</p>
                                    </div>
                                <?php } elseif ($row['acces_level'] == 'petugas') { ?>
                                    <div class="petugas-label">
                                        <p class="role-petugas">Petugas</p>
                                    </div>
                                <?php } elseif ($row['acces_level'] == 'peminjam') { ?>
                                    <div class="peminjam-label">
                                        <p class="role-peminjam">Peminjam</p>
                                    </div>
                                <?php } ?>
                            </td>
                            <td>
                               <div class="dropdown">
                                    <button type="button">
                                        <i class="fa-solid fa-ellipsis"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <div class="dropdown-option">
                                            <a class="dropdown-item" href="edit_user.php?userID=<?php echo $row['userID']?>">
                                                <i class="fa-solid fa-wand-magic-sparkles"></i> Edit
                                            </a>
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="deleteUser(<?php echo $row['userID']; ?>)">
                                                <i class="fa-regular fa-trash-can"></i> Delete
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php
                        $namaperpus = $row['nama_perpus'];
                        $perpusID = $row['perpusID'];
                    ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
    <div id="registrationFormContainer" class="page-signup animate__animated" style="display: none;">
        <h1 class="hdr">Tambah Akun Pengguna</h1>
        <div class="signup-form">
            <form id="userForm" method="post">
                <div class="input-data">
                    <div class="input-form">
                        <label for="username">Username</label>
                        <input placeholder="Masukkan username" id="username" type="text" name="username" class="input-group" required>
                        <label for="namalengkap">Nama Lengkap</label>
                        <input placeholder="Masukkan nama  lengkap" type="text" id="namalengkap" name="namalengkap" class="input-group" required>
                        <label for="alamat">Alamat</label>
                        <input placeholder="Masukkan alamat rumah" type="text" id="alamat" name="alamat" class="input-group" required>
                        <label for="password">Password</label>
                        <input placeholder="Masukkan password" type="password" id="password" name="password" class="input-group" required>
                    </div>
                    <div class="input-form">
                        <label for="email">Email</label>
                        <input placeholder="Masukkan email" id="email" type="text" name="email" class="input-group" required>
                        <label for="telepon">No. Telepon</label>
                        <input placeholder="Masukkan nomor telepon" type="text" id="telepon" name="telepon" class="input-group" required>
                        <label for="perpustakaan">Perpustakaan</label>
                        <select name="level-akses" id="acces_level" class="input-group">
                            <option value="peminjam">Peminjam</option>
                            <option value="petugas">Petugas</option>
                            <option value="admin">Admin</option>
                        </select>
                        <input type="hidden" name="idperpus" value="<?= $perpusID ?>">
                        <label for="confirm">Konfirmasi</label>
                        <input placeholder="Masukkan password sekali lagi" type="password" id="confirm" name="confirm" class="input-group" required>
                    </div>
                </div>
                <div class="button-form">
                    <input type="submit" value="Submit" name="Submit">
                    <div class="cancel-button" onclick="hideRegistrationForm()"><p class="cancel-label">Cancel</p></div>
                </div>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        function deleteUser(userID) {
            // Tampilkan SweetAlert2 untuk konfirmasi penghapusan
            const swalOptions = {
                title: 'Hapus Data Pengguna',
                text: 'Apakah Anda yakin ingin menghapus pengguna ini? Seluruh data akun ini akan dihapus dari database',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f7c7c7',
                cancelButtonColor: '#c5deff',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal',
                customClass: {
                    container: 'sweetalert-font', // Menambahkan kelas CSS
                    title: 'sweetalert-title', // Menambahkan kelas CSS untuk judul
                    content: 'sweetalert-text', // Menambahkan kelas CSS untuk teks
                    confirmButton: 'sweetalert-confirm-button',
                    cancelButton: 'sweetalert-cancel-btn'
                },
                showClass: {
                    popup: 'animate__bounceIn faster' // Menambahkan animasi (optional)
                },
                hideClass: {
                    popup: 'animate__bounceOut faster' // Menambahkan animasi (optional)
                },
                didOpen: () => {
                    // Callback yang dipanggil saat SweetAlert2 terbuka
                    const sweetAlertPopup = Swal.getPopup();
                    sweetAlertPopup.style.border = '5px solid #FFB000';
                    sweetAlertPopup.style.borderRadius = '10px';
                    sweetAlertPopup.style.background = '#FFF';
                    sweetAlertPopup.querySelector('.sweetalert-title').style.color = '#FFB000';
                }
            };

            Swal.fire(swalOptions).then((result) => {
                if (result.isConfirmed) {
                    // Kirim permintaan AJAX untuk penghapusan
                    var xhr = new XMLHttpRequest();
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            // Tanggapan dari server (jika diperlukan)
                            console.log(xhr.responseText);

                            // Hapus baris tabel tanpa memuat ulang halaman
                            var rowToDelete = document.getElementById('row_' + userID);
                            rowToDelete.parentNode.removeChild(rowToDelete);

                            // Tampilkan SweetAlert2 berhasil
                            Swal.fire({
                                title: 'Berhasil',
                                text: 'Pengguna berhasil dihapus!',
                                icon: 'success',
                                customClass: {
                                    container: 'sweetalert-font sweetalert-background',
                                    title: 'sweetalert-title',
                                    content: 'sweetalert-text'
                                }
                            });
                        }
                    };

                    // Mulai permintaan AJAX
                    xhr.open("GET", "function/delete_user.php?userID=" + userID, true);
                    xhr.send();
                }
            });
        }

        function showRegistrationForm() {
            var registrationFormContainer = document.getElementById('registrationFormContainer');
            document.getElementById('overlay').style.display = 'block';
            registrationFormContainer.style.display = 'block';
            registrationFormContainer.classList.add('animate__bounceIn');
        }
        function hideRegistrationForm() {
            var registrationFormContainer = document.getElementById('registrationFormContainer');
            document.getElementById('overlay').style.display = 'none';
            var form = registrationFormContainer.querySelector('form');
            
            // Reset the form
            form.reset();

            // Remove 'required' attribute from all inputs
            var inputs = form.querySelectorAll('input[required]');
            inputs.forEach(function (input) {
                input.removeAttribute('required');
            });

            registrationFormContainer.classList.remove('animate__bounceIn');
            registrationFormContainer.style.animation = 'fadeOut 0.3s';

            setTimeout(function () {
                registrationFormContainer.style.display = 'none';
                registrationFormContainer.style.animation = ''; // Reset animation
                resetInputFieldStyles(); // Panggil fungsi untuk menghapus highlighting
            }, 300);
        }

        $(document).ready(function () {
        $('#userForm').submit(function (event) {
            event.preventDefault();

            var formData = new FormData($(this)[0]);

            $.ajax({
                type: 'POST',
                url: 'data_user.php', // Sesuaikan dengan nama file ini
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    console.log(response); 
                
                    if (response === 'success') {
                        // Handle berhasil
                        console.log('Data pengguna berhasil disimpan.');
                
                        // Tampilkan notifikasi SweetAlert
                        Swal.fire({
                            title: 'Berhasil',
                            text: 'Data pengguna berhasil disimpan!',
                            icon: 'success',
                            customClass: {
                                container: 'sweetalert-font sweetalert-background',
                                title: 'sweetalert-title',
                                content: 'sweetalert-text'
                            }
                        }).then(() => {
                            // Setelah pengguna mengklik tombol OK pada notifikasi
                            hideRegistrationForm(); // Panggil fungsi untuk menyembunyikan formulir
                        });
                        
                        // Clear form setelah berhasil
                        $('#userForm')[0].reset();
                        resetInputFieldStyles(); // Panggil fungsi untuk menghapus highlighting
                    
                    } else if (response.startsWith('error_')) {
                        // Handle specific errors and highlight input fields
                        if (response === 'error_username_exists') {
                            toastr.warning('Username sudah ada.');
                            highlightInputField('username');
                        } else if (response === 'error_email_exists') {
                            toastr.warning('Email sudah ada.');
                            highlightInputField('email');
                        } else if (response === 'error_namalengkap_exists') {
                            toastr.warning('Nama Lengkap sudah ada.');
                            highlightInputField('namalengkap');
                        } else if (response === 'error_password_mismatch') {
                            toastr.warning('Konfirmasi password tidak sesuai.');
                            highlightInputField('confirm');
                        } else {
                            // Handle other errors
                            console.error(response);
                            toastr.warning('Terjadi kesalahan saat menyimpan data pengguna.');
                        }
                    }
                },
                error: function (xhr, status, error) {
                    // Handle error
                    console.error(xhr.responseText);

                    // Tampilkan notifikasi SweetAlert untuk error
                    Swal.fire({
                        title: 'Gagal',
                        text: 'Terjadi kesalahan saat menyimpan data pengguna.',
                        icon: 'error',
                        customClass: {
                            container: 'sweetalert-font sweetalert-background',
                            title: 'sweetalert-title',
                            content: 'sweetalert-text'
                        }
                    });
                    // Hapus class highlight pada input field
                    resetInputFieldStyles();
                }
            });
            });
        });
        
        function highlightInputField(fieldName) {
            // Hapus class highlight pada input field sebelumnya (jika ada)
            resetInputFieldStyles();

            // Tambahkan class untuk highlight pada input field dengan nama tertentu
            $('#' + fieldName).addClass('highlight-error');

            // Tambahkan event listener untuk menghapus class highlight saat kontennya berubah
            $('#' + fieldName).on('input', function () {
                $('#' + fieldName).removeClass('highlight-error');
                resetInputFieldStyles();
            });
        }
        
        function resetInputFieldStyles() {
            // Hapus class highlight pada semua input field
            $('input').removeClass('highlight-error');
        }

    </script>
    <!-- Include toastr library at the end of your body section -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js"></script>
    <script>
        $(document).ready(function() {
            // Inisialisasi Nice Select pada dropdown kategori
            $('#acces_level').niceSelect();
        });
    </script>
</body>
</html>

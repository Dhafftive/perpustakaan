<?php
    // Ambil data perpustakaan dari database
    include "koneksi.php";
    $query = "SELECT * FROM perpus";
    $result = mysqli_query($koneksi, $query);
    $dataPerpustakaan = array();
    if ($row = mysqli_fetch_assoc($result)) {
        $perpusID = $row['perpusID'];
        $namaperpus = $row ['nama_perpus'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Akun Baru</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/sign-up.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="bg-img"></div>
    <div class="head-page">
        <p class="logo">Bookshelf.<span>Idn</span></p>
        <div class="account-confirm"><p>Sudah punya akun?</p><button class="sign-up"><a href="index.php">Masuk</a></button></div>
    </div>
    <div class="page-signup">
        <h1 class="hdr">Buat Akun Baru</h1>
        <form id="signupForm" action="admin_petugas/function/simpan_user.php" method="post">
            <div class="input-data">
                <div class="input-form">
                    <label for="username">Username</label>
                    <input placeholder="Masukkan username" id="username" type="text" name="username" required>
                    <label for="namalengkap">Nama Lengkap</label>
                    <input placeholder="Masukkan nama  lengkapmu" type="text" id="namalengkap" name="namalengkap" required>
                    <label for="alamat">Alamat</label>
                    <input placeholder="Masukkan alamat rumahmu" type="text" id="alamat" name="alamat" required>
                    <label for="email">Email</label>
                    <input placeholder="Masukkan email" id="email" type="text" name="email" required>
                </div>
                <div class="input-form">
                    <label for="telepon">No. Telepon</label>
                    <input placeholder="Masukkan nomor telepon" type="text" id="telepon" name="telepon" required>
                    <label for="perpustakaan">Perpustakaan</label>
                    <input type="text" name="perpustakaan" id="" value="<?= $namaperpus ?>" readonly>
                    <input type="hidden" name="idperpus" value="<?= $perpusID ?>">
                    <label for="password">Password</label>
                    <input placeholder="Masukkan password" type="password" id="password" name="password" required>
                    <label for="confirm">Konfirmasi</label>
                    <input placeholder="Masukkan password sekali lagi" type="password" id="confirm" name="confirm" required>
                </div>
            </div>
            <input type="submit" value="Buat Akun" name="Submit">
        </form>
    </div>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        var form = document.getElementById('signupForm');

        if (!form) return;

        form.addEventListener('submit', function (event) {
            event.preventDefault(); // Cegah form dikirim langsung

            var formData = new FormData(form); // Ambil data form

            // Validasi password sebelum submit
            var password = document.getElementById('password').value;
            var confirm = document.getElementById('confirm').value;

            if (password !== confirm) {
                Swal.fire({
                    icon: 'error',
                    title: 'Password Tidak Cocok',
                    text: 'Harap masukkan password yang sama!',
                });
                return;
            }

            // Konfirmasi sebelum registrasi
            Swal.fire({
                title: 'Konfirmasi Registrasi',
                text: 'Apakah data sudah benar?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Daftar!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim data menggunakan AJAX
                    fetch('admin_petugas/function/simpan_user.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json()) // Ubah response ke JSON
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Registrasi Berhasil!',
                                text: 'Akun Anda telah dibuat, silakan login.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = 'index.php'; // Redirect setelah user klik OK
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Registrasi Gagal!',
                                text: data.message
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: 'Silakan coba lagi nanti.'
                        });
                        console.error('Error:', error);
                    });
                }
            });
        });
    });
</script>

</body>
</html>

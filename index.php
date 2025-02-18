<?php
session_start();

// Membuat token CSRF jika belum ada
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Membuat token acak
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Akun</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css?v=<?php echo time(); ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="bg-img"></div>
    <div class="head-page">
        <p class="logo">Bookshelf.<span>Idn</span></p>
        <div class="account-confirm"><p>kamu belum punya akun?</p><button class="sign-up"><a href="sign-up.php">Buat Akun</a></button></div>
    </div>
    <div class="page-login">
        <h1 class="hdr">Masuk Akun</h1>
        <form id="loginForm">
            <div class="input-form">
                <label for="username">Username atau email</label>
                <input placeholder="Masukkan username atau email" id="username" type="text" name="username" required>
                <label for="password">Password</label>
                <input placeholder="Masukkan password" type="password" id="password" name="password" required>
            </div>
            <!-- Token CSRF disertakan dalam form sebagai input tersembunyi -->
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="submit" value="Masuk">
        </form>
    </div>

    <script>
        $(document).ready(function() {
            // Saat form login disubmit
            $('#loginForm').submit(function(event) {
                event.preventDefault(); // Menghindari reload halaman

                // Mengambil data dari form
                var username = $('#username').val();
                var password = $('#password').val();
                var csrfToken = $('input[name="csrf_token"]').val(); // Mengambil token CSRF dari form

                // Melakukan request AJAX
                $.ajax({
                    url: 'process_login.php', // File proses login
                    type: 'POST',
                    data: {
                        username: username,
                        password: password,
                        csrf_token: csrfToken // Kirimkan token CSRF
                    },
                    success: function(response) {
                        // Menggunakan SweetAlert untuk menampilkan hasil
                        try {
                            var jsonResponse = JSON.parse(response);
                            if (jsonResponse.status === 'success') {
                                Swal.fire('Selamat datang!', 'Login berhasil!', 'success').then(() => {
                                    window.location.href = jsonResponse.redirect; // Redirect ke halaman sesuai role
                                });
                            } else {
                                Swal.fire('Gagal!', jsonResponse.message, 'error');
                            }
                        } catch (e) {
                            Swal.fire('Gagal!', 'Terjadi kesalahan saat memproses data.', 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('Gagal!', 'Terjadi kesalahan pada server.', 'error');
                    }
                });
            });
        });
    </script>
</body>
</html>

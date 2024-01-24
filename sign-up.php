<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Akun Baru</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="sign-up.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Poppins:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Yeseva+One&display=swap" rel="stylesheet">
	
    <!-- JQuery animation -->
    <link href="vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
</head>
<body>
    <div class="bg-img"></div>
    <div class="head-page">
        <p class="logo">Bookshelf.<span>Idn</span></p>
        <div class="account-confirm"><p>Sudah punya akun?</p><button class="sign-up"><a href="">Login</a></button></div>
    </div>
    <div class="page-signup">
        <h1 class="hdr">Buat Akun Baru</h1>
        <form id="signupForm" action="simpan_user.php" method="post">
            <div class="input-data">
                <div class="input-form">
                    <label for="username">Username</label>
                    <input placeholder="Masukkan username" id="username" type="text" name="username" required>
                    <label for="namalengkap">Nama Lengkap</label>
                    <input placeholder="Masukkan nama  lengkapmu" type="text" id="namalengkap" name="namalengkap" required>
                    <label for="perpustakaan">Perpustakaan</label>
                    <select name="perpustakaan" id="perpustakaan" class="default-select" required>
                        <!-- Options will be added dynamically using JavaScript -->
                    </select>
                    <label for="password">Password</label>
                    <input placeholder="Masukkan password" type="password" id="password" name="password" required>
                </div>
                <div class="input-form">
                    <label for="email">Email</label>
                    <input placeholder="Masukkan email" id="email" type="text" name="email" required>
                    <label for="telepon">No. Telepon</label>
                    <input placeholder="Masukkan nomor telepon" type="text" id="telepon" name="telepon" required>
                    <label for="alamat">Alamat</label>
                    <input placeholder="Masukkan alamat rumahmu" type="text" id="alamat" name="alamat" required>
                    <label for="confirm">Konfirmasi</label>
                    <input placeholder="Masukkan password sekali lagi" type="password" id="confirm" name="confirm" required>
                </div>
            </div>
            <input type="submit" value="Submit" name="Submit">
        </form>
    </div>

    <!-- Required vendors -->
    <script src="vendor/global/global.min.js"></script>
    <script src="vendor/jquery-nice-select/js/jquery.nice-select.min.js"></script>

    <script>
        // Ambil referensi elemen select
        var perpustakaanSelect = document.getElementById('perpustakaan');

        // Daftar perpustakaan yang Anda dapatkan dari database
        var daftarPerpustakaan = <?php
            // Ambil data perpustakaan dari database
            include "koneksi.php";
            $query = "SELECT * FROM perpus";
            $result = mysqli_query($koneksi, $query);
            $dataPerpustakaan = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $dataPerpustakaan[] = $row;
            }
            echo json_encode($dataPerpustakaan);
        ?>;

        // Isi elemen select dengan data perpustakaan
        for (var i = 0; i < daftarPerpustakaan.length; i++) {
            var option = document.createElement('option');
            option.value = daftarPerpustakaan[i].perpusID;
            option.textContent = daftarPerpustakaan[i].nama_perpus;
            perpustakaanSelect.appendChild(option);
        }

        // Validasi form pada sisi klien menggunakan JavaScript
        document.getElementById('signupForm').addEventListener('submit', function (event) {
            var password = document.getElementById('password').value;
            var confirm = document.getElementById('confirm').value;

            if (password !== confirm) {
                alert('Password dan konfirmasi harus sama.');
                event.preventDefault(); // Mencegah formulir dikirim jika password tidak cocok
            } else {
                // Jika password cocok, tampilkan konfirmasi tambahan
                var konfirmasi = confirm('Apakah Anda yakin dengan password ini?');
                if (!konfirmasi) {
                    event.preventDefault(); // Mencegah formulir dikirim jika konfirmasi ditolak
                }
            }
        });
    </script>

    <script src="js/custom.min.js"></script>
</body>
</html>

<?php
    require "koneksi.php";
    // Memanggil fungsi registrasi setelah deklarasi fungsi
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Panggil fungsi registrasi
        $result = registrasi($koneksi, $_POST);
        if ($result) {
            header("Location: login.php");
            echo "<script>
                alert('Registrasi berhasil!');
            </script>";
            exit;
        } else {
            echo "<script>
                alert('Registrasi gagal');
            </script>";
        }
    }

    // Struktur fungsi registrasi
    function registrasi($koneksi, $data) {
        $perpusID = $data["idperpus"];
        $username = htmlspecialchars(stripslashes($data["username"]));
        $password = mysqli_real_escape_string($koneksi, $data["password"]);
        $confirm = mysqli_real_escape_string($koneksi, $data["confirm"]);
        $namalengkap = mysqli_real_escape_string($koneksi, htmlspecialchars(stripslashes(ucwords($data["namalengkap"]))));
        $email = mysqli_real_escape_string($koneksi, htmlspecialchars(stripslashes($data["email"])));
        $telepon = mysqli_real_escape_string($koneksi, htmlspecialchars(stripslashes($data["telepon"])));
        $alamat = mysqli_real_escape_string($koneksi, htmlspecialchars(stripslashes($data["alamat"])));
        $acces_level = "peminjam";


        // cek nama sudah ada atau belum
        $result = mysqli_query($koneksi, "SELECT namalengkap FROM user WHERE namalengkap = '$namalengkap'");
        if (mysqli_fetch_assoc($result)){
            echo "<script>
                alert('Nama sudah terdaftar.....');
            </script>";
            return false;
        }
        // cek username sudah ada atau belum
        $result = mysqli_query($koneksi, "SELECT username FROM user WHERE username = '$username'");
        if (mysqli_fetch_assoc($result)){
            echo "<script>
                alert('Akun ini sudah ada!');
            </script>";
            return false;
        }

        // Cek konfirmasi password user
        if($password !== $confirm) {
            echo "<script>
                alert('Password tidak sama');
            </script>";
            return false;
        }

        $confirm = password_hash($password, PASSWORD_DEFAULT);


        // Tambahkan user ke database
        $query = "INSERT INTO user (username, namalengkap, password, email, no_hp, alamat, acces_level, perpusID) VALUES ('$username', '$namalengkap', '$confirm', '$email', '$telepon', '$alamat', '$acces_level', '$perpusID')";
        if (mysqli_query($koneksi, $query)) {
            // Tambahkan logs aktivitas
            $logs = "INSERT INTO c_logs (detail_histori) VALUES ('User bernama $username berhasil registrasi ke database')";
            if (mysqli_query($koneksi, $logs)) {
                return true;
            } else {
                echo "Error logs: " . mysqli_error($koneksi); // Tampilkan pesan error
                return false;
            }
        } else {
            echo "Error user: " . mysqli_error($koneksi); // Tampilkan pesan error
            return false;
        }
    }

    // Menutup koneksi database
    mysqli_close($koneksi);
?>
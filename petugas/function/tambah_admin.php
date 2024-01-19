<?php
    require "koneksi.php";
    // Memanggil fungsi registrasi setelah deklarasi fungsi
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Panggil fungsi registrasi
        if (isset($_POST['konfirmasi']) && $_POST['konfirmasi'] == 'on') {
            $result = registrasi($koneksi, $_POST);
            if ($result) {
                header("Location: ../view/login.php");
                echo "<script>
                    alert('Registrasi berhasil!');
                </script>";
                exit;
            } else {
                echo "<script>
                    alert('Registrasi gagal');
                </script>";
            }
        } else {
            echo "<script>
                alert('Anda harus mengonfirmasi bahwa data yang dimasukkan sudah benar.');
            </script>";
        }
    }

    // Struktur fungsi registrasi
    function registrasi($koneksi, $data) {
        $username = htmlspecialchars(stripslashes($data["username"]));
        $password = mysqli_real_escape_string($koneksi, $data["password"]);
        $confirm = mysqli_real_escape_string($koneksi, $data["confirm"]);
        $namalengkap = mysqli_real_escape_string(htmlspecialchars(stripslashes(ucwords($koneksi, $data["namalengkap"]))));
        $email = mysqli_real_escape_string(htmlspecialchars(stripslashes($koneksi, $data["email"])));
        $telepon = mysqli_real_escape_string(htmlspecialchars(stripslashes($koneksi, $data["telepon"])));
        $alamat = mysqli_real_escape_string(htmlspecialchars(stripslashes($koneksi, $data["alamat"])));
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

        // Enkripsi terlebih dahulu password user
        $confirm = password_hash($confirm, PASSWORD_DEFAULT);

        // Tambahkan user ke database
        $query = "INSERT INTO user (username, namalengkap, password, email, no_hp, alamat, acces_level) VALUES ('$username', '$namalengkap', '$confirm', '$email', '$telepon', '$alamat', '$acces_level')";
        if (mysqli_query($koneksi, $query)) {
            // Tambahkan logs aktivitas
            $adminName = $_SESSION['admin_name'] ?? "admin"; 

            $logs = "INSERT INTO c_logs (detail_histori) VALUES ('akun petugas bernama $username telah ditambahkan oleh $admin')";
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
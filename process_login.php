<?php
session_start();
include "koneksi.php"; // Sesuaikan dengan nama file koneksi ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usernameOrEmail = $_POST["username"];
    $password = $_POST["password"];

    $query = "SELECT * FROM user WHERE (username = '$usernameOrEmail' OR email = '$usernameOrEmail')";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row["password"])) {
                $_SESSION["user_id"] = $row["userID"];
                $_SESSION["username"] = $row["username"];
                $_SESSION["email"] = $row["email"];
                $_SESSION["perpus_id"] = $row["perpusID"];
                $_SESSION["alamat"] = $row["alamat"];
                $_SESSION["namalengkap"] = $row["namalengkap"];
                $_SESSION["acces_level"] = $row["acces_level"];
                $_SESSION["no_hp"] = $row["no_hp"];
                
                $_SESSION["expire_time"] = time() + 5 * 60 * 60;

                $logs = "INSERT INTO c_logs (detail_histori) VALUES ('User bernama " . $_SESSION["username"] . " telah login')";
                // Redirect ke halaman sesuai dengan acces_level
                if (mysqli_query($koneksi, $logs)) {
                    // Redirect ke halaman sesuai dengan acces_level
                    switch ($_SESSION["acces_level"]) {
                        case "admin":
                            header("Location: admin_petugas/buku.php");
                            exit();
                        case "super_admin":
                            header("Location: admin_petugas/buku.php");
                            exit();
                        case "petugas":
                            header("Location: admin_petugas/peminjaman.php");
                            exit();
                        case "peminjam":
                            header("Location: admin_petugas/buku.php");
                            exit();
                        default:
                            // Jika acces_level tidak valid, arahkan ke halaman login
                            header("Location: index.php");
                            exit();
                        }
                } else {
                // saya ibung untuk apa echo disini
                echo "Gagal mencatat log aktivitas";
                }
            } else {
                // Password salah
                echo "Password salah";
            }
        } else {
            // Username atau akun salah
            echo "Akun ini tidak ditemukan";
        }
        mysqli_close($koneksi);
    }   
}
?>

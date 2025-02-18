<?php
session_start();
include "koneksi.php"; // Sesuaikan dengan nama file koneksi ke database

// Memeriksa apakah token CSRF yang dikirimkan cocok dengan yang ada di session
if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    echo json_encode(['status' => 'error', 'message' => 'Token CSRF tidak valid']);
    exit(); // Hentikan proses jika token tidak valid
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usernameOrEmail = $_POST["username"];
    $password = $_POST["password"];

    $query = "SELECT * FROM user WHERE (username = '$usernameOrEmail' OR email = '$usernameOrEmail')";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row["password"])) {
                // Ganti ID sesi untuk mencegah session fixation attack
                session_regenerate_id(true);
                
                // Simpan data user ke session
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
                    $response = [
                        'status' => 'success',
                        'redirect' => getRedirectPage($_SESSION["acces_level"])
                    ];
                    echo json_encode($response);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan saat mencatat log']);
                }
            } else {
                // Password salah
                echo json_encode(['status' => 'error', 'message' => 'Password salah']);
            }
        } else {
            // Username atau akun salah
            echo json_encode(['status' => 'error', 'message' => 'Akun ini tidak ditemukan']);
        }
        mysqli_close($koneksi);
    }   
}

function getRedirectPage($role) {
    switch ($role) {
        case 'admin':
        case 'super_admin':
            return 'admin_petugas/buku.php';
        case 'petugas':
            return 'admin_petugas/peminjaman.php';
        case 'peminjam':
            return 'admin_petugas/buku.php';
        default:
            return 'index.php';
    }
}
?>

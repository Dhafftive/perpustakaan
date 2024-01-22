<?php
session_start();
include "koneksi.php"; // Sesuaikan dengan nama file koneksi ke database

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usernameOrEmail = $_POST["username"];
    $password = $_POST["password"];

    // Lakukan validasi atau filter input sesuai kebutuhan

    // Cek apakah username atau email ada di dalam database
    $query = "SELECT * FROM user WHERE (username = '$usernameOrEmail' OR email = '$usernameOrEmail')";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row["password"])) {
                // Password benar, buat sesi dan respon berhasil
                $_SESSION["user_id"] = $row["userID"];
                $_SESSION["username"] = $row["username"];
                $_SESSION["email"] = $row["email"];
                $_SESSION["perpus_id"] = $row["perpusID"];
                $_SESSION["alamat"] = $row["alamat"];
                $_SESSION["namalengkap"] = $row["namalengkap"];
                $_SESSION["acces_level"] = $row["acces_level"];
                $_SESSION["no_hp"] = $row["no_hp"];
                
                // Set waktu ekspirasi sesi (5 jam)
                $_SESSION["expire_time"] = time() + 5 * 60 * 60;

                $response["success"] = true;
                $response["message"] = "Login berhasil";
                $response["acces_level"] = $row["acces_level"];
            } else {
                // Password salah
                $response["success"] = false;
                $response["message"] = "Password Anda salah";
            }
        } else {
            // Akun tidak ditemukan
            $response["success"] = false;
            if (empty($usernameOrEmail) || empty($password)) {
                $response["message"] = "Username atau email dan password harus diisi";
            } else {
                $response["message"] = "Username atau email Anda salah";
            }
        }
    } else {
        // Kesalahan query
        $response["success"] = false;
        $response["message"] = "Terjadi kesalahan saat melakukan query";
    }
    
    mysqli_close($koneksi);

    // Memberikan respon dalam format JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>

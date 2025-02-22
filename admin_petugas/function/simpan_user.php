<?php
require "../../koneksi.php";

header('Content-Type: application/json');
ob_start(); // Mulai output buffering

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $result = registrasi($koneksi, $_POST);
    
    if ($result["success"]) {
        ob_end_clean();
        echo json_encode(["success" => true]);
        exit;
    } else {
        ob_end_clean();
        echo json_encode(["success" => false, "message" => $result["message"]]);
        exit;
    }
}

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

    // Cek apakah username sudah digunakan
    $result = mysqli_query($koneksi, "SELECT username FROM user WHERE username = '$username'");
    if (mysqli_fetch_assoc($result)){
        return ["success" => false, "message" => "Username sudah digunakan, silakan pilih yang lain."];
    }

    // Cek apakah email sudah digunakan
    $result = mysqli_query($koneksi, "SELECT email FROM user WHERE email = '$email'");
    if (mysqli_fetch_assoc($result)){
        return ["success" => false, "message" => "Email sudah terdaftar, gunakan email lain."];
    }

    // Cek konfirmasi password
    if ($password !== $confirm) {
        return ["success" => false, "message" => "Password tidak sama."];
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Simpan ke database
    $query = "INSERT INTO user (username, namalengkap, password, email, no_hp, alamat, acces_level, perpusID) 
              VALUES ('$username', '$namalengkap', '$hashedPassword', '$email', '$telepon', '$alamat', '$acces_level', '$perpusID')";
    
    if (mysqli_query($koneksi, $query)) {
        return ["success" => true];
    } else {
        return ["success" => false, "message" => "Terjadi kesalahan saat menyimpan data."];
    }
}

mysqli_close($koneksi);
?>

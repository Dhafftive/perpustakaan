<?php
require '../../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST['username'];
    $namalengkap = $_POST['namalengkap'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];
    $telepon = $_POST['telepon'];
    $acces_level = $_POST['level-akses'];
    $perpusID = $_POST['idperpus'];
    $userID = $_POST['iduser'];

    // Update user data in the database
    $query = "UPDATE user SET 
              username = '$username', 
              namalengkap = '$namalengkap', 
              alamat = '$alamat', 
              email = '$email', 
              no_hp = '$telepon', 
              acces_level = '$acces_level',
              perpusID = '$perpusID'
              WHERE userID = $userID";

    if (mysqli_query($koneksi, $query)) {
        // If update successful, send success response
        echo "success";
    } else {
        // If update fails, send error response
        echo "error";
    }
} else {
    // If request method is not POST, send error response
    echo "error";
}
?>

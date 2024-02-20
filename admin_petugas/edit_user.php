<?php
require 'function/cek_login.php';
require '../koneksi.php';

// Step 1: Fetch user data based on userID
if(isset($_GET['userID'])) {
    $userID = $_GET['userID']; // Assuming you passed userID through GET method
    $query = "SELECT * FROM user WHERE userID = $userID";
    $result = mysqli_query($koneksi, $query);
    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $username = $row['username'];
        $namalengkap = $row['namalengkap'];
        $alamat = $row['alamat'];
        $email = $row['email'];
        $telepon = $row['no_hp'];
        $perpusID = $row['perpusID'];
        $acces_level = $row['acces_level'];
    } else {
        // Handle case where no user is found with the provided userID
        // You can redirect or display an error message here
    }
} else {
    // Handle case where userID is not provided
    // You can redirect or display an error message here
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User - Bookshelf.Idn</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css">
    <link rel="stylesheet" href="../css/edit_user.css?v=<?php echo time(); ?>">
     <!-- Include SweetAlert CSS -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css">
</head>
<body>
<?php
require '../sidebar.php';
?>

<div id="registrationFormContainer" class="page-signup animate__animated">
    <h1 class="hdr">Edit Akun Pengguna</h1>
    <div class="signup-form">
        <form id="userForm" method="post">
            <div class="input-data">
                <div class="input-form">
                    <label for="username">Username</label>
                    <input placeholder="Masukkan username" id="username" type="text" name="username" class="input-group" value="<?= $username ?>" required>
                    <label for="namalengkap">Nama Lengkap</label>
                    <input placeholder="Masukkan nama lengkap" type="text" id="namalengkap" name="namalengkap" class="input-group" value="<?= $namalengkap ?>" required>
                    <label for="alamat">Alamat</label>
                    <input placeholder="Masukkan alamat rumah" type="text" id="alamat" name="alamat" class="input-group" value="<?= $alamat ?>" required>
                </div>
                <div class="input-form">
                    <label for="email">Email</label>
                    <input placeholder="Masukkan email" id="email" type="text" name="email" class="input-group" value="<?= $email ?>" required>
                    <label for="telepon">No. Telepon</label>
                    <input placeholder="Masukkan nomor telepon" type="text" id="telepon" name="telepon" class="input-group" value="<?= $telepon ?>" required>
                    <label for="perpustakaan">Perpustakaan</label>
                    <input type="hidden" name="idperpus" value="<?= $perpusID ?>">
                    <input type="hidden" name="iduser" value="<?= $userID ?>">
                    <select name="level-akses" id="acces-level" class="input-group">
                        <option value="peminjam" <?= ($acces_level == 'peminjam') ? 'selected' : '' ?>>Peminjam</option>
                        <option value="petugas" <?= ($acces_level == 'petugas') ? 'selected' : '' ?>>Petugas</option>
                        <option value="admin" <?= ($acces_level == 'admin') ? 'selected' : '' ?>>Admin</option>
                    </select>
                </div>
            </div>
            <div class="button-form">
                <input type="submit" value="Submit" name="Submit">
                <a href="data_user.php"><div class="cancel-button"><p class="cancel-label">Cancel</p></div></a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js"></script>
<script>
    $(document).ready(function() {
        // Inisialisasi Nice Select pada dropdown kategori
        $('#acces-level').niceSelect();
    });
</script>
<!-- Include jQuery before SweetAlert -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script>
    $(document).ready(function() {
        $('#userForm').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: 'function/update_user.php',
                type: 'post',
                data: $('#userForm').serialize(),
                success: function(response) {
                    // Show success message with SweetAlert
                    swal({
                        title: "Success",
                        text: "User data updated successfully!",
                        icon: "success",
                        timer: 2000 // 2 seconds
                    }).then(function() {
                        window.location.href = "data_user.php";
                    });
                },
                error: function(xhr, status, error) {
                    // Show error message with SweetAlert
                    swal({
                        title: "Error",
                        text: "Failed to update user data. Please try again later.",
                        icon: "error",
                    });
                }
            });
        });
    });
</script>
</body>
</html>

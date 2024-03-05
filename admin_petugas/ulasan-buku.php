<?php 
    require '../koneksi.php';
    require 'function/cek_login.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ulasan Buku</title>
    <link rel="stylesheet" href="../css/ulasan-buku.css?v=<?php echo time(); ?>">

</head>
<body>
<?php 
    require '../sidebar.php';
?>
    <div class="data-ulasan">
        <div class="ulasan-header">
            <h1 class="header">Data Ulasan Buku</h1>
        </div>
        <div class="ulasan-user">
<?php
    // Mengambil ID dari URL
    if(isset($_GET['id'])) {
        $bukuID = $_GET['id'];

        // Mengambil data ulasan berdasarkan bukuID
        $sql = "SELECT * FROM ulasanbuku WHERE bukuID = ?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("i", $bukuID);
        $stmt->execute();
        $result = $stmt->get_result();

        // Memeriksa apakah ada ulasan yang ditemukan
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) { ?>
                <div class="ulasan-card">
                    <div class="username"><?php echo $row['username']; ?></div>
                    <div class="ulasan-text"><?php echo $row['ulasan']; ?></div>
                </div>
            <?php }
        } else {
            echo "Tidak ada ulasan untuk buku ini.";
        }
        $stmt->close();
    } else {
        echo "ID buku tidak ditemukan.";
    }
?>        
        </div>
    </div>
</body>
</html>
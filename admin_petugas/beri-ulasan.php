<?php
include 'function/cek_login.php';
// Koneksi ke database
include '../koneksi.php';

// Pastikan peminjamanID tersedia dari URL
if (isset($_GET['peminjamanID'])) {
    $peminjamanID = $_GET['peminjamanID'];


    // Query untuk mengambil data peminjaman berdasarkan peminjamanID
    $peminjamanQuery = "SELECT * FROM peminjaman WHERE peminjamanID = $peminjamanID";
    $peminjamanResult = mysqli_query($koneksi, $peminjamanQuery);

    // Jika data peminjaman ditemukan
    if ($peminjamanResult && mysqli_num_rows($peminjamanResult) > 0) {
        $rowPeminjaman = mysqli_fetch_assoc($peminjamanResult);

        // Ambil informasi buku berdasarkan bukuID dari peminjaman
        $bukuID = $rowPeminjaman['bukuID'];
        $bukuQuery = "SELECT * FROM buku WHERE bukuID = $bukuID";
        $bukuResult = mysqli_query($koneksi, $bukuQuery);

        // Jika data buku ditemukan
        if ($bukuResult && mysqli_num_rows($bukuResult) > 0) {
            $rowBuku = mysqli_fetch_assoc($bukuResult);

            // Tampilkan informasi buku
            $judul = $rowBuku['judul'];
            $penulis = $rowBuku['penulis'];
            $penerbit = $rowBuku['penerbit'];
            $foto = $rowBuku['foto'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ulas Buku - Bookshelf.Idn</title>
    <link rel="stylesheet" href="../css/beri-ulasan.css?v=<?= time() ?>">
</head>
<body>
<?php 
include '../sidebar.php';
?>
<?php
// Mendapatkan peminjamanID dari URL
if(isset($_GET['peminjamanID'])) {
    $peminjamanID = $_GET['peminjamanID'];
    // Query untuk mendapatkan informasi peminjaman
    $queryPeminjaman = "SELECT * FROM peminjaman WHERE peminjamanID = $peminjamanID";
    $resultPeminjaman = mysqli_query($koneksi, $queryPeminjaman);
    $rowPeminjaman = mysqli_fetch_assoc($resultPeminjaman);
    // Mendapatkan informasi buku
    $bukuID = $rowPeminjaman['bukuID'];
    $queryBuku = "SELECT * FROM buku WHERE bukuID = $bukuID";
    $resultBuku = mysqli_query($koneksi, $queryBuku);
    $rowBuku = mysqli_fetch_assoc($resultBuku);
} else {
    // Redirect jika peminjamanID tidak ditemukan
    header("Location: bukuanda.php");
    exit();
}
?>
<div class="ulasan-cont" data-peminjamanid="<?= $peminjamanID ?>" data-userid="<?= $_SESSION['user_id'] ?>" data-bukuid="<?= $bukuID ?>">
    <div class="books-content">
        <div class="books-cover">
            <img src="../images/cover-buku/<?= $rowBuku['foto'] ?>" alt="" class="cover">
        </div>
        <div class="books">
            <div class="books-title">
                <div class="judul"><?= $rowBuku['judul'] ?></div>
                <div class="penulis"><?= $rowBuku['penulis'] ?></div>
                <div class="penerbit"><?= $rowBuku['penerbit'] ?></div>
            </div>
            <div class="books-action">
                <label for="ulasan"><p>Ulasan Anda </p></label>
                <textarea name="ulasan" id="ulasan" cols="30" rows="10" placeholder="Berikan ulasan tentang buku ini..."></textarea>
            </div>
        </div>
    </div>
    <div class="rate-cont">
        <div class="books-rate">
            <div class="rate-title">
                <p class="text">Apakah buku ini menarik untukmu? Beri penilaianmu disini</p>
            </div>
            <div class="radio-container">
                <input type="radio" id="option1" name="option" value="1">
                <label for="option1" class="radio-label"><i class="fa-solid fa-star"></i>1</label>
                
                <input type="radio" id="option2" name="option" value="2">
                <label for="option2" class="radio-label"><i class="fa-solid fa-star"></i>2</label>
                
                <input type="radio" id="option3" name="option" value="3">
                <label for="option3" class="radio-label"><i class="fa-solid fa-star"></i>3</label>
                
                <input type="radio" id="option4" name="option" value="4">
                <label for="option4" class="radio-label"><i class="fa-solid fa-star"></i>4</label>
                
                <input type="radio" id="option5" name="option" value="5">
                <label for="option5" class="radio-label"><i class="fa-solid fa-star"></i>5</label>
            </div>
        </div>
        <div class="action-btn">
            <a href="bukuanda.php">
                <div class="kembali-btn">Kembali</div>
            </a>
            <div class="upload-btn" onclick="uploadUlasan()">Upload</div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    function uploadUlasan() {
        var peminjamanID = $(".ulasan-cont").data("peminjamanid");
        var userID = $(".ulasan-cont").data("userid");
        var bukuID = $(".ulasan-cont").data("bukuid");
        var ulasan = $("#ulasan").val();
        var rating = $("input[name='option']:checked").val();
        // Kirim data ulasan ke server menggunakan AJAX
        $.ajax({
            type: "POST",
            url: "function/upload_ulasan.php",
            data: {
                peminjamanID: peminjamanID,
                userID: userID,
                bukuID: bukuID,
                ulasan: ulasan,
                rating: rating
            },
            success: function(response) {
                if (response === "success") {
                    Swal.fire({
                        icon: "success",
                        title: "Ulasan berhasil diupload.",
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        // Redirect ke halaman bukuanda.php setelah user menekan OK
                        window.location.href = "bukuanda.php";
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Ada kesalahan saat memproses permintaan."
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Terjadi kesalahan saat mengirim permintaan."
                });
            }
        });
    }
</script>
</body>
</html>

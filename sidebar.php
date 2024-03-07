<?php

// Inisialisasi variabel sidebar_items
$sidebar_items = array();

// Periksa apakah pengguna telah login dan memiliki tingkat akses
if (isset($_SESSION['acces_level'])) {
    $access_level = $_SESSION['acces_level'];
    $namalengkap = $_SESSION['namalengkap'];

    // Tentukan tampilan sidebar berdasarkan tingkat akses
    switch ($access_level) {
        case 'peminjam':
            $sidebar_items = array(
                array("selected-menu" => "etalase-page", "page" => "buku.php", "icon" => "fa-solid fa-book", "description" => "Etalase"),
                array("selected-menu" => "koleksibuku-page", "page" => "koleksibuku.php", "icon" => "fa-solid fa-book-bookmark", "description" => "Koleksi"),
                array("selected-menu" => "bukuanda-page", "page" => "bukuanda.php", "icon" => "fa-solid fa-book-open", "description" => "Buku Anda")
            );
            break;
        case 'petugas':
            $sidebar_items = array(
                array("selected-menu" => "etalase-page", "page" => "buku.php", "icon" => "fa-solid fa-book", "description" => "Etalase"),
                array("selected-menu" => "buku-page", "page" => "data-buku.php", "icon" => "fa-solid fa-book", "description" => "Data Buku"),
                array("selected-menu" => "list-kategori", "page" => "list-kategori.php", "icon" => "fa-solid fa-tags", "description" => "List Kategori"),
                array("selected-menu" => "peminjaman-page", "page" => "peminjaman.php", "icon" => "fa-solid fa-book-open-reader", "description" => "Data Peminjaman"),
                array("selected-menu" => "rekap-page", "page" => "rekap-page.php", "icon" => "fa-regular fa-folder-open", "description" => "Rekap Peminjaman")
            );
            break;
        case 'admin' OR 'super_admin':
            $sidebar_items = array(
                array("selected-menu" => "etalase-page", "page" => "buku.php", "icon" => "fa-solid fa-book", "description" => "Etalase"),
                array("selected-menu" => "koleksibuku-page", "page" => "koleksibuku.php", "icon" => "fa-solid fa-book-bookmark", "description" => "Koleksi"),
                array("selected-menu" => "bukuanda-page", "page" => "bukuanda.php", "icon" => "fa-solid fa-book-open", "description" => "Buku Anda"),
                array("selected-menu" => "buku-page", "page" => "data-buku.php", "icon" => "fa-solid fa-book", "description" => "Data Buku"),
                array("selected-menu" => "list-kategori", "page" => "list-kategori.php", "icon" => "fa-solid fa-tags", "description" => "List Kategori"),
                array("selected-menu" => "peminjaman-page", "page" => "peminjaman.php", "icon" => "fa-solid fa-book-open-reader", "description" => "Data Peminjaman"),
                array("selected-menu" => "rekap-page", "page" => "rekap-page.php", "icon" => "fa-regular fa-folder-open", "description" => "Rekap Peminjaman"),
                array("selected-menu" => "datauser-page", "page" => "data_user.php", "icon" => "fa-solid fa-address-book", "description" => "Data User"),
                array("selected-menu" => "logs-page", "page" => "logs_data.php", "icon" => "fa-solid fa-circle-exclamation", "description" => "Log Aktivitas")
            );
            break;
        default:
            // Tambahkan penanganan default jika diperlukan
            break;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="../css/sidebar.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <!-- Add this in the head section of your HTML  (Toastr.JS Library)-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <!-- Perfect Scrollbar -->
    <link rel="stylesheet" href="../libs/perfect-scrollbar/css/perfect-scrollbar.css">

    <!-- JQuery Library -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
    /* Tambahkan gaya untuk overlay */
    #overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5); /* Warna latar belakang overlay */
        z-index: 991;
    }
    </style>
</head>
    <div class="container">
        <div id="overlay"></div>
        <div class="sidebar">
            <div class="header">
                <div class="list-item">
                    <a href="">
                        <!-- <img src="./icons/admin.svg" alt="" srcset="" class="icon"> -->
                        <p class="logo">Bookshelf.<span>Idn</span></p>
                    </a>
                </div>
                <div class="ilustration">
                    <img src="../images/icons/ilustration.svg" alt="">
                </div>
            </div>
            <div class="main">
                <!-- <div class="list-item dashboard-page">
                    <a href="dashboard.php">
                        <div class="icon"><i class="fa-solid fa-chart-simple"></i></div>
                        <span class="description">Dashboard</span>
                    </a>
                </div> -->
                <?php
                // Tampilkan item sidebar sesuai dengan tingkat akses
                foreach ($sidebar_items as $item) {
                    echo '<a href="' . $item["page"] . '">';
                    echo '<div class="list-item ' . $item["selected-menu"] . '">';
                    echo '<div class="icon"><i class="' . $item["icon"] . '"></i></div>';
                    echo '<span class="description">' . $item["description"] . '</span>';
                    echo '</div>';
                }
                echo '</a>';
                ?>
            </div>
        </div>
        <div class="main-content">
    <script src="../libs/perfect-scrollbar/dist/perfect-scrollbar.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.querySelector('.main-content');
            const mainScrollbar = new PerfectScrollbar(container);
        });
    </script>
</html>
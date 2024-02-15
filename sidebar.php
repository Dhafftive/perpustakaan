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
                <div class="list-item">
                    <a href="dashboard.php">
                        <div class="icon"><i class="fa-solid fa-chart-simple"></i></div>
                        <span class="description">Dashboard</span>
                    </a>
                </div>
                <div class="list-item">
                    <a href="data_user.php">
                        <div class="icon"><i class="fa-regular fa-address-book"></i></div>
                        <span class="description">Anggota</span>
                    </a>
                </div>
                <div class="list-item">
                    <a href="buku.php">
                        <div class="icon"><i class="fa-solid fa-book"></i></div>
                        <span class="description">Buku</span>
                    </a>
                </div>
                <div class="list-item">
                    <a href="peminjaman.php">
                        <div class="icon"><i class="fa-solid fa-book-open-reader"></i></div>
                        <span class="description">Peminjaman</span>
                    </a>
                </div>
                <div class="list-item">
                    <a href="koleksibuku.php">
                        <div class="icon"><i class="fa-solid fa-book-bookmark"></i></div>
                        <span class="description">Koleksi</span>
                    </a>
                </div>
                <div class="list-item">
                    <a href="logs_data.php">
                        <div class="icon"><i class="fa-solid fa-circle-exclamation"></i></div>
                        <span class="description">Log Aktivitas</span>
                    </a>
                </div>
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
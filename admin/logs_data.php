<?php 
    include "function/cek_login.php";
    include "../koneksi.php";

    // Query untuk mengambil seluruh data dari tabel c_logs
    $query = "SELECT detail_histori, created_at FROM c_logs ORDER BY created_at DESC";
    $result = mysqli_query($koneksi, $query);

    // Fungsi untuk mengonversi format waktu
    function formatWaktu($timestamp) {
        date_default_timezone_set('Asia/Jakarta');
        $selisihDetik = time() - strtotime($timestamp);
        if ($selisihDetik >= 604800) { // Lebih dari 1 minggu (60 detik * 60 menit * 24 jam * 7 hari)
            return date("d F Y", strtotime($timestamp));
        } elseif ($selisihDetik >= 86400) { // Lebih dari 1 hari
            return floor($selisihDetik / 86400) . " hari lalu";
        } elseif ($selisihDetik >= 3600) { // Lebih dari 1 jam
            return floor($selisihDetik / 3600) . " jam lalu";
        } else { // Kurang dari 1 jam
            return floor($selisihDetik / 60) . " menit lalu";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logs - Admin</title>
    <link rel="stylesheet" href="../css/logs.css?v=<?php echo time(); ?>">
</head>
<body>
    <?php require '../sidebar.php'?>
    <div class="card">
        <h5 class="card-header">Data Aktivitas</h5>
        <div class="table-responsive">
            <table class="table-hover">
                <thead class="head-table">
                    <tr>
                        <th>Aktivitas Terkini</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody class="table-body">
                    <?php
                    // Loop melalui hasil query
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['detail_histori'] . "</td>";
                        echo "<td class='time-text'>" . formatWaktu($row['created_at']) . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
        // Ambil waktu sekarang
        var currentTime = new Date();

        // Ambil elemen-elemen yang memuat waktu dari database
        var timeElements = document.getElementsByClassName("created-at");

        // Loop melalui setiap elemen dan lakukan perhitungan selisih waktu
        for (var i = 0; i < timeElements.length; i++) {
            var createdAt = new Date(timeElements[i].textContent.trim()); // Ambil waktu dari database

            // Hitung selisih waktu dalam milidetik
            var timeDiff = currentTime - createdAt;

            // Konversi selisih waktu ke hari
            var diffDays = Math.floor(timeDiff / (1000 * 60 * 60 * 24));

            // Tampilkan selisih waktu dalam format yang sesuai
            if (diffDays >= 7) {
                // Jika lebih dari 1 minggu, tampilkan tanggal
                var options = { year: 'numeric', month: 'long', day: 'numeric' };
                timeElements[i].textContent = createdAt.toLocaleDateString('id-ID', options);
            } else if (diffDays >= 1) {
                // Jika lebih dari 1 hari, tampilkan jumlah hari
                timeElements[i].textContent = diffDays + " hari yang lalu";
            } else {
                // Jika kurang dari 1 hari, tampilkan jumlah jam
                var diffHours = Math.round(timeDiff / (1000 * 60 * 60));
                timeElements[i].textContent = diffHours + " jam yang lalu";
            }
        }

        });

    </script>
</body>
</html>
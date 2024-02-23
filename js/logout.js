
function logout() {
    // Menggunakan AJAX untuk menghapus session
    $.ajax({
        type: 'POST',
        url: '../admin_petugas/function/logout.php', // Ganti dengan path ke file logout.php sesuai struktur direktori Anda
        success: function(response) {
            // Redirect ke halaman index.php setelah session dihapus
            window.location.href = '../index.php'; // Ganti dengan path ke index.php jika diperlukan
        }
    });
}
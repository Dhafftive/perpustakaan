function pinjamBuku(bukuID, perpusID, userID) {
    // Kirim permintaan peminjaman buku menggunakan AJAX
    $.ajax({
        type: 'POST',
        url: '../admin_petugas/function/pinjam_buku.php', // Sesuaikan dengan lokasi file PHP yang sesuai
        data: {
            bukuID: bukuID,
            perpusID: perpusID,
            userID: userID,
            status_pinjam: 'dipinjam'
        },
        success: function(response) {
            console.log(response); // Cetak respons ke konsol
            // Tampilkan notifikasi sukses
            Swal.fire({
                title: 'Berhasil',
                text: 'Peminjaman berhasil diajukan!',
                icon: 'success',
                showConfirmButton: false, // Menyembunyikan tombol "OK"
                customClass: {
                    container: 'sweetalert-font sweetalert-background',
                    title: 'sweetalert-title',
                    content: 'sweetalert-text'
                }
            });
            // Perbarui halaman setelah jeda singkat
            setTimeout(function() {
                location.reload(); // Perbarui halaman
            }, 1000);
        },
        error: function(xhr, status, error) {
            console.error(error); // Cetak pesan kesalahan ke konsol
            // Tangkap pesan kesalahan dari server
            var errorMessage = xhr.responseText;
            console.error(errorMessage);
            // Tampilkan pesan kesalahan menggunakan SweetAlert
            Swal.fire({
                title: 'Gagal',
                text: 'Terjadi kesalahan saat memproses permintaan peminjaman: ' + errorMessage,
                icon: 'error',
                customClass: {
                    container: 'sweetalert-font sweetalert-background',
                    title: 'sweetalert-title',
                    content: 'sweetalert-text'
                }
            });
        }
    });
}

function pinjamBuku(bukuID, perpusID, userID) {
    // Buat kueri SQL untuk menyimpan data peminjaman ke dalam tabel peminjaman
    $.ajax({
        type: 'POST',
        url: '../admin_petugas/function/pinjam_buku.php', // Ganti 'pinjam_buku.php' dengan nama file PHP yang sesuai
        data: {
            bukuID: bukuID,
            perpusID: perpusID,
            userID: userID,
            status_pinjam: 'diajukan'
        },
        success: function(response) {
            console.log(response); // Cetak respons ke console
            // Tampilkan notifikasi SweetAlert
            Swal.fire({
                title: 'Berhasil',
                text: 'Permintaan peminjaman berhasil diajukan!',
                icon: 'success',
                customClass: {
                    container: 'sweetalert-font sweetalert-background',
                    title: 'sweetalert-title',
                    content: 'sweetalert-text'
                }
            });
        },
        error: function(xhr, status, error) {
            console.error(error); // Cetak pesan kesalahan ke console
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

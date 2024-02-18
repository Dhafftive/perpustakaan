function batalkanPeminjaman(bukuID, userID) {
    console.log("Mengirim permintaan untuk membatalkan peminjaman...");
    // Buat kueri SQL untuk menghapus data peminjaman dari tabel peminjaman
    $.ajax({
        type: 'POST',
        url: 'function/batalkan_peminjaman.php', // Ganti 'batalkan_peminjaman.php' dengan nama file PHP yang sesuai
        data: {
            bukuID: bukuID,
            userID: userID
        },
        success: function(response) {
            console.log("Respon dari server:", response); // Cetak respons ke console
            // Tampilkan notifikasi SweetAlert
            Swal.fire({
                title: 'Berhasil',
                text: 'Peminjaman berhasil dibatalkan!',
                icon: 'success',
                customClass: {
                    container: 'sweetalert-font sweetalert-background',
                    title: 'sweetalert-title',
                    content: 'sweetalert-text'
                }
            });
        },
        error: function(xhr, status, error) {
            console.error("Terjadi kesalahan:", error); // Cetak pesan kesalahan ke console
            // Tangkap pesan kesalahan dari server
            var errorMessage = xhr.responseText;
            console.error("Pesan kesalahan dari server:", errorMessage);
            // Tampilkan pesan kesalahan menggunakan SweetAlert
            Swal.fire({
                title: 'Gagal',
                text: 'Terjadi kesalahan saat membatalkan peminjaman: ' + errorMessage,
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

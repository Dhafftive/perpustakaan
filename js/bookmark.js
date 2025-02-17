/* ===========================================================================================*\
============================================ Add Bookmark ======================================
\* ===========================================================================================*/
// Fungsi untuk menambahkan buku ke koleksi pribadi
function addBookmark(bukuID) {
    // Lakukan request Ajax
    $.ajax({
        type: 'POST',
        url: '../admin_petugas/function/addbookmark.php', // Ganti 'add_bookmark.php' dengan nama file PHP yang sesuai
        data: { bukuID: bukuID }, // Kirim data bukuID
        success: function(response) {
            // Tampilkan notifikasi SweetAlert
            Swal.fire({
                title: 'Sukses',
                text: 'Buku berhasil ditambahkan ke koleksi pribadi!',
                icon: 'success',
                customClass: {
                    container: 'sweetalert-font sweetalert-background',
                    title: 'sweetalert-title',
                    content: 'sweetalert-text'
                }
            }).then(() => {
                // Setelah SweetAlert ditutup, ubah ikon bookmark menjadi bookmarked
                location.reload();
            });
        },
        error: function(xhr, status, error) {
        // Tangkap pesan kesalahan dari server
        var errorMessage = xhr.responseText;
        console.error(errorMessage);
            // Tampilkan pesan kesalahan menggunakan SweetAlert
            Swal.fire({
                title: 'Gagal',
                text: 'Terjadi kesalahan saat menambahkan buku ke koleksi pribadi: ' + errorMessage,
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


/* ===========================================================================================*\
========================================= Remove Bookmark ======================================
\* ===========================================================================================*/
// Fungsi untuk menghapus buku dari koleksi pribadi
function removeBookmark(bukuID) {
    // Lakukan request Ajax
    $.ajax({
        type: 'POST',
        url: '../admin_petugas/function/removebookmark.php', // Ganti 'removebookmark.php' dengan nama file PHP yang sesuai
        data: { bukuID: bukuID }, // Kirim data bukuID
        success: function(response) {
            // Tampilkan notifikasi SweetAlert
            Swal.fire({
                title: 'Sukses',
                text: 'Buku berhasil dihapus dari koleksi pribadi!',
                icon: 'success',
                customClass: {
                    container: 'sweetalert-font sweetalert-background',
                    title: 'sweetalert-title',
                    content: 'sweetalert-text'
                }
            }).then(() => {
                // Setelah SweetAlert ditutup, muat ulang halaman untuk memperbarui tampilan buku
                console.log(response);
                location.reload();
            });
        },
        error: function(xhr, status, error) {
            // Tangkap pesan kesalahan dari server
            var errorMessage = xhr.responseText;
            console.error(errorMessage);
            // Tampilkan pesan kesalahan menggunakan SweetAlert
            Swal.fire({
                title: 'Gagal',
                text: 'Terjadi kesalahan saat menghapus buku dari koleksi pribadi: ' + errorMessage,
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

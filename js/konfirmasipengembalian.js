function konfirmasiPengembalian(peminjamanID) {
    Swal.fire({
        title: 'Konfirmasi Pengembalian Buku',
        text: 'Apakah Anda yakin ingin mengkonfirmasi pengembalian buku?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Kirim permintaan Ajax untuk memperbarui status peminjaman
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../admin_petugas/function/proses_konfirmasi_pengembalian.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Tampilkan pesan sukses atau gagal menggunakan SweetAlert
                    if (xhr.responseText === 'success') {
                        Swal.fire({
                            title: 'Sukses',
                            text: 'Pengembalian buku berhasil dikonfirmasi.',
                            icon: 'success'
                        }).then(() => {
                            // Muat ulang halaman setelah berhasil mengembalikan peminjaman
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Gagal',
                            text: 'Ada kesalahan saat memproses permintaan.',
                            icon: 'error'
                        });
                    }
                }
            };
            xhr.send("peminjamanID=" + peminjamanID);
        }
    });
}

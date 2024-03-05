function konfirmasiPengembalian(peminjamanID) {
    Swal.fire({
        title: 'Konfirmasi Pengembalian Buku',
        text: 'Apakah anda yakin akan mengambil buku user?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Kirim permintaan Ajax untuk memperbarui status peminjaman
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../admin_petugas/function/prosespengembalian_admin.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Tampilkan pesan sukses atau gagal menggunakan SweetAlert
                    if (xhr.responseText === 'success') {
                        Swal.fire({
                            title: 'Sukses',
                            text: 'Pengembalian buku berhasil dilakukan.',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            // Refresh halaman
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

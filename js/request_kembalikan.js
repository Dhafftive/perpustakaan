function kembalikanPeminjaman(peminjamanID) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: 'Kamu harus meminjam kembali jika ingin membaca buku ini lagi',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Kembalikan',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Kirim permintaan Ajax untuk memperbarui status peminjaman
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../admin_petugas/function/prosespengembalian_manual.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Tampilkan pesan sukses atau gagal
                    Swal.fire({
                        title: xhr.responseText,
                        icon: 'success'
                    }).then(() => {
                        // Muat ulang halaman setelah berhasil mengembalikan peminjaman
                        location.reload();
                    });
                }
            };
            xhr.send("peminjamanID=" + peminjamanID);
        }
    });
}

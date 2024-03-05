
    function submitBookForm() {
        // Tangkap data dari form
        var judul = $("#judul").val();
        var penulis = $("#penulis").val();
        var penerbit = $("#penerbit").val();
        var kategori = $("#kategori").val();
        var tahun_terbit = $("#tahun-terbit").val();
        var stok_buku = $("#stok-buku").val();
        var sinopsis = $("#sinopsis").val();

        // Tangkap file cover buku yang dipilih
        var cover = document.getElementById("imageInput").files[0];

        // Tangkap file buku yang dipilih
        var bukuFile = document.getElementById("bukuFile").files[0];

        // Membuat objek FormData untuk mengirim data dan file ke server
        var formData = new FormData();
        formData.append('judul', judul);
        formData.append('penulis', penulis);
        formData.append('penerbit', penerbit);
        formData.append('kategori', kategori);
        formData.append('tahun_terbit', tahun_terbit);
        formData.append('stok_buku', stok_buku);
        formData.append('sinopsis', sinopsis);
        formData.append('cover', cover); // Menambahkan file cover
        formData.append('bukuFile', bukuFile); // Menambahkan file buku

        // Kirim data form ke server menggunakan AJAX
        $.ajax({
            type: "POST",
            url: "function/editprosesbuku.php", // Ganti dengan lokasi skrip PHP yang akan menangani permintaan
            data: formData,
            processData: false, // Memastikan tidak memproses data apa pun
            contentType: false, // Tidak mengatur tipe konten, biarkan browser yang menentukannya
        })
        .then(function(response) {
            if (response.trim() == 'success') {
                // Jika berhasil, tampilkan pesan sukses
                toastr.success('Buku berhasil diperbarui!');
                // Redirect ke halaman data buku setelah beberapa detik
                setTimeout(function() {
                    window.location.href = 'data-buku.php';
                }, 3000);
            } else {
                // Jika gagal, tampilkan pesan error
                toastr.error('Gagal memperbarui buku: ' + response);
            }
        });
    }

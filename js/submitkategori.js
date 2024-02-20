// Event listener untuk menangani pengiriman form kategori secara manual menggunakan AJAX
function submitKategoriForm() {
    // Ambil elemen form kategori
    var kategoriForm = document.getElementById('kategoriForm');

    // Buat objek FormData untuk mengumpulkan data form
    var formData = new FormData(kategoriForm);

    $.ajax({
        type: 'POST',
        url: 'function/tambah_kategori.php',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            // Tampilkan respons dari server dalam konsol
            console.log('Server Response:', response);
            
            // Coba parse response sebagai JSON
            try {
                var jsonResponse = JSON.parse(response);
                // Handle respons dari server
                if (jsonResponse.status === 'success') {
                    // Jika berhasil, tutup popup dan tampilkan notifikasi sukses
                    hideAddkategoriPopup();
                    Swal.fire('Berhasil', 'Kategori berhasil ditambahkan!', 'success').then(() => {
                        // Lakukan tindakan setelah pengguna mengklik tombol OK pada notifikasi
                        // Contoh: reload halaman
                        location.reload();
                    });
                } else {
                    // Jika ada kesalahan, tampilkan pesan kesalahan
                    console.error('Server Response:', jsonResponse); // Tampilkan respons lengkap dari server
                    Swal.fire('Gagal', jsonResponse.message || 'Terjadi kesalahan saat menambahkan kategori.', 'error');
                }
            } catch (error) {
                // Jika tidak dapat mem-parse respons sebagai JSON, tampilkan pesan kesalahan
                console.error('Error parsing server response:', error);
                Swal.fire('Gagal', 'Terjadi kesalahan saat menambahkan kategori.', 'error');
            }
        },
        
        
        error: function(xhr, status, error) {
            // Handle kesalahan ketika mengirimkan data form
            console.error('AJAX Error:', status, error); // Tambahkan informasi kesalahan ke konsol
            console.error('Response Text:', xhr.responseText); // Tampilkan respons lengkap dari server
            Swal.fire('Gagal', 'Terjadi kesalahan saat menambahkan kategori.', 'error');
        }
    });
    
    
}

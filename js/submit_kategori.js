function submitKategoriForm() {
    var kategoriInput = document.querySelector('.kategori-name').value.trim();
    
    if (kategoriInput === "") {
        Swal.fire('Gagal', 'Kategori tidak boleh kosong!', 'warning');
        return; // Stop eksekusi AJAX jika input kosong
    }

    var kategoriForm = document.getElementById('kategoriForm');
    var formData = new FormData(kategoriForm);

    $.ajax({
        type: 'POST',
        url: 'function/tambah_kategori.php',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            console.log('Server Response:', response);
            try {
                var jsonResponse = JSON.parse(response);
                if (jsonResponse.status === 'success') {
                    hideAddkategoriPopup();
                    Swal.fire('Berhasil', 'Kategori berhasil ditambahkan!', 'success').then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Gagal', jsonResponse.message || 'Terjadi kesalahan saat menambahkan kategori.', 'error');
                }
            } catch (error) {
                console.error('Error parsing server response:', error);
                Swal.fire('Gagal', 'Terjadi kesalahan saat menambahkan kategori.', 'error');
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error);
            console.error('Response Text:', xhr.responseText);
            Swal.fire('Gagal', 'Terjadi kesalahan saat menambahkan kategori.', 'error');
        }
    });
}

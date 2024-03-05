        function submitEditKategoriForm() {
            var editKategoriID = document.getElementById('edit-kategoriID').value;
            var editNamaKategori = document.getElementById('edit-namakategori').value;

            // Kirim data menggunakan AJAX
            $.ajax({
                type: 'POST',
                url: 'function/edit_kategori.php',
                data: {
                    'edit-kategoriID': editKategoriID,
                    'edit-namakategori': editNamaKategori
                },
                success: function(response) {
                    console.log('Server Response:', response);
                    // Handle respons dari server
                    if (response === 'success') {
                        // Jika berhasil, tutup popup dan tampilkan notifikasi sukses
                        hideEditForm();
                        Swal.fire('Berhasil', 'Kategori berhasil diedit!', 'success').then(() => {
                            // Lakukan tindakan setelah pengguna mengklik tombol OK pada notifikasi
                            // Contoh: reload halaman
                            location.reload();
                        });
                    } else {
                        // Jika ada kesalahan, tampilkan pesan kesalahan
                        console.error('Server Response:', response);
                        Swal.fire('Gagal', 'Terjadi kesalahan saat mengedit kategori.', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    // Handle kesalahan ketika mengirimkan data form
                    console.error('AJAX Error:', status, error);
                    console.error('Response Text:', xhr.responseText);
                    Swal.fire('Gagal', 'Terjadi kesalahan saat mengedit kategori.', 'error');
                }
            });
        }

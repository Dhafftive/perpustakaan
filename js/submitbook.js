    // Definisikan fungsi submitBookForm
    function submitBookForm() {
        var formData = new FormData($('#bookForm')[0]);

        $.ajax({
            type: 'POST',
            url: '../admin_petugas/buku.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response); 

                // Periksa respons dari server
                if (response === 'success') {
                    // Handle berhasil
                    console.log('Buku berhasil ditambahkan.');

                    // Tutup popup form addbook
                    hideAddbookPopup();

                    // Tampilkan notifikasi SweetAlert untuk sukses
                    Swal.fire({
                        title: 'Berhasil',
                        text: 'Buku berhasil ditambahkan!',
                        icon: 'success',
                        customClass: {
                            container: 'sweetalert-font sweetalert-background',
                            title: 'sweetalert-title',
                            content: 'sweetalert-text'
                        }
                    }).then(() => {
                        // Lakukan tindakan setelah pengguna mengklik tombol OK pada notifikasi
                        // Contoh: reload halaman
                        location.reload();
                    });
                } else {
                    // Handle error
                    console.error(response);

                    // Tampilkan notifikasi SweetAlert untuk error
                    Swal.fire({
                        title: 'Gagal',
                        text: response,
                        icon: 'error',
                        customClass: {
                            container: 'sweetalert-font sweetalert-background',
                            title: 'sweetalert-title',
                            content: 'sweetalert-text'
                        }
                    });
                }
            },

            error: function (xhr, status, error) {
                // Handle error
                console.error(xhr.responseText);

                // Tampilkan notifikasi SweetAlert untuk error
                Swal.fire({
                    title: 'Gagal',
                    text: 'Terjadi kesalahan saat menambahkan buku.',
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

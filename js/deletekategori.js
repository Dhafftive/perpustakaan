// Function to delete a category
function deleteCategory(kategoriID) {
    // Prompt confirmation using SweetAlert
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Anda tidak akan dapat mengembalikan ini!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Create an AJAX request to delete the category
            $.ajax({
                type: 'POST',
                url: 'function/delete_kategori.php', // Path to your PHP script for deleting categories
                data: { kategoriID: kategoriID }, // Send the category ID to the server
                success: function(response) {
                    // Handle the response from the server
                    if (response === 'success') {
                        // If deletion is successful, show success message using SweetAlert
                        Swal.fire(
                            'Terhapus!',
                            'Kategori telah dihapus.',
                            'success'
                        ).then(() => {
                            // Reload the page to reflect the changes
                            location.reload();
                        });
                    } else {
                        // If there is an error, display an error message using SweetAlert
                        Swal.fire(
                            'Gagal!',
                            'Gagal menghapus kategori. Silakan coba lagi.',
                            'error'
                        );
                    }
                },
                error: function(xhr, status, error) {
                    // If there is an AJAX error, display an error message using SweetAlert
                    console.error('AJAX Error:', status, error);
                    Swal.fire(
                        'Gagal!',
                        'Terjadi kesalahan saat menghapus kategori.',
                        'error'
                    );
                }
            });
        }
    });
}

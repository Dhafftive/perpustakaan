$(document).ready(function() {
    $("#loginForm").submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "process_login.php",
            data: $(this).serialize(),
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    // Redirect ke halaman sesuai dengan acces_level
                    switch (response.acces_level) {
                        case "admin":
                            window.location.href = "admin.php";
                            break;
                        case "petugas":
                            window.location.href = "petugas.php";
                            break;
                        case "peminjam":
                            window.location.href = "peminjam.php";
                            break;
                        default:
                            // Jika acces_level tidak valid, arahkan ke halaman login
                            window.location.href = "login.php";
                            break;
                    }
                } else {
                    // Tampilkan pesan kesalahan
                    alert(response.message);
                }
            }
        });
    });
});

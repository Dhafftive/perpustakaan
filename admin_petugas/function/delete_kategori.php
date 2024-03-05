<?php
    // Include your database connection file
    include "../../koneksi.php";

    // Check if the request method is POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if 'kategoriID' is set in the POST data
        if(isset($_POST['kategoriID'])) {
            $kategoriID = $_POST['kategoriID'];

            // Query to delete the category with the specified ID
            $query = "DELETE FROM kategoribuku WHERE kategoriID = $kategoriID";

            // Execute the query
            if (mysqli_query($koneksi, $query)) {
                // If deletion is successful, send a success response
                echo 'success';
            } else {
                // If there is an error, send an error response
                echo 'error';
            }
        } else {
            // If 'kategoriID' is not set in the POST data, send an error response
            echo 'Missing kategoriID in POST data';
        }
    } else {
        // If the request method is not POST, send an error response
        echo 'Invalid request method. Only POST requests are allowed.';
    }
?>

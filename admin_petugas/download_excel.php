<?php
require '../vendor/autoload.php'; // Include the Composer autoloader

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Your database connection
$koneksi = mysqli_connect("localhost", "root", "", "perpustakaan");

// Your SQL query result
$peminjamansql = "SELECT peminjaman.peminjamanID, peminjaman.userID, peminjaman.tanggal_pinjam, peminjaman.tanggal_kembali, peminjaman.status_pinjam, peminjaman.bukuID, buku.judul, buku.foto, user.namalengkap
        FROM peminjaman
        INNER JOIN buku ON peminjaman.bukuID = buku.bukuID
        INNER JOIN user ON peminjaman.userID = user.userID
        WHERE peminjaman.status_pinjam != 'diajukan'";

// Execute the query and fetch the result
$resultPeminjaman = mysqli_query($koneksi, $peminjamansql);

// Create a new Spreadsheet object
$spreadsheet = new Spreadsheet();

// Get the active sheet
$sheet = $spreadsheet->getActiveSheet();

// Add headers to the first row
$sheet->setCellValue('A1', 'Nama Lengkap');
$sheet->setCellValue('B1', 'Status Pinjam');
$sheet->setCellValue('C1', 'Tanggal Pinjam');
$sheet->setCellValue('D1', 'Tanggal Dikembalikan');
$sheet->setCellValue('E1', 'Judul Buku');

// Populate the Excel file with data from the SQL query result
$row = 2; // Start from the second row
while ($rowPeminjaman = mysqli_fetch_assoc($resultPeminjaman)) {
    $sheet->setCellValue('A' . $row, $rowPeminjaman['namalengkap']);
    $sheet->setCellValue('B' . $row, $rowPeminjaman['status_pinjam']);
    $sheet->setCellValue('C' . $row, $rowPeminjaman['tanggal_pinjam']);
    $sheet->setCellValue('D' . $row, $rowPeminjaman['tanggal_kembali']);
    $sheet->setCellValue('E' . $row, $rowPeminjaman['judul']);
    $row++;
}

// Set the appropriate headers for Excel file download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="peminjaman_data.xlsx"');
header('Cache-Control: max-age=0');

// Write the Excel file to the output buffer
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

// Terminate the script to prevent any additional output
exit();
?>

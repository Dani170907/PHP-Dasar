<?php

require 'assets/fpdf/fpdf.php';
require_once 'assets/functions/functions.php';

$siswa = query("SELECT * FROM siswa");

$pdf = new FPDF();
$pdf->AddPage();

// Menambahkan judul
$pdf->SetFont('Arial', 'B', 16); // Ukuran font judul dikurangi
$pdf->Cell(0, 10, 'Daftar Siswa', 0, 1, 'C');
$pdf->Ln(10);

// Menghitung lebar tabel
$tableWidth = 10 + 30 + 60 + 30 + 30; // No + Gambar + Nama + NIS + Tanggal Lahir
$x = ($pdf->GetPageWidth() - $tableWidth) / 2; // Hitung posisi X untuk tengah
$pdf->SetX($x); // Pindahkan posisi X

// Menambahkan header tabel
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(10, 10, 'No', 1, 0, 'C');
$pdf->Cell(30, 10, 'Gambar', 1, 0, 'C');
$pdf->Cell(60, 10, 'Nama', 1, 0, 'C');
$pdf->Cell(30, 10, 'NIS', 1, 0, 'C');
$pdf->Cell(30, 10, 'Tanggal Lahir', 1, 0, 'C');
$pdf->Ln();

// Menambahkan data siswa ke tabel
$pdf->SetFont('Arial', '', 12);
$id = 1;
foreach ($siswa as $row) {
    $pdf->SetX($x); // Set posisi X untuk setiap baris data
    $pdf->Cell(10, 30, $id, 1, 0, 'C');

    // Kolom Gambar
    $imagePath = 'assets/foto/' . $row['gambar'];
    if (file_exists($imagePath)) {
        $pdf->Cell(30, 30, $pdf->Image($imagePath, $pdf->GetX() + 2, $pdf->GetY() + 2, 26), 1);
    } else {
        $pdf->Cell(30, 30, 'No Image', 1, 0, 'C');
    }

    $pdf->Cell(60, 30, $row['nama'], 1);
    $pdf->Cell(30, 30, $row['nis'], 1);
    $pdf->Cell(30, 30, $row['tanggal_lahir'], 1);

    $pdf->Ln();
    $id++;
}

// Output file PDF
$pdf->Output();

?>

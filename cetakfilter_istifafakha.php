<?php
require('fpdf.php');
include 'koneksi.php';

$filter_kelas = isset($_GET['kelas']) ? $_GET['kelas'] : '';
$filter_semester = isset($_GET['semester']) ? $_GET['semester'] : '';
$filter_tahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';

$sql = "SELECT n.*, s.nama, k.nama_kelas, m.nama_mapel, m.kkm
        FROM nilai_istifafakha n 
        JOIN siswa_istifafakha s ON n.nis = s.nis 
        JOIN kelas_istifafakha k ON s.id_kelas = k.id_kelas 
        JOIN mapel_istifafaka m ON n.id_mapel = m.id_mapel WHERE 1=1";

if ($filter_kelas != "") $sql .= " AND k.nama_kelas = '$filter_kelas'";
if ($filter_semester != "") $sql .= " AND n.semester = '$filter_semester'";
if ($filter_tahun != "") $sql .= " AND n.tahun_ajaran = '$filter_tahun'";

$result = $koneksi->query($sql);

$pdf = new FPDF('L', 'mm', 'A4'); 
$pdf->AddPage(); 

$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'LAPORAN HASIL KOMPETENSI SISWA', 0, 1, 'C');
$pdf->Ln(10);

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(230, 230, 230);
$pdf->Cell(10, 10, 'No', 1, 0, 'C', true);
$pdf->Cell(25, 10, 'NIS', 1, 0, 'C', true);
$pdf->Cell(50, 10, 'Nama Siswa', 1, 0, 'C', true);
$pdf->Cell(25, 10, 'Kelas', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Mapel', 1, 0, 'C', true);
$pdf->Cell(15, 10, 'KKM', 1, 0, 'C', true);
$pdf->Cell(20, 10, 'Tugas', 1, 0, 'C', true);
$pdf->Cell(20, 10, 'UTS', 1, 0, 'C', true);
$pdf->Cell(20, 10, 'UAS', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Nilai Akhir', 1, 1, 'C', true);

$pdf->SetFont('Arial', '', 10);
$no = 1;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(10, 8, $no++, 1, 0, 'C');
        $pdf->Cell(25, 8, $row['nis'], 1, 0, 'C');
        $pdf->Cell(50, 8, $row['nama'], 1, 0, 'L');
        $pdf->Cell(25, 8, $row['nama_kelas'], 1, 0, 'C');
        $pdf->Cell(40, 8, $row['nama_mapel'], 1, 0, 'L');
        $pdf->Cell(15, 8, $row['kkm'], 1, 0, 'C');
        $pdf->Cell(20, 8, $row['nilai_tugas'], 1, 0, 'C');
        $pdf->Cell(20, 8, $row['nilai_uts'], 1, 0, 'C');
        $pdf->Cell(20, 8, $row['nilai_uas'], 1, 0, 'C');
        $pdf->Cell(30, 8, $row['nilai_akhir'], 1, 1, 'C');
    }
} else {
    $pdf->Cell(255, 10, 'Tidak ada data ditemukan', 1, 1, 'C');
}

$pdf->Output('I', 'Laporan_Nilai.pdf'); 
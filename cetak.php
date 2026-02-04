<?php
require('fpdf.php');
include "koneksi.php";

$nis = $_GET['nis'];
$smt = $_GET['smt'];
$tp = $_GET['tp'];

$query_mhs = mysqli_query($koneksi, "SELECT s.*, k.nama_kelas, g.nama_guru, n.tahun_ajaran
            FROM siswa_istifafakha s
            JOIN kelas_istifafakha k ON s.id_kelas = k.id_kelas
            JOIN guru_istifafakha g ON k.id_guru = g.id_guru
            JOIN nilai_istifafakha n ON s.nis = n.nis
            WHERE s.nis = '$nis' 
            LIMIT 1;");
$mhs = mysqli_fetch_array($query_mhs);
$query_abs = mysqli_query($koneksi, "SELECT * FROM absensi_istifafakha WHERE nis = '$nis'");
$abs = mysqli_fetch_array($query_abs);

$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 16);
$pdf->SetTextColor(44, 62, 80);
$pdf->Cell(0, 7, 'LAPORAN HASIL BELAJAR', 0, 1, 'C');
$pdf->Cell(0, 7, 'SMK NEGERI 2 CIMAHI', 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 7, 'Tahun Ajaran : ' . $mhs['tahun_ajaran'], 0, 1, 'C');
$pdf->Ln(3);
$pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
$pdf->SetTextColor(0, 0, 0);
$pdf->Ln(10);

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(30, 6, 'Nama Siswa', 0, 0);
$pdf->Cell(70, 6, ': ' . $mhs['nama'], 0, 0);
$pdf->Cell(30, 6, 'Kelas', 0, 0);
$pdf->Cell(0, 6, ': ' . $mhs['nama_kelas'], 0, 1);
$pdf->Cell(30, 6, 'NIS', 0, 0);
$pdf->Cell(70, 6, ': ' . $mhs['nis'], 0, 0);
$pdf->Cell(30, 6, 'Semester', 0, 0);
$pdf->Cell(0, 6, ': ' . $smt, 0, 1);
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(230, 230, 230);
$pdf->Cell(10, 10, 'No', 1, 0, 'C', true);
$pdf->Cell(80, 10, 'Mata Pelajaran', 1, 0, 'C', true);
$pdf->Cell(15, 10, 'KKM', 1, 0, 'C', true);
$pdf->Cell(20, 10, 'Nilai', 1, 0, 'C', true);
$pdf->Cell(65, 10, 'Keterangan', 1, 1, 'C', true);
$pdf->SetFont('Arial', '', 10);

$no = 1;
$query_nilai = mysqli_query($koneksi, "SELECT n.*, m.nama_mapel, m.kkm 
               FROM nilai_istifafakha n 
               JOIN mapel_istifafaka m ON n.id_mapel = m.id_mapel 
               WHERE n.nis = '$nis' AND n.semester = '$smt' AND n.tahun_ajaran = '$tp'");

while ($data = mysqli_fetch_array($query_nilai)) {
    $pdf->Cell(10, 8, $no++, 1, 0, 'C');
    $pdf->Cell(80, 8, $data['nama_mapel'], 1, 0, 'L');
    $pdf->Cell(15, 8, $data['kkm'], 1, 0, 'C');
    $pdf->Cell(20, 8, (int) $data['nilai_akhir'], 1, 0, 'C');
    $ket = ($data['nilai_akhir'] >= $data['kkm']) ? 'Tuntas' : 'Remedial';
    $pdf->Cell(65, 8, $ket, 1, 1, 'C');
}

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(50, 7, 'Ketidakhadiran', 1, 1, 'L', true);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(35, 6, 'Sakit', 1, 0, 'L');
$pdf->Cell(15, 6, ($abs['sakit'] ?? 0) . ' Hari', 1, 1, 'C');
$pdf->Cell(35, 6, 'Izin', 1, 0, 'L');
$pdf->Cell(15, 6, ($abs['izin'] ?? 0) . ' Hari', 1, 1, 'C');
$pdf->Cell(35, 6, 'Tanpa Ket.', 1, 0, 'L');
$pdf->Cell(15, 6, ($abs['alfa'] ?? 0) . ' Hari', 1, 1, 'C');

$pdf->Ln(15);
$pdf->Cell(60, 5, 'Mengetahui,', 0, 0, 'C');
$pdf->Cell(60, 5, '', 0, 0, 'C');
$pdf->Cell(70, 5, 'Cimahi, ' . date('d F Y'), 0, 1, 'C');
$pdf->Cell(60, 5, 'Orang Tua/Wali', 0, 0, 'C');
$pdf->Cell(60, 5, 'Wali Kelas', 0, 0, 'C');
$pdf->Cell(70, 5, 'Kepala Sekolah', 0, 1, 'C');

$pdf->Ln(20);
$pdf->Cell(60, 5, '( ............................ )', 0, 0, 'C');
$pdf->Cell(60, 5, '( ' . $mhs['nama_guru'] . ' )', 0, 0, 'C');
$pdf->Cell(70, 5, '( ............................ )', 0, 1, 'C');

$pdf->Output('I', 'Raport_' . $mhs['nama'] . '.pdf');
?>
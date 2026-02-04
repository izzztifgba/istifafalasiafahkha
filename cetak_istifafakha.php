<?php
include "koneksi.php";

$nis = $_GET['nis'];
$smt = $_GET['smt'];
$tp = $_GET['tp'];

$query_mhs = mysqli_query($koneksi, "SELECT s.*, k.nama_kelas, g.nama_guru FROM siswa_istifafakha s 
            JOIN kelas_istifafakha k ON s.id_kelas = k.id_kelas 
            JOIN guru_istifafakha g ON g.id_guru = k.id_guru 
            WHERE s.nis = '$nis';");
$mhs = mysqli_fetch_array($query_mhs);

$query_absensi = mysqli_query($koneksi, "SELECT * FROM absensi_istifafakha WHERE nis = '$nis'");
$abs = mysqli_fetch_array($query_absensi);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Cetak Raport - <?php echo $mhs['nama']; ?></title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            padding: 20px;
        }

        h4 {
            text-align: center;
            color: #2c3e50;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 30px;
            border-bottom: 3px solid #007bff;
            display: inline-block;
            width: 100%;
            padding-bottom: 10px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .info-table {
            width: 100%;
            border: none;
            margin-bottom: 20px;
        }

        .info-table td {
            padding: 3px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th,
        .data-table td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        .data-table th {
            background-color: #f2f2f2;
        }

        .absensi-section {
            margin-top: 20px;
            width: 30%;
        }

        .footer {
            margin-top: 50px;
            width: 100%;
        }

        .ttd {
            float: right;
            text-align: center;
            width: 200px;
        }

        .footer-container {
            margin-top: 50px;
            width: 100%;
        }

        .footer-table {
            width: 100%;
            border: none !important;
        }

        .footer-table td {
            border: none !important;
            text-align: center;
            vertical-align: top;
            width: 33%;
            padding-top: 20px;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2 style="margin:0;">LAPORAN HASIL BELAJAR (RAPORT)</h2>
        <h3 style="margin:0;">SMK NEGERI 2 CIMAHI</h3>
        <h4 style="margin:0;">Tahun Ajaran <?php echo $tp; ?></h4>
    </div>

    <table class="info-table">
        <tr>
            <td width="15%">Nama Siswa</td>
            <td width="35%">: <?php echo $mhs['nama']; ?></td>
            <td width="15%">Kelas</td>
            <td>: <?php echo $mhs['nama_kelas']; ?></td>
        </tr>
        <tr>
            <td>NIS</td>
            <td>: <?php echo $mhs['nis']; ?></td>
            <td>Semester</td>
            <td>: <strong><?php echo $smt; ?></strong></td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="35%">Mata Pelajaran</th>
                <th>KKM</th>
                <th>Nilai Akhir</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $query_nilai = mysqli_query($koneksi, "SELECT n.*, m.nama_mapel, m.kkm 
                           FROM nilai_istifafakha n 
                           JOIN mapel_istifafaka m ON n.id_mapel = m.id_mapel 
                           WHERE n.nis = '$nis' 
                           AND n.semester = '$smt' 
                           AND n.tahun_ajaran = '$tp'");

            if (mysqli_num_rows($query_nilai) > 0) {
                while ($data = mysqli_fetch_array($query_nilai)) {
                    $ket = ($data['nilai_akhir'] >= $data['kkm']) ? "Tuntas" : 
                    "Remedial";
                    echo "<tr>
                        <td>$no</td>
                        <td style='text-align:left;'>$data[nama_mapel]</td>
                        <td>$data[kkm]</td>
                        <td>$data[nilai_akhir]</td>
                        <td>$ket</td>
                    </tr>";
                    $no++;
                }
            } else {
                echo "<tr><td colspan='6'>Data nilai untuk semester ini belum diinput.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <table class="data-table absensi-section">
        <tr>
            <th colspan="2">Ketidakhadiran</th>
        </tr>
        <tr>
            <td style="text-align:left;">Sakit</td>
            <td><?php echo $abs['sakit'] ?? 0; ?> hari</td>
        </tr>
        <tr>
            <td style="text-align:left;">Izin</td>
            <td><?php echo $abs['izin'] ?? 0; ?> hari</td>
        </tr>
        <tr>
            <td style="text-align:left;">Tanpa Keterangan</td>
            <td><?php echo $abs['alfa'] ?? 0; ?> hari</td>
        </tr>
    </table>

    <div class="footer-container">
        <table class="footer-table">
            <tr>
                <td>
                    Mengetahui,<br>Orang Tua/Wali<br><br><br><br><br>
                    ( ................................ )
                </td>
                <td>
                    <br>Wali Kelas<br><br><br><br><br>
                    <b>(<?php echo  $mhs['nama_guru'] ?>)</b>
                </td>
                <td>
                    Cimahi, <?= date('d F Y') ?><br>Kepala Sekolah<br><br><br><br><br>
                    <b>( ................................ )</b>
                </td>
            </tr>
        </table>
    </div> <br> <br> <br> <br>
    <div class="no-print" style="margin-bottom: 20px; text-align: left;">
        <a href="output.php"
            style="font-size: 17px;">Kembali</a> <br>

        <a href="cetak.php?nis=<?= $nis ?>&smt=<?= $smt ?>&tp=<?= $tp ?>"
            style="font-size: 17px;">Download PDF
        </a>
    </div>

</body>

</html>
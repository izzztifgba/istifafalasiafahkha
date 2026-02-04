<?php
include 'koneksi.php';

$sql = "SELECT * FROM siswa_istifafakha
        ORDER BY nis ASC, nama ASC";

$result = $koneksi->query($sql);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <title>Daftar Siswa - E-Raport</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 20px;
        }

        h2 {
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

        p {
            text-align: center;
            margin-bottom: 20px;
        }

        .table-data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table-data th,
        .table-data td {
            border: 1px solid #444;
            padding: 10px 8px;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .red {
            color: #d9534f;
            font-weight: bold;
        }
    </style>
</head>
<center>

    <body>
        <h2>Daftar Seluruh Siswa</h2>
        <table class="table-data">
            <thead>
                <tr>
                    <th width="5%" class="text-center">NIS</th>
                    <th width="17%">Nama Lengkap</th>
                    <th width="15%">Tempat, Tgl Lahir</th>
                    <th width="20%">Alamat</th>
                    <th width="13%" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $tgl_indo = date('d-m-Y', strtotime($row['tgl_lahir']));

                        echo "<tr>";
                        echo "<td><strong>" . $row['nis'] . "</strong></td>";
                        echo "<td>" . $row['nama'] . "</td>";
                        echo "<td>" . $row['tempat_lahir'] . ", " . $tgl_indo . "</td>";
                        echo "<td>" . $row['alamat'] . "</td>";
                        echo "<td class='text-center'>
                            <a href='editsiswa_istifafakha.php?nis=" . $row['nis'] . "' class='btn btn-edit'>Edit</a>
                            <a href='hapusdata_istifafakha.php?nis=" . $row['nis'] . "' class='btn btn-hapus' onclick=\"return confirm('Hapus siswa ini? Semua nilai terkait juga akan terhapus!')\">Hapus</a>
                          </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center'>Belum ada data siswa.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </body><br>
    <a href="tambahsiswa_istifafakha.php">ᯓ➤Tambah Siswa Baru</a> <br>
    <a href="output.php">ᯓ➤Lihat Daftar Nilai</a>
</center>

</html>
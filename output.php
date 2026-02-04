<?php
include 'koneksi.php';

$filter_kelas = isset($_GET['kelas']) ? $_GET['kelas'] : '';
$filter_semester = isset($_GET['semester']) ? $_GET['semester'] : '';
$filter_tahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';

$sql = "SELECT 
            n.id_nilai, s.nis, s.nama AS nama_siswa, 
            k.nama_kelas AS kelas, m.nama_mapel AS nama_mapel, 
            m.kkm, n.nilai_tugas, n.nilai_uts, n.nilai_uas, 
            n.nilai_akhir, n.deskripsi, n.semester, n.tahun_ajaran 
        FROM nilai_istifafakha n 
        JOIN siswa_istifafakha s ON n.nis = s.nis 
        JOIN kelas_istifafakha k ON s.id_kelas = k.id_kelas 
        JOIN mapel_istifafaka m ON n.id_mapel = m.id_mapel WHERE 1=1";

if ($filter_kelas != "") {
    $sql .= " AND k.nama_kelas = '$filter_kelas'";
}
if ($filter_semester != "") {
    $sql .= " AND n.semester = '$filter_semester'";
}
if ($filter_tahun != "") {
    $sql .= " AND n.tahun_ajaran = '$filter_tahun'";
}

$sql .= " ORDER BY n.id_nilai ASC";

$result = $koneksi->query($sql);

$kelas_options = $koneksi->query("SELECT nama_kelas FROM kelas_istifafakha");
$tahun_options = $koneksi->query("SELECT DISTINCT tahun_ajaran FROM nilai_istifafakha");
?>
<style>
    .filter-container {
        background: #cdcae4;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 8px;
        display: flex;
        gap: 10px;
        justify-content: center;
        align-items: center;
    }

    select,
    button {
        padding: 8px;
        border-radius: 4px;
        border: 1px solid #ccc;
    }

    .btn-filter {
        background-color: #007bff;
        color: white;
        cursor: pointer;
        border: none;
    }

    .btn-reset {
        background-color: #6c757d;
        color: white;
        text-decoration: none;
        padding: 8px 12px;
        border-radius: 4px;
        font-size: 13px;
    }

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

<h2 style="margin:0; letter-spacing: 2px;">SMK Negeri 2 CIMAHI <br> HASIL CAPAIAN KOMPETENSI SISWA</h2> <br><br>

<table class="table-data">
    <div class="filter-container">
        <form method="GET" action="">
            <select name="kelas">
                <option value="">Berdasarkan Kelas</option>
                <?php while ($k = $kelas_options->fetch_assoc()): ?>
                    <option value="<?= $k['nama_kelas']; ?>" <?= ($filter_kelas == $k['nama_kelas']) ? 'selected' : ''; ?>>
                        <?= $k['nama_kelas']; ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <select name="semester">
                <option value="">Berdasarkan Semester</option>
                <option value="Ganjil" <?= ($filter_semester == 'Ganjil') ? 'selected' : ''; ?>>Ganjil</option>
                <option value="Genap" <?= ($filter_semester == 'Genap') ? 'selected' : ''; ?>>Genap</option>
            </select>

            <select name="tahun">
                <option value="">Berdasarkan Tahun</option>
                <?php while ($t = $tahun_options->fetch_assoc()): ?>
                    <option value="<?= $t['tahun_ajaran']; ?>" <?= ($filter_tahun == $t['tahun_ajaran']) ? 'selected' : ''; ?>>
                        <?= $t['tahun_ajaran']; ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <button type="submit" class="btn-filter">Filter</button>
            <a href="output.php" class="btn-reset">Reset</a>
            <div style="margin-top: 10px; text-align: center;">
                <?php if ($filter_kelas || $filter_semester || $filter_tahun): ?>
                    <a href="cetakfilter_istifafakha.php?kelas=<?= $filter_kelas ?>&semester=<?= $filter_semester ?>&tahun=<?= $filter_tahun ?>"
                        class="btn btn-success"
                        style="text-decoration: none; padding: 10px; background: #28a745; color: white; border-radius: 5px;"
                        target="_blank">
                        🖨️ Cetak Hasil Filter
                    </a>
                <?php else: ?>
                    <a href="cetakfilter_istifafakha.php" class="btn btn-success"
                        style="text-decoration: none; padding: 10px; background: #28a745; color: white; border-radius: 5px;"
                        target="_blank">
                        🖨️ Cetak Semua Data
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>
    <thead>
        <tr>
            <th>ID Nilai</th>
            <th>NIS</th>
            <th>Nama Siswa</th>
            <th>Kelas</th>
            <th>Mata Pelajaran</th>
            <th>KKM</th>
            <th>Tugas</th>
            <th>UTS</th>
            <th>UAS</th>
            <th>Nilai Akhir</th>
            <th>Keterangan</th>
            <th>Semester</th>
            <th>Tahun Pelajaran</th>
            <th class="btn-aksi">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $is_remedial = ($row['nilai_akhir'] < $row['kkm']) ? "red" : "";
                $ket = ($row['nilai_akhir'] >= $row['kkm']) ? "Tuntas" : "Remedial";

                echo "<tr>";
                echo "<td class='text-center'>" . $row['id_nilai'] . "</td>";
                echo "<td class='text-center'>" . $row['nis'] . "</td>";
                echo "<td>" . $row['nama_siswa'] . "</td>";
                echo "<td class='text-center'>" . $row['kelas'] . "</td>";
                echo "<td>" . $row['nama_mapel'] . "</td>";
                echo "<td class='text-center'>" . $row['kkm'] . "</td>";
                echo "<td class='text-center'>" . $row['nilai_tugas'] . "</td>";
                echo "<td class='text-center'>" . $row['nilai_uts'] . "</td>";
                echo "<td class='text-center'>" . $row['nilai_uas'] . "</td>";
                echo "<td class='text-center bold $is_remedial'>" . $row['nilai_akhir'] . "</td>";
                echo "<td class='text-center $is_remedial' style='font-size:12px;'>" . $ket . "</td>";
                echo "<td class='text-center'>" . $row['semester'] . "</td>";
                echo "<td class='text-center'>" . $row['tahun_ajaran'] . "</td>";
                echo "<td class='text-center'>
                        <a href='editdata_istifafakha.php?id=" . $row['id_nilai'] . "' class='btn'>Edit</a>
                        <a href='hapusdata_istifafakha.php?id=" . $row['id_nilai'] . "' class='btn btn-danger' onclick='return confirm(\"Yakin hapus data ini?\")'>Hapus</a>
                        <a href='cetak_istifafakha.php?nis=" . $row['nis'] . "&smt=" . $row['semester'] . "&tp=" . $row['tahun_ajaran'] . "' class='btn btn-success'>Cetak</a>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='14' class='text-center'>Tidak ada data nilai.</td></tr>";
        }
        ?>
    </tbody>
</table>

<div style="margin-top: 20px;">
    <a href='tambahdata_istifafakha.php'>+ Tambah Nilai Baru</a><br>
    <a href='siswadata_istifafakha.php'>Data Siswa</a>
</div>
<?php
include 'koneksi.php';

$query_tfa = mysqli_query($koneksi, "SELECT id_nilai FROM nilai_istifafakha ORDER BY id_nilai DESC LIMIT 1");
$data_tfa = mysqli_fetch_assoc($query_tfa);

if ($data_tfa) {
    $no = (int) substr($data_tfa["id_nilai"], 2, 3);
    $no++;
} else {
    $no = 1;
}
$id_nilai_tfa = "N" . str_pad($no, 3, "0", STR_PAD_LEFT);
?>

<style>
    body {
        background-color: #f4f7f6;
        color: #333;
        margin: 40px auto;
        max-width: 600px;
        padding: 20px;
        font-family: Arial, sans-serif;
    }

    h3 {
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

    form {
        background: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    label {
        display: block;
        font-weight: bold;
        margin-top: 15px;
        margin-bottom: 5px;
        font-size: 14px;
        color: #555;
    }

    .form-control {
        width: 100%;
        padding: 12px;
        margin-bottom: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
        font-size: 14px;
        transition: border-color 0.3s;
    }

    .form-control:focus {
        border-color: #007bff;
        outline: none;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.2);
    }

    input[type="number"].form-control {
        display: inline-block;
        width: 32%;
        margin-right: 1%;
    }

    input[type="number"].form-control:last-child {
        margin-right: 0;
    }

    textarea.form-control {
        resize: vertical;
        min-height: 80px;
    }

    .btn-simpan {
        width: 100%;
        background-color: #007bff;
        color: white;
        padding: 14px;
        border: none;
        border-radius: 4px;
        font-weight: bold;
        cursor: pointer;
        font-size: 16px;
        margin-top: 20px;
        transition: background 0.3s;
    }

    .btn-simpan:hover {
        background-color: #0056b3;
    }

    .back-link {
        display: block;
        text-align: center;
        margin-top: 20px;
        text-decoration: none;
        color: #666;
        font-size: 13px;
    }

    .back-link:hover {
        color: #007bff;
        text-decoration: underline;
    }
</style>

<?php
if (isset($_POST['submit'])) {
    $nis_istifafakha = $_POST['nis'];
    $mapel_istifafakha = $_POST['id_mapel'];
    $tgs_istifafakha = $_POST['tugas'];
    $uts_istifafakha = $_POST['uts'];
    $uas_istifafakha = $_POST['uas'];
    $desc_istifafakha = $_POST['deskripsi'];
    $semester_istifafakha = $_POST['semester'];
    $tahun_ajaran_istifafakha = $_POST['tahun_ajaran'];

    $akhir_istifafakha = ($tgs_istifafakha + $uts_istifafakha + $uas_istifafakha) / 3;

    $query = "INSERT INTO nilai_istifafakha (id_nilai, nis, id_mapel, nilai_tugas, nilai_uts, nilai_uas, nilai_akhir, deskripsi, semester, tahun_ajaran) 
              VALUES ('$id_nilai_tfa', '$nis_istifafakha', '$mapel_istifafakha', '$tgs_istifafakha', '$uts_istifafakha', '$uas_istifafakha', '$akhir_istifafakha', '$desc_istifafakha', '$semester_istifafakha', '$tahun_ajaran_istifafakha')";

    if ($koneksi->query($query)) {
        echo "<script>alert('Data Berhasi Disimpan!!'); window.location='output.php';</script>";
    } else {
        echo "Error: " . $koneksi->error;
    }
}
?>

<h3>Input Nilai Siswa</h3>
<form method="POST">
    <label>Peserta Didik (NIS)</label>
    <select name="nis" class="form-control" required>
        <option value="">-- Pilih Siswa --</option>
        <?php
        $siswa_istifafakha = $koneksi->query("SELECT * FROM siswa_istifafakha");
        while ($s = $siswa_istifafakha->fetch_assoc()) {
            echo "<option value='" . $s['nis'] . "'>" . $s['nis'] . " - " . $s['nama'] . "</option>";
        }
        ?>
    </select>

    <label>Tahun Pelajaran</label>
    <select name="tahun_ajaran" class="form-control" required>
        <option value="">-- Pilih Tahun Pelajaran --</option>
        <option value="2023/2024">2023/2024</option>
        <option value="2024/2025">2024/2025</option>
        <option value="2025/2026">2025/2026</option>
        <option value="2026/2027">2026/2027</option>
    </select>

    <label>Pilih Kelas</label>
    <select name="id_kelas" class="form-control" required>
        <option value="">-- Pilih Kelas --</option>
        <?php
        $kelas_istifafakha = $koneksi->query("SELECT * FROM kelas_istifafakha");
        while ($k = $kelas_istifafakha->fetch_assoc()) {
            echo "<option value='" . $k['id_kelas'] . "'>" . $k['nama_kelas'] . "</option>";
        }
        ?>
    </select>

    <label>Semester</label>
    <select name="semester" class="form-control" required>
        <option value="">-- Pilih Semester --</option>
        <option value="Ganjil">Ganjil</option>
        <option value="Genap">Genap</option>
    </select>

    <label>Mata Pelajaran</label>
    <select name="id_mapel" class="form-control" required>
        <option value="">-- Pilih Mapel --</option>
        <?php
        $mapel_istifafakha = $koneksi->query("SELECT * FROM mapel_istifafaka");
        while ($m = $mapel_istifafakha->fetch_assoc()) {
            echo "<option value='" . $m['id_mapel'] . "'>" . $m['nama_mapel'] . "</option>";
        }
        ?>
    </select>

    <label>Nilai (Tugas / UTS / UAS)</label>
    <div style="display: flex; justify-content: space-between;">
        <input type="number" name="tugas" class="form-control" placeholder="Tugas" min="0" max="100" required>
        <input type="number" name="uts" class="form-control" placeholder="UTS" min="0" max="100" required>
        <input type="number" name="uas" class="form-control" placeholder="UAS" min="0" max="100" required>
    </div>

    <label>Deskripsi Capaian</label>
    <textarea name="deskripsi" class="form-control" placeholder="Ketik deskripsi kemajuan belajar di sini..."
        required></textarea>

    <button type="submit" name="submit" class="btn-simpan">SIMPAN DATA</button>
    <a href="output.php" class="back-link">↤ Kembali ke Daftar Nilai</a>
</form>
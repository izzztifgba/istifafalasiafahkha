<?php
include 'koneksi.php';
$id = $_GET['id'];

$query = "SELECT n.*, s.nama AS nama_siswa, s.id_kelas 
          FROM nilai_istifafakha n 
          JOIN siswa_istifafakha s ON n.nis = s.nis 
          WHERE n.id_nilai = '$id'";
$data = $koneksi->query($query)->fetch_assoc();

if (isset($_POST['update'])) {
    $nis = $_POST['nis'];
    $id_kelas = $_POST['id_kelas'];
    $mapel = $_POST['id_mapel'];
    $tgs = $_POST['tugas'];
    $uts = $_POST['uts'];
    $uas = $_POST['uas'];
    $desc = $_POST['deskripsi'];
    $semester = $_POST['semester'];
    $tahun_ajaran = $_POST['tahun_ajaran'];

    $akhir = ($tgs * 0.2) + ($uts * 0.3) + ($uas * 0.5);

    $upd = "UPDATE nilai_istifafakha SET 
            nis='$nis',
            id_mapel='$mapel',
            nilai_tugas='$tgs', 
            nilai_uts='$uts', 
            nilai_uas='$uas', 
            nilai_akhir='$akhir', 
            deskripsi='$desc',
            semester='$semester',
            tahun_ajaran='$tahun_ajaran'
            WHERE id_nilai='$id'";

    $upd_siswa = "UPDATE siswa_istifafakha SET id_kelas='$id_kelas' WHERE nis='$nis'";

    if ($koneksi->query($upd) && $koneksi->query($upd_siswa)) {
        echo "<script>alert('Data Berhasil Diperbarui!'); window.location='output.php';</script>";
    } else {
        echo "Error: " . $koneksi->error;
    }
}
?>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f7f6;
        color: #333;
        margin: 40px auto;
        max-width: 600px;
        padding: 20px;
    }

    h3 {
        text-align: center;
        color: #2c3e50;
        text-transform: uppercase;
        border-bottom: 3px solid #3c7fc2;
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
        font-size: 14px;
    }

    .form-control {
        width: 100%;
        padding: 12px;
        margin-bottom: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .info-readonly {
        background-color: #e9ecef;
        cursor: not-allowed;
        border: 1px dashed #adb5bd;
    }

    .input-group-nilai {
        display: flex;
        gap: 10px;
    }

    .btn-update {
        width: 100%;
        background-color: #007bff;
        color: white;
        padding: 14px;
        border: none;
        border-radius: 4px;
        font-weight: bold;
        cursor: pointer;
        margin-top: 20px;
    }

    .back-link {
        display: block;
        text-align: center;
        margin-top: 20px;
        text-decoration: none;
        color: #666;
    }
</style>

<h3>Edit Nilai Peserta Didik</h3>

<form action="" method="POST">
    <label>Nilai Akhir (Otomatis)</label>
    <input type="text" class="form-control info-readonly" value="<?= $data['nilai_akhir'] ?>" readonly>

    <label>Ubah Siswa (NIS)</label>
    <select name="nis" class="form-control" required>
        <?php
        $siswa = $koneksi->query("SELECT * FROM siswa_istifafakha");
        while ($s = $siswa->fetch_assoc()) {
            $selected = ($s['nis'] == $data['nis']) ? "selected" : "";
            echo "<option value='" . $s['nis'] . "' $selected>" . $s['nis'] . " - " . $s['nama'] . "</option>";
        }
        ?>
    </select>

    <label>Ubah Kelas</label>
    <select name="id_kelas" class="form-control" required>
        <?php
        $kelas_query = $koneksi->query("SELECT * FROM kelas_istifafakha");
        while ($k = $kelas_query->fetch_assoc()) {
            $selected = ($k['id_kelas'] == $data['id_kelas']) ? "selected" : "";
            echo "<option value='" . $k['id_kelas'] . "' $selected>" . $k['nama_kelas'] . "</option>";
        }
        ?>
    </select>

    <label>Tahun Pelajaran</label>
    <select name="tahun_ajaran" class="form-control" required>
        <?php
        $tahun_list = ["2023/2024", "2024/2025", "2025/2026", "2026/2027"];
        foreach ($tahun_list as $th) {
            $selected = ($th == $data['tahun_ajaran']) ? "selected" : "";
            echo "<option value='$th' $selected>$th</option>";
        }
        ?>
    </select>

    <label>Semester</label>
    <select name="semester" class="form-control" required>
        <option value="Ganjil" <?= ($data['semester'] == 'Ganjil') ? 'selected' : '' ?>>Ganjil</option>
        <option value="Genap" <?= ($data['semester'] == 'Genap') ? 'selected' : '' ?>>Genap</option>
    </select>

    <label>Mata Pelajaran</label>
    <select name="id_mapel" class="form-control" required>
        <?php
        $mapel = $koneksi->query("SELECT * FROM mapel_istifafaka");
        while ($m = $mapel->fetch_assoc()) {
            $selected = ($m['id_mapel'] == $data['id_mapel']) ? "selected" : "";
            echo "<option value='" . $m['id_mapel'] . "' $selected>" . $m['nama_mapel'] . "</option>";
        }
        ?>
    </select>

    <label>Update Nilai (Tugas / UTS / UAS)</label>
    <div class="input-group-nilai">
        <input type="number" name="tugas" class="form-control" value="<?= $data['nilai_tugas'] ?>" required>
        <input type="number" name="uts" class="form-control" value="<?= $data['nilai_uts'] ?>" required>
        <input type="number" name="uas" class="form-control" value="<?= $data['nilai_uas'] ?>" required>
    </div>

    <label>Deskripsi Capaian</label>
    <textarea name="deskripsi" class="form-control" required><?= $data['deskripsi'] ?></textarea>

    <button type="submit" name="update" class="btn-update">UPDATE DATA</button>
    <a href="output.php" class="back-link">↤ Batal dan Kembali</a>
</form>
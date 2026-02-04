<?php
include 'koneksi.php';

if (!isset($_GET['nis'])) {
    header("Location: output.php");
    exit;
}

$nis_lama = $_GET['nis'];

$query_siswa = $koneksi->query("SELECT * FROM siswa_istifafakha WHERE nis = '$nis_lama'");
$data = $query_siswa->fetch_assoc();

if (!$data) {
    echo "<script>alert('Data tidak ditemukan!'); window.location='siswadata_istifafakha.php';</script>";
    exit;
}

if (isset($_POST['update'])) {
    $nis_baru = $_POST['nis'];
    $nama = $_POST['nama'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $alamat = $_POST['alamat'];

    $update = "UPDATE siswa_istifafakha SET 
                nis = '$nis_baru', 
                nama = '$nama', 
                tempat_lahir = '$tempat_lahir', 
                tgl_lahir = '$tgl_lahir', 
                alamat = '$alamat'
                WHERE nis = '$nis_lama'";

    if ($koneksi->query($update)) {
        echo "<script>alert('🟢 Data Siswa Berhasil Diperbarui!'); window.location='siswadata_istifafakha.php';</script>";
    } else {
        echo "Error: " . $koneksi->error;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Data Siswa</title>
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
</head>

<body>

    <h3>Edit Data Siswa</h3>

    <form method="POST">
        <label>Nomor Induk Siswa (NIS)</label>
        <input type="text" name="nis" class="form-control" value="<?= $data['nis']; ?>" required>

        <label>Nama Lengkap</label>
        <input type="text" name="nama" class="form-control" value="<?= $data['nama']; ?>" required>

        <div style="display: flex; gap: 10px;">
            <div style="flex: 1;">
                <label>Tempat Lahir</label>
                <input type="text" name="tempat_lahir" class="form-control" value="<?= $data['tempat_lahir']; ?>"
                    required>
            </div>
            <div style="flex: 1;">
                <label>Tanggal Lahir</label>
                <input type="date" name="tgl_lahir" class="form-control" value="<?= $data['tgl_lahir']; ?>" required>
            </div>
        </div>

        <label>Alamat Lengkap</label>
        <textarea name="alamat" class="form-control" required><?= $data['alamat']; ?></textarea>

        <button type="submit" name="update" class="btn-update">SIMPAN PERUBAHAN</button>
        <a href="siswadata_istifafakha.php" class="back-link">↤ Batal dan Kembali</a>
    </form>

</body>

</html>
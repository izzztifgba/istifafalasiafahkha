<?php
include 'koneksi.php';

if (isset($_POST['submit'])) {
    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $alamat = $_POST['alamat'];
    $id_kelas = $_POST['id_kelas'];

    $cek_nis = $koneksi->query("SELECT nis FROM siswa_istifafakha WHERE nis = '$nis'");

    if ($cek_nis->num_rows > 0) {
        echo "<script>
                alert('🔴 GAGAL!! NIS $nis sudah terdaftar. Gunakan NIS lain.');
                window.history.back();
              </script>";
    } else {
        $query = "INSERT INTO siswa_istifafakha (nis, nama, tempat_lahir, tgl_lahir, alamat, id_kelas) 
                  VALUES ('$nis', '$nama', '$tempat_lahir', '$tgl_lahir', '$alamat', '$id_kelas')";

        if ($koneksi->query($query)) {
            echo "<script>alert('🟢 Data Siswa Berhasil Disimpan!'); window.location='output.php';</script>";
        } else {
            echo "Error: " . $koneksi->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Siswa</title>
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
</head>
<body>

<h3>Tambah Data Siswa Baru</h3>

<form method="POST">
    <label>Nomor Induk Siswa (NIS)</label>
    <input type="text" name="nis" class="form-control" placeholder="Contoh: 12345" required>

    <label>Nama Lengkap</label>
    <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap Siswa" required>

    <div style="display: flex; gap: 10px;">
        <div style="flex: 1;">
            <label>Tempat Lahir</label>
            <input type="text" name="tempat_lahir" class="form-control" placeholder="Kota" required>
        </div>
        <div style="flex: 1;">
            <label>Tanggal Lahir</label>
            <input type="date" name="tgl_lahir" class="form-control" required>
        </div>
    </div>
    <label>Alamat Lengkap</label>
    <textarea name="alamat" class="form-control" placeholder="Alamat rumah..." required></textarea>

    <button type="submit" name="submit" class="btn-simpan">DAFTARKAN SISWA</button>
    <a href="siswadata_istifafakha.php" class="back-link">↤ Kembali ke Daftar Siswa</a>
</form>

</body>
</html>
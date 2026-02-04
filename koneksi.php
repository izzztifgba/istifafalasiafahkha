<?php
$koneksi = mysqli_connect("localhost", "root", "", "dbraport_istifafakha", 3306);

if (mysqli_connect_errno()) {
    echo "Koneksi database gagal : " . mysqli_connect_errno();
}

?>
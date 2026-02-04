<?php
include 'koneksi.php';

if(isset($_GET['id'])){
    $id = $_GET['id'];
    
    $koneksi->query("DELETE FROM nilai_istifafakha WHERE id_nilai = '$id'");
    header("Location: output.php");
}
?>
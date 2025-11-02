<?php
    include 'connection.php';

    $id_prodi = base64_decode($_GET['id']);

    $kode_angka = $_POST['kode_angka'];
    $kode_huruf = $_POST['kode_huruf'];
    $inisial = $_POST['inisial'];
    $nama_prodi = $_POST['nama_prodi'];

    $sql = 'UPDATE prodi SET kode_angka = "'.$kode_angka.'", kode_huruf = "'.$kode_huruf.'", inisial = "'.$inisial.'", nama_prodi = "'.$nama_prodi.'" 
            WHERE id_prodi = "'.$id_prodi.'"';

    $query = $conn->query($sql);

    if ($query) {
        header('Location: index.php?menu=prodi&updated=1');
    } else {
        header('Location: error.html');
    }
?>
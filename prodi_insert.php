<?php
    include 'connection.php';

    $kode_angka = $_POST['kode_angka'];
    $kode_huruf = $_POST['kode_huruf'];
    $inisial = $_POST['inisial'];
    $nama_prodi = $_POST['nama_prodi'];

    $sql = 'INSERT INTO prodi (kode_angka, kode_huruf, inisial, nama_prodi) 
            VALUES ("'.$kode_angka.'", "'.$kode_huruf.'", "'.$inisial.'", "'.$nama_prodi.'")';

    $query = $conn->query($sql);

    if ($query) {
        header('Location: index.php?menu=prodi?success=true');
    } else {
        header('Location: error.html');
    }
?>
<?php
    include 'connection.php';

    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $id_prodi = $_POST['id_prodi'];

    $sql = 'INSERT INTO mahasiswa (nim, nama, jenis_kelamin, id_prodi) 
            VALUES ("'.$nim.'", "'.$nama.'", "'.$jenis_kelamin.'", "'.$id_prodi.'")';

    $query = $conn->query($sql);

    if ($query) {
        header('Location: index.php?menu=mahasiswa&success=1');
    } else {
        header('Location: error.html');
    }
?>

<?php
    include 'connection.php';

    $nim_lama = base64_decode($_GET['id']);

    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $id_prodi = $_POST['id_prodi'];

    $sql = 'UPDATE mahasiswa 
            SET nim = "'.$nim.'", 
                nama = "'.$nama.'", 
                jenis_kelamin = "'.$jenis_kelamin.'", 
                id_prodi = "'.$id_prodi.'" 
            WHERE nim = "'.$nim_lama.'"';

    $query = $conn->query($sql);

    if ($query) {
        header('Location: index.php?menu=mahasiswa&updated=1');
    } else {
        header('Location: error.html');
    }
?>

<?php
    include 'connection.php';

    $id_prodi = base64_decode($_GET['id']);

    $sql = 'DELETE FROM prodi WHERE id_prodi = "'.$id_prodi.'"';

    $query = $conn->query($sql);

    if ($query) {
        header('Location: index.php?menu=prodi&deleted=1');
    } else {
        header('Location: error.html');
    }
?>
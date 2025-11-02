<?php
    include 'connection.php';

    $id_prodi = base64_decode($_GET['id']);

    $sql = 'SELECT * FROM prodi WHERE id_prodi = "'.$id_prodi.'"';

    $query = $conn->query($sql);

    $rows = $query->fetch(PDO::FETCH_OBJ);

    echo json_encode($rows);
?>
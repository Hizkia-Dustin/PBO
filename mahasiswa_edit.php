<?php
    include 'connection.php';

    // Decode id (nim) dari parameter URL
    $nim = base64_decode($_GET['id']);

    // Ambil data mahasiswa berdasarkan nim
    $sql = 'SELECT * FROM mahasiswa WHERE nim = "'.$nim.'"';

    $query = $conn->query($sql);

    $rows = $query->fetch(PDO::FETCH_OBJ);

    // Kembalikan data dalam bentuk JSON
    echo json_encode($rows);
?>

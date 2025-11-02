<?php
    include 'connection.php';

    // Decode id (NIM) dari parameter URL
    $nim = base64_decode($_GET['id']);

    // Query hapus mahasiswa
    $sql = 'DELETE FROM mahasiswa WHERE nim = "'.$nim.'"';

    $query = $conn->query($sql);

    if ($query) {
        header('Location: index.php?menu=mahasiswa&deleted=1');
    } else {
        header('Location: error.html');
    }
?>

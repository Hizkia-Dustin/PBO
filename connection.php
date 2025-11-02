<?php
    $dsn = 'mysql:dbname=simak;host=127.0.0.1';
    // $dsn = 'pgsql:host=127.0.0.1;port=5432;dbname=simak';
    $user = 'root';
    $password = '';

    $conn = new PDO($dsn, $user, $password);
?>
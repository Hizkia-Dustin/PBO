<?php
    $menu = empty($_GET['menu']) ? 'dashboard' : $_GET['menu'];
    $page = explode('?', $menu)[0]; // Sanitize to remove any query parameters

    include 'header.php';
    include $page.'.php';
    include 'footer.php';
?>

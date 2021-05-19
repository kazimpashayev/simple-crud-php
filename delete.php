<?php

    $query = $db->prepare('DELETE FROM topic WHERE id = ?');
    $query->execute([
        $_GET['id']
    ]);
    header('location:index.php');
    exit;

?>
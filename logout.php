<?php 
    session_destroy();
    header('location:index.php?page=login');
    exit;
?>
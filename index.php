<?php 

    ob_start();
    require_once 'db.php';
    session_start();

    $_GET = array_map(function($get){
        return htmlspecialchars(trim($get));
    }, $_GET);

    if (!isset($_GET['page'])) {

        $_GET['page'] = 'index';
    }

    switch ($_GET['page']) {

        case 'index':
            require_once 'home.php';
        break;
        
        case 'login':
            require_once 'login.php';
        break;
        
        case 'register':
            require_once 'register.php';
        break;
        
        case 'logout':
            require_once 'logout.php';
        break;
        
        case 'topic':
            require_once 'topic.php';
        break;
        
        case 'read':
            require_once 'read.php';
        break;
        
        case 'update':
            require_once 'update.php';
        break;
        
        case 'delete':
            require_once 'delete.php';
        break;
        
        case 'categories':
            require_once 'categories.php';
        break;

        case 'add-category':
            require_once 'add-category.php';
        break;
        
        case 'category':
            require_once 'category.php';
        break;    
    }



?>
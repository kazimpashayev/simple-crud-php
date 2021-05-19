<?php 

	// Database config
	$host = 'localhost';
	$db_name = 'crud';
	$username = 'root';
	$password = '';


    try {
    $db = new PDO('mysql:host=' . $host . ';dbname=' . $db_name, $username, $password);
	} catch (PDOException $e){
	    die($e->getMessage());
	}

?>
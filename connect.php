<?php 

    $hostname='localhost';
    $username='root';
    $password='';
    $database='test';
    $port=3306;

    $db=mysqli_connect($hostname, $username, $password, $database, $port);

    if(!$db) {
        echo 'Failed to established successfully';
    }

?>
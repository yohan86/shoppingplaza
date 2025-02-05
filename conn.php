<?php
    $servername ='localhost';
    $username ='root';
    $password='';
    $dbname='phoneshop';

    $conn = new mysqli($servername, $username, $password, $dbname);

    if($conn -> connect_errno){
        die("connection faild".$conn->connect_error);
    }

?>
<?php
session_start();
include('../conn.php');

$itemid = $_GET['order'];

$sql = "DELETE FROM orders WHERE order_id='$itemid'";

$itemsql = "DELETE FROM order_items WHERE order_id='$itemid'";

$sqlresullt = mysqli_query($conn, $sql);
$itemresult = mysqli_query($conn, $itemsql);

if($sqlresullt && $itemresult ){
    header('Location: orders.php');
    exit;
}else{
    echo 'Error:'.$conn->error;
}

?>
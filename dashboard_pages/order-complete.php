<?php
include('../conn.php');
$orderId = $_GET['order'];
$sql = "UPDATE orders SET status='completed' WHERE order_id='$orderId'";

if(mysqli_query($conn, $sql)){
    header('Location: orders.php');
    exit;
}else{
    echo "Error apear while removing order";
}

?>
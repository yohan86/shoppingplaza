<?php
session_start();

if(isset($_POST['product_id'])){
$productid = $_POST['product_id'];

if(isset($_SESSION['cart'][$productid])){
    unset ($_SESSION['cart'][$productid]);
}

header("Location: cart.php");
exit;

}


?>
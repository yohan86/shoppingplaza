<?php
session_start();
if(isset($_POST['add_to_cart'])){
    $productid = $_POST['product_id'];
    $productname = $_POST['productname'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    if(!isset($_SESSION['cart'])){
        $_SESSION['cart'] = [];
    }

    if(isset($_SESSION['cart'][$productid])){
        $_SESSION['cart'][$productid]['quantity'] += $quantity;
    }else{
        $_SESSION['cart'][$productid] = [
            'product_id' => $productid,
            'product_name' => $productname,
            'price' => $price,
            'quantity' => $quantity,
            'invoicetotal' => 0

        ];

    }
    $cart_count = array_sum(array_column($_SESSION['cart'], 'quantity'));
    $response = [
        "cart_count"=> $cart_count
    ];
    header('Content-Type: application/json'); // Ensure it's sent as JSON
    echo json_encode($response);


}
?>

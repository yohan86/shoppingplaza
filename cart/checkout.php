<html>
    <head>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../style.css">

    </head>
    <body>
<?php 
include('../header.php'); 
include('../conn.php');

if(isset($_POST['checkout_submit'])){
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = trim($_POST['email']);
    $address = $_POST['address'];

    $totalamount = 0;
    $cartitems = [];
    foreach($_SESSION['cart'] as $item){
        $totalamount += $item['price'] * $item['quantity'];

        $cartitems[] = [
            'item_name'=> $item['product_name'],
            'item_price' => $item['price'],
            'quantity' => $item['quantity'],
            'total' => $item['price'] * $item['quantity']
        ];



    }


    if($totalamount <= 0){
        echo 'invalid total';
        exit;
    }

    $sql = "INSERT INTO orders (customer_name, email, phone, address, total_amount, status) VALUES('$name', '$email', '$phone', '$address', '$totalamount', 'pending' )";

    if(mysqli_query($conn, $sql)){
        $orderid = mysqli_insert_id($conn);
        
        foreach($cartitems as $order){
        
            $ordersql = "INSERT INTO order_items (order_id, item_name, quantity, unit_price) VALUE('$orderid', '{$order['item_name']}', '{$order['quantity']}', '{$order['item_price']}')";
            mysqli_query($conn, $ordersql);
        }

        unset($_SESSION['cart']);


        $_SESSION['orderID'] = $orderid;

        header("Location: order_success.php");
        exit();
    }


}



?>
<div class="page-wrapper">
    <h2 class="page-title">Order Process Form</h2>
 
    <div class="columns-wrapper contact">
        <div class="columns form register">
            <Form action="checkout.php" method="POST">
                <div class="field-wrapper">
                    <label>Name:*</label>
                    <input type="text" name="name" value=""  required/>
                </div>
                <div class="field-wrapper">
                    <label>Phone:*</label>
                    <input type="number" name="phone" value="" required />
                </div>
                <div class="field-wrapper">
                    <label>Email Address:*</label>
                    <input type="email" name="email" value=""  required/>
                </div>
                <div class="field-wrapper">
                    <label>Delivery Address:*</label>
                    <textarea name="address" required></textarea>
                </div>
                <div class="field-wrapper button">
                    <span class="small-text">* Required Fields</span>
                    <button type="submit" name="checkout_submit">Submit</button>
                </div>
            </form>

        </div>
    </div>
</div>


<?php include('../footer.php'); ?>
    </body>

</html>

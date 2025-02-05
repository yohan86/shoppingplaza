<html>
    <head>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../style.css">

    </head>
    <body>
<?php 
include('../header.php'); 
include('../conn.php');

?>
<div class="page-wrapper">
    <h2 class="page-title">Your Shopping Cart Details</h2>
    <div class="cart-container">

        <?php 
        if(!isset($_SESSION['cart']) || empty($_SESSION['cart']) ){
           echo "<p>Your shopping cart is empty !";
        }else{ 
        ?>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th class="left-align">Price</th>
                    <th class="center-align">Q.tity</th>
                    <th class="right-align">Total (Rs)</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tbody>
            <?php 
             $invoicetotal = 0;
            foreach($_SESSION['cart'] as $productid => $item): 
                
                $cartsql = "SELECT * FROM products WHERE pid='$productid'";
                $result = $conn->query($cartsql);

                if($result && $row = $result->fetch_assoc()){
                    $itemprice = (float)$item['price'];
                    $itemquntity = (int)$item['quantity'];
                $total = $itemprice * $itemquntity;
                $invoicetotal += $total;

                echo<<<EOD
                    <tr>
                        <td><div class="table-inner">{$row['pname']}</div></td>
                        <td class="left-align">Rs.{$item['price']}</td>
                        <td class="center-align">{$item['quantity']}
                        </td>
                        <td class="right-align">{$total}</td>
                        <td>
                        <form method="POST" action="remove_from_cart.php">
                                    <input type="hidden" name="product_id" value="{$productid}">
                                    <button type="submit">Remove</button>
                                </form>
                        </td>
                    </tr>
                EOD;
            ?>

            <?php
             } 
            endforeach;
            ?>
            </tbody>
        </table>
        <?php
            $formatMoney = number_format($invoicetotal, 2, '.', ',');
            $_SESSTION['total_amount'] = $formatMoney;
            echo<<<EOD
                <div class="cart-summery">
                    <ul>
                        <li>Total Amount: Rs. {$formatMoney}</li>
                        <li><a href="checkout.php">Check out</a></li>
                    </ul>
    
                </div>
            EOD;
    
    } 
    ?>
    </div>
</div>


<?php include('../footer.php'); ?>
    </body>

</html>

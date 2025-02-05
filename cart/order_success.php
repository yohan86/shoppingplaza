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
    <h2 class="page-title success">Thank you for your order!</h2>
    <div class="cart-container">
        <p>Your order has been placed successfully. We will send you an email confirmation soon.</p>
        <p>Your order ID is: <strong><?php echo "#".$_SESSION['orderID']; ?></strong></p>
    </div>
</div>


<?php include('../footer.php'); ?>
    </body>

</html>

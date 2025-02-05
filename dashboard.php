<html>
  <head>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

  </head>
  <body>
  <?php 
  include('header.php');

  $infor= $items = $orderdetails ='';

  if(isset($_SESSION['email'])){

    $loggedUser = trim($_SESSION['email']);
    $sql = "SELECT * FROM orders WHERE email='$loggedUser' AND status='pending'";
    $result = mysqli_query($conn, $sql);

    if($result->num_rows > 0){
      while($row = $result->fetch_assoc()){
        $orderid = $row['order_id'];

        $ordersql = "SELECT * FROM order_items WHERE  order_id='$orderid'";
        $orderlist = $conn->query($ordersql);

        if($orderlist){
          $orderdetails .=<<<EOD
            <h4>Your Order ID :#{$orderid}</h4>
            <table class="cart-table">
              <thead>
                  <tr>
                      <th>Items</th>
                      <th class="center-align">Qn.tity</th>
                      <th class="right-align">Unit Price</th>
                      <th class="right-align"><div class="td-inner">Status</div></th>
                  </tr>
              </thead>
              <tbody>
          EOD;



          while($order = $orderlist->fetch_assoc()){
            $unitprice = number_format($order['unit_price'], 2, '.', ',');
            $orderdetails .=<<<EOD
                <tr>
                    <td class="left-align"><div class="table-inner">{$order['item_name']}</div></td>
                    <td class="center-align">{$order['quantity']}</td>
                    <td class="right-align">{$unitprice}</td>
                    <td class="right-align"><div class="td-inner">{$row['status']}</div></td>
                </tr>
            EOD;

          }
          $orderdetails .=<<<EOD
            </tbody>
              </table>
          EOD;

        }

      }
    }else{
      $infor = "No Pending Orders";
    }
    
  }else{
    header("Location: index.php");
  }
  
  ?>
    <div class="page-wrapper">
        <h2 class="page-title">Welcome to <?=$_SESSION['user']?></h2>
        <?php if($infor){ 
          echo "<p> {$infor}</p>";
        }
        if(($orderdetails)){
          echo<<<EOD
          <p>Your pending order list</p>
          <div class="column">
            {$orderdetails}   
          </div>
          EOD;
        }
        ?>
        
    </div>
<?php include('footer.php'); ?>
  </body>
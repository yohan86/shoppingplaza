<html>
  <head>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script   src="../script.js"></script>
    <link rel="stylesheet" href="../style.css">

  </head>
  <body>
    <?php include('../header.php');
    include('../conn.php');
    ?>
    <div class="page-wrapper">
        <h2 class="page-title">Orders</h2>
        <div class="columns-wrapper">
           
            <div class="order-wrapper">

                 <?php
                    $odersSql = "SELECT * FROM orders WHERE status='pending'";
                    $result = $conn -> query($odersSql);

                    $completedSql = "SELECT * FROM orders WHERE status='completed'";
                    $completeresult = $conn -> query($completedSql);
                    $completedcount = $completeresult->num_rows;
                    
                    if($result->num_rows > 0){
                        $totalOrders = $result->num_rows;
                        echo<<<EOD
                        <div class="order-status-wrapper">
                        EOD;

                            if($completedcount){
                                echo<<<EOD
                                    <div class="order-info-box green">
                                        <h3>Completed Orders</h3>
                                        <span class="info-number">{$completedcount}</span>
                                    </div>
                                EOD;
                            }

                        echo<<<EOD
                                <div class="order-info-box">
                                    <h3>Pending Orders</h3>
                                    <span class="info-number">{$totalOrders}</span>
                                </div>
                        </div>
                        <h3 class="section-title">Pending Orders</h3>
                        EOD;
                        
                        
                        while($row = $result->fetch_assoc()){
                            $products='';
                            $orderid = (int)$row['order_id'];
                  
                            $itemsql = "SELECT * FROM order_items WHERE  order_id='$orderid'";
                
                            $itemlist = $conn->query($itemsql);
                 
                            if($itemlist){
                                while($item = $itemlist->fetch_assoc()){
                                    $unitprice = number_format($item['unit_price'], 2, '.', ',');
                                    $products .=<<<EOD
                                        
                                                <tr>
                                                    <td class="left-align"><div class="item-name">{$item['item_name']}</div></td>
                                                    <td class="center-align">{$item['quantity']}</td>
                                                    <td class="right-align">{$unitprice}</td>
                                                </tr>
                                    EOD;

                                }
                            }else{
                                echo 'Sorry, Order items not available';
                            }

                            $totalamount = number_format($row['total_amount'], 2, '.', ',');
                            echo<<<EOD

                            <div class="order-item">
                                <ul>
                                    <li><span class='order-label'>Order ID: </span>{$row['order_id']}</li>
                                    <li><span class='order-label'>Amount:</span> Rs. {$totalamount}</li>
                                    <li class=''><span class='pending-label'>pending</span></li>
                                    <li class='right-align expand-order'>
                                        <span class="expand-icon">View +</span>
                                    </li>
                                    
                                    
                                </ul>
                                <div class="order-item-details">
                                    <div class='right-align expand-order'>
                                        <span class="close-icon">Close X</span>
                                    </div>
                                    <div class="order-columns">
                            EOD;
                                        if($products){
                                            echo<<<EOD
                                                <div class="column order-left-column">
                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <th class="left-align">Items</th>
                                                                <th class="center-align">Qn.tity</th>
                                                                <th class="right-align">Unit Price</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            {$products}
                                                        </tbody>
                                                    </table>
                                                </div>
                                            EOD;
                                        }

                                    echo<<<EOD
                                        <div class="column order-right-column">
                                            <ul class="customer-details">
                                                <li>Customer :</li>
                                                <li>{$row['customer_name']}</li>
                                                <li>Phone :</li>
                                                <li>{$row['customer_name']}</li>
                                                <li>Email :</li>
                                                <li>{$row['email']}</li>
                                                <li>Address :</li>
                                                <li>{$row['address']}</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <h4>Total Amount : Rs. {$totalamount} </h4>
                                    <div class="action-wrapper">
                                        
                                        <a class="action-btn" href="order-complete.php?order={$row['order_id']}">Completed</a>
                                        <a class="action-btn" href="order-delete.php?order={$row['order_id']}">Delete</a>
                                    </div>

                                </div>
                       
                            </div>

                            EOD;
                        }
                    }else{

                        if($completedcount){
                            echo<<<EOD
                                <div class="order-status-wrapper">
                                    <div class="order-info-box green">
                                        <h3>Completed Orders</h3>
                                        <span class="info-number">{$completedcount}</span>
                                    </div>
                                </div>
                            EOD;
                        }

                        echo "No Pending Orders";
                    }
                 ?>


            </div>
        </div>
    </div>
    <?php include('../footer.php'); ?>

  </body>
<html>
  <head>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    

  </head>
  <body>
    <?php 
    include('header.php');
    include('conn.php');
    $search ="";
    $items ='';
    $productcategory = [
        'phones' => '',
        'phone_accessories' => ''
    ];

    function formatCategoryTitle($text){
        return ucwords(str_replace('_',' ', $text));
    }

    if(isset($_POST['search-form']) || isset($_GET['search'])){
        $search = isset($_POST['search']) ? trim($_POST['search']) : trim($_GET['search']);
    }

    if($search){
        $sql = "SELECT * FROM products WHERE pname LIKE '%$search%' OR category LIKE '%$search%' OR brand LIKE '%$search%'";
        $result = mysqli_query($conn,$sql);
        
        
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $itemid = $row['pid'];
                $price = number_format($row['price'], 2,'.', ',');
                $items .=<<<EOD
                    <div class="shop-item item {$row['brand']}">
                        <a href="product-details.php?item=$itemid">
                            <div class="item-image">
                                <img src="{$row['imagepath']}" />
                            </div>
                        </a>
                        <div class="item-details">
                            <a href="product-details.php?item=$itemid"><h4>{$row['pname']}</h4>
                                <div class="availability">Available Now</div>
                                <div class="price">Rs.{$price}</div>
                            </a>
                        <form class="add_to_cart_form" name="add_to_cart_form"  action="" data-product-id="{$row['pid']}">
                        <input type="hidden" name="product_id" value="{$row['pid']}" />
                        <input type="hidden" name="product_name" value="{$row['pname']}" />
                        <input type="hidden" name="quantity" value="1" min="1" />
                        <input type="hidden" name="price" value="{$row['price']}" / >
                        <button type="submit" name="add_to_cart">Add To Cart</button>
                        </form>
                        </div>
                    </div>
                EOD;
    
            }
    
        }
    
        
    }else{
       
        $sql = "SELECT * FROM products";
        $allresult = mysqli_query($conn, $sql);

        if($allresult->num_rows > 0){
            while($row = $allresult->fetch_assoc()){
                
                        $eachitemid = $row['pid'];
                        $price = number_format($row['price'], 2,'.', ',');
                        $catitem =<<<EOD
                            <div class="shop-item item {$row['brand']}">
                                <a href="product-details.php?item=$eachitemid">
                                    <div class="item-image">
                                        <img src="{$row['imagepath']}" />
                                    </div>
                                </a>
                                <div class="item-details">
                                    <a href="product-details.php?item=$eachitemid"><h4>{$row['pname']}</h4>
                                        <div class="availability">Available Now</div>
                                        <div class="price">Rs.{$price}</div>
                                    </a>
                                <form class="add_to_cart_form" name="add_to_cart_form"  action="" data-product-id="{$eachitemid}">
                                <input type="hidden" name="product_id" value="{$eachitemid}" />
                                <input type="hidden" name="product_name" value="{$row['pname']}" />
                                <input type="hidden" name="quantity" value="1" min="1" />
                                <input type="hidden" name="price" value="{$row['price']}" / >
                                <button type="submit" name="add_to_cart">Add To Cart</button>
                                </form>
                                </div>
                            </div>

                    EOD;

                    if(array_key_exists($row['category'], $productcategory)){
                        $productcategory[$row['category']] .= $catitem;
                    }

            }

        }

    }
    //$sql = "SELECT * FROM products WHERE pname LIKE '%$search%' OR category LIKE '%$search%' OR brand LIKE '%$search%'";

    ?>

    <div class="page-wrapper shop">
        <h2 class="page-title">Shop</h2>
        <div class="columns-wrapper contact">
            <div class="items-wrapper">
            <div id="search" class="items-inner-wrapper">
                <div class="search-wrapper">
                <form method="POST" action="shop.php" >
                    <input id="site-search" type="text" name="search" value="<?= ($search)?$search:'';?>" />
                    <button type="submit" name="search-form">Search</button>
                </form>
                <a class="refresh-btn" href="shop.php">Refresh</a>
                </div>
            </div>
            </div>
            
           <?php if($items){echo $items;}  ?>

           <?php
        foreach($productcategory as $catkey=>$allitems){
            $title = formatCategoryTitle($catkey);
            if($allitems){
                echo<<<EOD
                    <h3 class="section-title">{$title}</h3>
                    <div class="items-wrapper">{$allitems}</div>
                EOD;
            }
        
        }

            ?>
            
        </div>
    </div>

<?php include('footer.php'); ?>
<script src="script.js"></script>
  </body>
<?php 
session_start();
include('conn.php'); 

$uri = $_SERVER['REQUEST_URI'];
$host = $_SERVER['HTTP_HOST'];
$pathSegments = explode('/', trim($uri));

$currentpage = basename($_SERVER['PHP_SELF']);

$urlpath = 'http://'.$host.'/'.$pathSegments[1];

?>


<div class="header-wrapper w-full h-50 bg-gradient-to-r from-blue-500 to-green-500">
        <div class="header">
          <div id="site-logo"><a href=<?=$urlpath."/index.php"?>></a></div>
          <h1 class="main-title">Premium Phones & Accessories</h1>

          <ul id="sub-nav-wrapper">
            <li class="sub-menu shopping-cart"><a href=<?=$urlpath."/cart/cart.php"?> >
     
                <span id='cart-count'><?php echo (isset($_SESSION['cart']))? count($_SESSION['cart']): 0; ?></span></a>

        </li>

            <?php if(isset($_SESSION['user'])){ ?>
                
                <li class="sub-menu"><a href=<?=$urlpath."/logout.php"?>>Log Out</a></li>
                <li class="sub-menu"><?= isset($_SESSION['user'])?$_SESSION['user']:''; ?></li>
          <?php  }else{ ?>
            <li class="<?=($currentpage == 'register.php')? 'sub-menu active': 'sub-menu'; ?>"><a href=<?=$urlpath."/register.php"?>>Register</a></li>
            <li class="<?=($currentpage == 'login.php')? 'sub-menu active': 'sub-menu'; ?>"><a href=<?=$urlpath."/login.php"?>>User Login</a></li>
           <?php  } ?>
            
          </ul>
          <ul id="main-menu">
            <li class="<?=($currentpage == 'shop.php')? 'menu-item active': 'menu-item'; ?>"><a href=<?=$urlpath."/shop.php"?>>Shop</a></li>

            <?php if(isset($_SESSION['user'])){
                if($_SESSION['user'] == "Admin"){ ?>

                    <li class="<?=($currentpage == 'product_types.php')? 'menu-item active': 'menu-item'; ?>">
                        <a href=<?=$urlpath."/dashboard_pages/product_types.php"?>>Add Product Types</a>
                    </li>
                    <li class="<?=($currentpage == 'orders.php')? 'menu-item active': 'menu-item'; ?>">
                        <a href=<?=$urlpath."/dashboard_pages/orders.php"?>>Orders</a>
                    </li>
                    <li class="<?=($currentpage == 'add_products.php')? 'menu-item active': 'menu-item'; ?>">
                        <a href=<?=$urlpath."/dashboard_pages/add_products.php"?>>Add Products</a>
                    </li>
                    <li class="<?=($currentpage == 'add_testimonials.php')? 'menu-item active': 'menu-item'; ?>">
                        <a href=<?=$urlpath."/dashboard_pages/add_testimonials.php"?>>Add Testimonials</a>
                    </li>

            <?php }?>
                    
                    <li class="<?=($currentpage == 'dashboard.php')? 'menu-item active': 'menu-item'; ?>">
                        <a href=<?=$urlpath."/dashboard.php"?>>User Dashboard</a>
                    </li>
            <?php } ?>

           <li class="<?=($currentpage == 'contact.php')? 'menu-item active': 'menu-item'; ?>"><a href=<?=$urlpath."/contact.php"?>>Contact Us</a></li>
            
          </ul>

        </div>
    </div>

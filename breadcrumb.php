<?php
$breadcrumbs = array();
$breadcrumbs[] = array('Home', 'index.php');

if(basename($_SERVER['PHP_SELF']) == 'product-details.php' ){
    $breadcrumbs[] = array('Products-Details', 'product-details.php');
}else if(basename($_SERVER['PHP_SELF']) == 'add_products.php'){
    $breadcrumbs[] = array('Add Products', 'add_products.php');
}

?>


<div class="breadcrumb-wrapper">
    <ul>
        <?php
            foreach($breadcrumbs as $index => $navitem){
                $lastitem = ($index == count($breadcrumbs) - 1);
                if($lastitem){
                    echo "> <li>".$navitem[0]."</li>";
                }else{
                    echo "<li><a href='".$navitem[1]."'>".$navitem[0]."</a></li>";
                }
            }
        ?>
    </ul>
</div>

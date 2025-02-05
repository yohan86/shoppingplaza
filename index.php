<!DOCTYPE html>
<html>
  <head>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link href="./dist/site.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script   src="script.js"></script>
  </head>
  <body class="bg-red-500">
        <?php
 
    include('header.php');
    include('conn.php');

    $featuredItems = $allphones = '';

    function formatCategoryTitle($text){
      return ucwords(str_replace('_',' ', $text));
    } 

    $featuredsql = "SELECT * FROM products WHERE featured='1'";
    $featuredresult = $conn->query($featuredsql);

    if ($featuredresult->num_rows > 0) {
        while ($row = $featuredresult->fetch_assoc()) {
          $itemid = $row["pid"];
          $featuredItems .=<<<EOD
            <div class="featured-item item">
            EOD;
            if($row['new'] === '1'){
              $featuredItems .=<<<EOD
               <span class="new-batch">New</span>
              EOD;       
            }

            $featuredItems .=<<<EOD

            <a href="product-details.php?item=$itemid">
              <div class="item-image">
                <img src="{$row['imagepath']}" />
              </div>
            </a>
            <div class="item-details">
            <a href="product-details.php?item=$itemid">
              <h4>{$row['pname']}</h4>
              <div class="availability">Available Now</div>
              <div class="price">Rs. {$row['price']}</div>
            </a>
            <form class="add_to_cart_form" method="POST" action=""  data-product-id="{$row['pid']}" >
              <input type="hidden" name="product_id" value="{$row['pid']}" />
              <input type="hidden" name="product_name" value="{$row['pname']}" />
              <input type="hidden" name="quantity" value="1" min="1" />
              <input type="hidden" name="price" value="{$row['price']}" / >
              <button type="submit">Add To Cart</button>
            </form>

            </div>
          </div>
          
          
          EOD;
        }
    }

$productCategory = [
  'phones' => '',
  'phone_accessories' => ''  
];
$catitems = '';


$sowitemsql = "SELECT * FROM products WHERE home='1'";
$showresult = $conn->query($sowitemsql);

if($showresult->num_rows > 0 ){
  while($row = $showresult->fetch_assoc()){
    $itemcategory = $row['category'];
    $catitem =<<<EOD
            <div class="featured-item item">
            EOD;
            if($row['new'] === '1'){
              $catitem .=<<<EOD
               <span class="new-batch">New</span>
              EOD;       
            }
            $catitem .=<<<EOD
             
              <a href="product-details.php?item={$row['pid']}">
                <div class="item-image">
                  <img src="{$row['imagepath']}" />
                </div>
              </a>
              <div class="item-details">
                <a href="product-details.php?item={$row['pid']}">
                  <h4>{$row['pname']}</h4>
                  <div class="availability">Available Now</div>
                  <div class="price">Rs. {$row['price']}</div>
                </a>
                <form class="add_to_cart_form" name="add_to_cart_form"  action="" data-product-id="{$row['pid']}">
                  <input type="hidden" name="product_id" value="{$row['pid']}" />
                  <input type="hidden" name='product_name' value="{$row['pname']}" />
                  <input type="hidden" name="quantity" value="1" min="1" />
                  <input type="hidden" name="price" value="{$row['price']}" / >
                  <button type="submit" name="add_to_cart">Add To Cart</button>
                </form>
              </div>
            </div>
          EOD;
          
          if(array_key_exists($itemcategory, $productCategory )){
            $productCategory[$itemcategory] .= $catitem;
          }

  }
}

?>


    <div class="slider-wrapper">
        <div class="slider slider-1 fade"></div>
        <div class="slider slider-2 fade"></div>
    </div>
    <div class="items-wrapper container">
      <div id="search" class="items-inner-wrapper">
        <div class="search-wrapper">
          <form method="GET" action="shop.php" >
            <input type="search" id="site-search" name="search" />
            <button type="submit">Search</button>
        </form>
        </div>
      </div>
    </div>
    

    <?php 
    if($featuredItems){
    echo<<<EOD
      <div class="items-wrapper has-border featured container">
        <div id="featured" class="items-inner-wrapper">
          <h3 class="section-title">Featured Products</h3>
          <div class="items-wrapper">
            {$featuredItems}
          </div>
        </div>
      </div>
    EOD;
    }

    foreach($productCategory as $key => $item){
    
      $cattitle = formatCategoryTitle($key);
      if($item){
        echo<<<EOD
          <div class="items-wrapper {$key} has-border">
            <div id="mobiles" class="items-inner-wrapper">
              <h3 class="section-title">{$cattitle}</h3>
              <div class="items-wrapper">
                {$item}
              </div>
            </div>
          </div>

        EOD;
      }
    }

?>


    <!--Tetimonial-->
<?php
    $reviews ='';
    $reviewsql = "SELECT * FROM testimonials";
    $reviewresult = $conn->query($reviewsql);
    if($reviewresult->num_rows > 0 ){
      while($row = $reviewresult->fetch_assoc()){

        $imagepath = ($row['profileimage']) ? $row['profileimage'] : "images/user.png";

        $reviews .=<<<EOD

          <li class="review-item">
              <div class="image-block">
                <img src="{$imagepath}"/>
              </div>
              <div class="review-cont">
                  <h3>{$row['title']}</h3>
                  <p>{$row['content']}</p>
                  <p class="review-user">{$row['author']}</p>
        EOD;
        if(isset($_SESSION['user']) && $_SESSION['user'] === "Admin") {
          $reviews .=<<<EOD
            <div  class="action-wrapper">
              <a href="dashboard_pages/update_testimonials.php?review={$row['id']}">Edit</a>
              <a href="dashboard_pages/delete_testimonials.php?review={$row['id']}">Delete</a>
            </div>
          EOD;
        } 
        $reviews .=<<<EOD
              </div>
          </li>
        EOD;

      }
    }

?>


    <?php if($reviews) { ?> 
    <div class="items-wrapper reviews">
      <div id="testimonials" class="items-inner-wrapper">
        <h3 class="section-title">Testimonials</h3>
        <ul id="reviews">
          <?=$reviews?>
        </ul>
      </div>
    </div>
    <?php } ?>

<?php include('footer.php'); ?>

<script>
  let slideIndex = 0;
  showSlides();

  function showSlides() {
    let i;
    let slides = document.getElementsByClassName("slider");
    for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";  
    }
    slideIndex++;
    if (slideIndex > slides.length) {slideIndex = 1}    

    slides[slideIndex-1].style.display = "block";  
    setTimeout(showSlides, 5000); // Change image every 5 seconds
  }
</script>


  </body>
</html>

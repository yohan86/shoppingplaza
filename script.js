$(document).ready(function(){
   
      $('.add_to_cart_form').submit(function(e){
          e.preventDefault();
        
          var productid = $(this).data("product-id");
          var productname = $(this).find("input[name='product_name']").val();
          var quantity = $(this).find("input[name='quantity']").val();
          var price = $(this).find("input[name='price']").val();
            console.log(productid);
          $.ajax({
              url: 'cart/add_to_cart.php',
              method: 'POST',
              data :{
                  add_to_cart: true,
                  product_id: productid,
                  productname: productname,
                  quantity: quantity,
                  price:price
              },
              success: function(response){
                  console.log(response.cart_count);
                  $("#cart-count").text(response.cart_count);

                
              },
              error: function(xhr, status, error) {
                  console.error('AJAX error:', error); // Log errors
              }

          });
      });

      $('.expand-order').click(function(){
        $(this).parents('.order-item').toggleClass('active');
      });

      function pagerefresh(){
        location.reload();
      };


  });
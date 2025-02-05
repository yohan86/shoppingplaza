<?php
echo "
<form method='POST' action=''>
    <input type='hidden' name='product_id' value='".$row['pid']."' />
    <input type='hidden' name='quantity' value='1' min='1' />
    <input type='hidden' name='price' value='".$row['price']."' / >
    <button type='submit' name='add_to_cart'>Add To Cart</button>
</form>
";
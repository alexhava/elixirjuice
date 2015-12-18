   <div class="shopping_cart"><!-- start shopping cart here -->
      <h1>Shopping Cart</h1>
      <table>
        <tr class="border_none">
          <th class="item_title">Item</th>
          <th class="item_description">Description</th>
          <th class="item_quantiy">Quantity</th>
          <th class="item_price">Price</th>
          <th></th>
        </tr>
        
<?php
			if($_SERVER['REMOTE_ADDR'] == '194.126.183.154')
			{
				myd($_COOKIE);
			}
			foreach ($this->cart->contents() as $key => $items)
			{
				$img = 'images/upload/'.($items['option']['image'] ? $items['option']['image'] : '../noimage.jpg');
				$new_image = "/timthumb/timthumb.php?src=$img&w=27&h=80"; 
				echo '<tr><td><img class="shop_img"  src="'.$new_image.'" /><span class="cart_title">'. ($items['option']['opt'] ? $items['option']['product_options']->description[$items['option']['opt']] : '').' '.$items['option']['product_title'] . '</span></td>';						
				echo '<td><span class="cart_desc">'.@$items['option']['product_description'].'</span></td>';						
				echo '<td><span class="cart_quantity">'.form_input("qty[{$items['rowid']}]", $items['qty']).'</span></td>';						
				echo '<td><span class="cart_price">'.$this->cart->format_number($items['price']).'</span></td>';						
				echo "<td><a href='' class='delete-cart-item' id='{$items['rowid']}'>Remove</a></td></tr>";						
			}
?>       
         <tr class="border_none">
          <td>&nbsp;</td>
           <td>&nbsp;</td>
            <td><span class="cart_total">Total</span></td>
             <td><span class="cart_total_price">$<span class="cart_total_price_number"><?php echo $this->cart->format_number($this->cart->total()); ?></span></span></td>
             <td></td>
        </tr>
      </table>
      <div class="cart_button"><!-- start cart button here -->
      <a href="#" class="update_cart update-cart">Update Cart</a>
      <a href="/cart/checkout" class="checkout">checkout</a>
      <div class="clear"></div>
      </div><!-- end cart button here -->
      <div class="clear"></div>
    </div>
    <!-- end shopping cart here -->
    <div class="clear"></div>

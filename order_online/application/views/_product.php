<?php
						$img = 'images/upload/'.($product['image'] ? $product['image'] : '../noimage.jpg');
						$new_image = "/timthumb/timthumb.php?src=$img&w=62&h=185"; 
?>									
  <li><input type="hidden" name="product_id" value="<?=$product['product_id']?>">
        <div class="featured_product_image">
        	<a href="/<?=$root?>/<?=($active?$active:'d')?>/product/<?=$product['product_id']?>/<?=url_title($product['product_title'])?>" class="product-list-image sproduct_title title-content"><img class="" src="<?=$new_image?>" /></a>
        	<span class="price">$<?=$product['regular_price']?></span>
        </div>
        <a href="/<?=$root?>/<?=($active?$active:'d')?>/product/<?=$product['product_id']?>/<?=url_title($product['product_title'])?>" class="product_title title-content"><?=$product['product_title']?></a> <span class="description"><?=$product['product_description']?></span><span class="action_button"> <a href="/<?=$root?>/<?=($active?$active:'d')?>/product/<?=$product['product_id']?>/<?=url_title($product['product_title'])?>" class="view_detail">View Detail</a> <a href="#" class="add_tocart item_add">Add to Cart</a></span>
        
 </li>
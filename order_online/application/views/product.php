    <div id="content"><!--start content here -->
    <?php if(@$product): ?>
	<?php
		$img = 'images/upload/'.($product['image'] ? $product['image'] : '../noimage.jpg');
		$new_image = "/timthumb/timthumb.php?src=$img&w=209";										
	?>    
	<input type="hidden" name="product_id" value="<?=$product['product_id']?>">
    <input type="hidden" class="item_product_id" name='item_id_<?=$product['product_id']?>' value="<?=$product['product_title']?>">
      <div class="single_product"><!-- start single product here --> 
        <img src="<?=$new_image?>" />
        <div class="single_description"><!-- start single description here -->
        <h1 class="title-content"><?=$product['product_title']?></h1>
       
		<?php if ($product['wholesale_price'] and $this->user_session_data['wholesale_enabled'] == 'y')  : ?>
			<span class="price">$<span class="item_price" ><?=$product['regular_price']?></span><</span>
			<span class="price">Wholesale $<span class="item_price" ><?=$product['regular_price']?></span><</span>
		<?php else :  ?> 
			<span class="price">$<span class="item_price" ><?=$product['regular_price']?></span></span>
		<?php endif;  ?> 
		       
        <p class="descritpion"><?=$product['product_ingredients']?></p>
        <p class="ingredients">INGREDIENTS<Br />
        <span><?=$product['product_ingredients']?></span></p>

        <a href="#" class="add_tocart item_add">Add to Cart</a>
        <input type="text" name="product_qty" value="1" class="product-qty"/>
          <div class="clear"></div>
        </div>
        <!-- end single description here -->
        <div class="clear"></div>
      </div>
      <?php endif; ?>
      <!-- end single product here -->
      <div class="clear"></div>
    </div>
    <!-- end content here -->
    <div id="sidebar"><!-- start sidebar here -->
      <ul>
 			<?php foreach ($sub_categories as $menu_item):?>
				<li><a href="/<?=$root?>/<?=$menu_item['cat_url_title']?>" class="<?=$menu_item['cat_url_title']==$active?'_current':''?>"><?=$menu_item['cat_name']?></a></li>
			<?php endforeach; ?>     
       </ul>
      <div class="clear"></div>
    </div>
    <!-- end ocntent here -->
    <div class="clear"></div>    
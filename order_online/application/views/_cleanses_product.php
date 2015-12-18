<?php
						$img = 'images/upload/'.($product['image'] ? $product['image'] : '../noimage.jpg');
						$new_image = "/timthumb/timthumb.php?src=$img&h=112"; 
?>								
        <li>
        <h1 class="title-content"><?=$product['product_title']?></h1>
        <ul class="number_ofdate day-options">
			<?php foreach ($product['product_options']->price as $k => $o) : ?>
			<li data-selected-id="<?=$k?>" data-price="<?=$o?>" data-num-days="<?=$product['product_options']->qty[$k]?>" class="<?=@$product['product_options']->default == $k ? 'selected' : ''?>">
				<?php if(@$product['product_options']->default == $k) $current_price =  $o ?>
				<a href="#"><?=$product['product_options']->description[$k]?></a>
			</li>
			<?php endforeach; ?>
        </ul>
        <span class="price">$<span class="price_number_holder"><?=$current_price?></span></span>
        <input type="hidden" name="product_id" value="<?=$product['product_id']?>">
        <input name="product_option" type="hidden" value="<?=@$product['product_options']->default?>"/>
        <a href="#" class="add_tocart item_add">Add to Cart</a>
        
		<?php if($product['related_products']) : ?>
			<div class="options-container">
				<div class="options-container-inner">
				<?php 	foreach ($product['related_products'] as $k => $o) : ?>
					<input type="checkbox" name="include[]" value="<?=$o?>" id="c<?=$o.$product['product_id']?>" data-option-price='<?=ci()->products_model->get_regular_price($o)?>' class="option-check"><label for="c<?=$o.$product['product_id']?>"></label> Include <?=ci()->products_model->get_product_title($o)?><br>
														
				<?php endforeach; ?>
				</div>	
			</div>	
		<?php endif; ?>	
		<div class="img"><img class="item_image" src="<?=$new_image?>" align="middle" /> </div>      
        <div class="product_desc"><!-- start product desc here -->
			<?=$product['product_description']?>
        
        <div class="clear"></div>
        </div>
        
        </li>									
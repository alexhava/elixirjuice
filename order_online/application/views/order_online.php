    <div id="content"><!--start content here -->				
    <?php

				if($products) : $c=0;?>
				<ul class="products<?php if($products[0]['related_products']) : ?>02<?php endif; ?>">
					<?php foreach ($products as $key => $product):
						if ($product['wholesale_only'] == 'y' and @$this->user_session_data['wholesale_enable'] != 'y') 
						{
							continue;
						}
					?>
						<?php if($product['related_products']) : ?>	
						<?php $this->load->view('_cleanses_product', array('product' => $product));?>
						<?php else : ?>	
						
						<?php $this->load->view('_product', array('product' => $product));?>
						<?php endif; ?>	
					<?php endforeach; ?>				
				</ul>					
				<?php endif; ?>									
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

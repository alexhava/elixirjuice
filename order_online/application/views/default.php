<div class="abt_main">
	<div class="abt_brdr">
		<?php if($sub_categories) : ?>
		<div class="lft_mnu_cntnr_cln">
			<?php foreach ($sub_categories as $menu_item):?>
			<?php 
				if(strlen($menu_item['cat_name']) > 20)
				{
					$menu_item['cat_name'] = substr($menu_item['cat_name'],0, strrpos($menu_item['cat_name'], ' ')) . '<br/>' . substr($menu_item['cat_name'], strrpos($menu_item['cat_name'], ' ')+1);
					$menu_class = 'lft_mnu_big';
				}
				else 
				{
					$menu_class = 'lft_mnu';
				}
			?>
				<a href="/<?=$root?>/<?=$menu_item['cat_url_title']?>" class="<?=$menu_item['cat_url_title']==$active?$menu_class.'_current':$menu_class?>"><?=$menu_item['cat_name']?></a>
			<?php endforeach; ?>		
		</div>
		<?php endif;?>
		<div class="rgt_mnu_cntnr_cln">
			<div class="clens_mdl">
				<?=$cat_content?>
			</div>
			<div class="clens_rgt">
				<div class="clns_tag_cntnr">
					<div class="tags" style="padding-bottom:10px;">
						<img src="/images/elixir_tag.jpg" width="230" height="211"/>
					</div>
					<div class="tags" style="padding-bottom:10px;">
						<img src="/images/elixir_location.png" width="230" height="189"/>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
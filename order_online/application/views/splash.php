<div class="abt_main" style="padding: 5px 45px 0">
	<?php if( ! @$hide_sub) : ?>
	<div class="tp_lnk_cntnr" style="background:none;padding:0px 0px 25px 0px;">
	<a href="" class="menu_sub_current">MENU</a>
	<a href="juices.php" class="menu_sub">NUTRITION INFORMATION</a>
	</div>
	<?php endif; ?>
	
	<div class="abt_brdr">
		<div class="lft_mnu_cntnr_cln" style="width:20%">
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
		<div style="float:right;width:80%">
		<div class="rgt_mnu_cntnr">
							<div class="ju_cntnr">
								<?php if(@$products_splash[0]) : ?>
								<?php 						 
								$config['source_image'] = DOCUMENT_ROOT . 'images/upload/'.($products_splash[0]['image'] ? $products_splash[0]['image'] : '../noimage.jpg');
								$config['height'] = 323;
								$new_image = my_img_resize($config);
						 		?>
								<div class="ju_main">
									<div class="ju_tp">
										<img src="images/juice_bg_tp.png"/>
									</div>
									
									<div class="ju_cntr">
										<div class="juice_hd">
											<a class="menu_sub" href="/<?=$root?>/<?=$active_splash?>/product/<?=$products_splash[0]['product_id']?>/<?=$products_splash[0]['product_title']?>"><span style="font:bold 13px calibri; color:#8d0e3a;"><?=$products_splash[0]['product_title']?></span></a>	
										</div>
										<div class="juice_pic2" style="height:323px;">
										<a href="/<?=$root?>/<?=$active_splash?>/product/<?=$products_splash[0]['product_id']?>/<?=$products_splash[0]['product_title']?>"><img src="<?=$new_image?>" style="height:323px;" /></a>
										</div>
										<div class="juice_txt">
											<?=$products_splash[0]['product_description']?>
										</div>
									</div>
									
									<div class="ju_btm">
										<img src="images/juice_bg_btm.png"/>
									</div>
									<div class="clr">
									</div>
								</div>
								<?php endif; ?>
								<div class="juc_sub_main" >
									<?php if(@$products_splash[1]) : ?>
									<?php 						 
									$config['source_image'] = DOCUMENT_ROOT . 'images/upload/'.($products_splash[1]['image'] ? $products_splash[1]['image'] : '../noimage.jpg');
									$config['height'] = 130;
									$new_image = my_img_resize($config);
							 		?>									
									<div class="juc_sub" >
										<div class="juc_sub_tp">
											<img src="images/juice_sub_tp.png"/>
										</div>
										<div class="juc_sub_cntr">
											<div class="juc_sub_pic"  style="height:130px;">
											<a href="/<?=$root?>/<?=$active_splash?>/product/<?=$products_splash[1]['product_id']?>/<?=$products_splash[1]['product_title']?>"><img src="<?=$new_image?>"/></a>
											</div>
											<div class="juc_sub_txt">
												<span style="font:bold 13px calibri; color:#8d0e3a;white-space:nowrap;overflow:visible;"><a class="menu_sub" href="/<?=$root?>/<?=$active_splash?>/product/<?=$products_splash[1]['product_id']?>/<?=$products_splash[1]['product_title']?>"><span style="font:bold 13px calibri; color:#8d0e3a;"><?=$products_splash[1]['product_title']?></span></a>	</span><br/><?=$products_splash[1]['product_description']?>
											</div>
										</div>
										<div class="juc_sub_btm">
											<img src="images/juice_sub_btm.png"/>
										</div>
										<div class="clr">
										</div>
									</div>
									<?php endif; ?>
									<?php if(@$products_splash[2]) : ?>
									<?php 						 
									$config['source_image'] = DOCUMENT_ROOT . 'images/upload/'.($products_splash[2]['image'] ? $products_splash[2]['image'] : '../noimage.jpg');
									$config['height'] = 130;
									$new_image = my_img_resize($config);
							 		?>
									<div class="juc_sub_lst">
										<div class="juc_sub_tp">
											<img src="images/juice_sub_tp.png"/>
										</div>
										<div class="juc_sub_cntr">
											<div class="juc_sub_pic" style="height:130px;">
											<a href="/<?=$root?>/<?=$active_splash?>/product/<?=$products_splash[2]['product_id']?>/<?=$products_splash[2]['product_title']?>"><img src="<?=$new_image?>"/></a>
											</div>
											<div class="juc_sub_txt">
												<span style="font:bold 13px calibri; color:#8d0e3a;white-space:nowrap;overflow:visible;"><a class="menu_sub" href="/<?=$root?>/<?=$active_splash?>/product/<?=$products_splash[2]['product_id']?>/<?=$products_splash[2]['product_title']?>"><span style="font:bold 13px calibri; color:#8d0e3a;"><?=$products_splash[2]['product_title']?></span></a>	</span><br/><?=$products_splash[2]['product_description']?>
											</div>
										</div>
										<div class="juc_sub_btm">
											<img src="images/juice_sub_btm.png"/>
										</div>
										<div class="clr">
										</div>
									</div>
									<?php endif; ?>
									<div class="clr">
									</div>
								</div>
							</div>
							<div class="ju_rgt">
							<?php if(@$products_splash[3]) : ?>
							<?php 						 
									$config['source_image'] = DOCUMENT_ROOT . 'images/upload/'.($products_splash[3]['image'] ? $products_splash[3]['image'] : '../noimage.jpg');
									$config['height'] = 130;
									$new_image = my_img_resize($config);
							 		?>
								<div class="juc_sub_new">
										<div class="juc_sub_tp">
											<img src="images/juice_sub_tp.png"/>
										</div>
										<div class="juc_sub_cntr">
											<div class="juc_sub_pic">
											<a href="/<?=$root?>/<?=$active_splash?>/product/<?=$products_splash[3]['product_id']?>/<?=$products_splash[3]['product_title']?>"><img src="<?=$new_image?>"/></a>
											</div>
											<div class="juc_sub_txt">
												<span style="font:bold 13px calibri; color:#8d0e3a;"><a class="menu_sub" href="/<?=$root?>/<?=$active_splash?>/product/<?=$products_splash[3]['product_id']?>/<?=$products_splash[3]['product_title']?>"><span style="font:bold 13px calibri; color:#8d0e3a;"><?=$products_splash[3]['product_title']?></span></a>	</span><br/><?=$products_splash[3]['product_description']?>
											</div>
										</div>
										<div class="juc_sub_btm">
											<img src="images/juice_sub_btm.png"/>
										</div>
										<div class="clr">
										</div>
								</div>
							<?php endif; ?>	
							<?php if(@$products_splash[4]) : ?>
							<?php 						 
									$config['source_image'] = DOCUMENT_ROOT . 'images/upload/'.($products_splash[4]['image'] ? $products_splash[4]['image'] : '../noimage.jpg');
									$config['height'] = 130;
									$new_image = my_img_resize($config);
							 		?>
								<div class="juc_sub_new">
										<div class="juc_sub_tp">
											<img src="images/juice_sub_tp.png"/>
										</div>
										<div class="juc_sub_cntr">
											<div class="juc_sub_pic">
											<a href="/<?=$root?>/<?=$active_splash?>/product/<?=$products_splash[4]['product_id']?>/<?=$products_splash[4]['product_title']?>"><img src="<?=$new_image?>"/></a>
											</div>
											<div class="juc_sub_txt">
												<span style="font:bold 13px calibri; color:#8d0e3a;"><a class="menu_sub" href="/<?=$root?>/<?=$active_splash?>/product/<?=$products_splash[4]['product_id']?>/<?=$products_splash[4]['product_title']?>"><span style="font:bold 13px calibri; color:#8d0e3a;"><?=$products_splash[4]['product_title']?></span></a>	</span><br/><?=$products_splash[4]['product_description']?>
											</div>
										</div>
										<div class="juc_sub_btm">
											<img src="images/juice_sub_btm.png"/>
										</div>
										<div class="clr">
										</div>
								</div>
							<?php endif; ?>
							<?php if(@$products_splash[4]) : ?>
								<div class="juc_sub_new">
										<div class="juc_sub_tp">
											<img src="images/juice_sub_tp.png"/>
										</div>
										<div class="juc_sub_cntr">
											<div class="juc_sub_pic">
											<a href="/<?=$root?>/<?=$active_splash?>/product/<?=$products_splash[4]['product_id']?>/<?=$products_splash[4]['product_title']?>"><img src="<?=$new_image?>"/></a>
											</div>
											<div class="juc_sub_txt">
												<span style="font:bold 13px calibri; color:#8d0e3a;"><a class="menu_sub" href="/<?=$root?>/<?=$active_splash?>/product/<?=$products_splash[4]['product_id']?>/<?=$products_splash[4]['product_title']?>"><span style="font:bold 13px calibri; color:#8d0e3a;"><?=$products_splash[4]['product_title']?></span></a>	</span><br/><?=$products_splash[4]['product_description']?>
											</div>
										</div>
										<div class="juc_sub_btm">
											<img src="images/juice_sub_btm.png"/>
										</div>
										<div class="clr">
										</div>
								</div>
							<?php endif; ?>
							</div>
						</div>								
		</div>
	</div>
</div>
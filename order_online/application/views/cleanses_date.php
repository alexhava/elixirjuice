<?php  if(@$cleanses_date) : ?>
	<div class="cleanses_date">
	<h3>Your Cleanse Schedule</h3>
		<?php foreach ($cleanses_date as $product_name => $item) : ksort($item)?>
		<b><?=$product_name?></b><br>
			<?php foreach ($item as $stamp => $cnt) : ?>
				<div style="float:left;">
					<?=date('m/d/Y', $stamp)?> x <?=$cnt['cnt']?>
				</div>
				<div style="padding:1px; float:left;"><img style="cursor:pointer;" onclick="changeQty('<?=$product_name?>', '<?=$stamp?>', <?=$cnt['cnt']+1?>,1)" alt="arrow up" title="+1" src="/images/increment2.png"> <img style="cursor:pointer;" onclick="changeQty('<?=$product_name?>', '<?=$stamp?>', <?=$cnt['cnt']-1?>,-1)" alt="arrow down" title="-1" src="/images/decrement2.png"></div>
				<div style="clear:both"></div>
			<?php endforeach; ?>
		<?php endforeach; ?>
	</div>
<?php endif; ?>
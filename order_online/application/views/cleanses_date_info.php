<?php  if(@$cleanses_date) : ?>
	<div class="cleanses_date">
		<?php foreach ($cleanses_date as $product_name => $item) : ksort($item)?>
		<b><?=$product_name?></b><br>
			<?php foreach ($item as $stamp => $cnt) : ?>
				<div style="float:left;">
					<?=date('m/d/Y', $stamp)?> x <?=$cnt['cnt']?>
				</div>
				<div style="clear:both"></div>
			<?php endforeach; ?>
		<?php endforeach; ?>
	</div>
<?php endif; ?>
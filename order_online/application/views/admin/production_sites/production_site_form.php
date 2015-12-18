<?= form_open($this->controller_base.$action, '', array('production_site_id'=> @$production_site_id)); ?>

<?php
	$this->table->clear();
	$this->table->set_template($table_template);
		$this->table->set_heading(
			array('data' => lang('preference'), 'width' => "40%"),
			array('data' => lang('value')));

		
	    $this->table->add_row(lang('name'), form_input('name', @$name));
	    $this->table->add_row(lang('address'), form_input('address', @$address));
	    $this->table->add_row(lang('production_group'), form_dropdown('production_group_id', @$production_groups, @$production_group_id));
	    $products_html = "<table width='100%'>";
	    foreach ($products as $k => $v) 
	    {
	    	$products_html .= "<th colspan=2><b>$k</b></th>";
	    	foreach ($v['products'] as $k1 => $v1) 
	    	{
	    		$products_html .= "<tr><td>$v1</td><td>".form_checkbox('products[]', $k1, @in_array($k1, @$produced_products))."</td></tr>";
	    	}
	    }
	     $products_html .= "</table>";
	      $this->table->add_row(lang('products'), $products_html);
	echo $this->table->generate();
?>

<div style="text-align: right;margin-top:5px;">
	<?= form_submit(array('name' => 'submit', 'value' => lang('save'), 'class' => 'button')); ?>
</div>
<?= form_close(); ?>
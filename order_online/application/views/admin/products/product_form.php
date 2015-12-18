<?= form_open_multipart($this->controller_base.$action, '', array('wholesale_only'=> 'n', 'product_id'=> @$product_id, 'order_online'=>'n', 'shipping_only'=>'n')); ?>

<?php
	$this->table->clear();
	$this->table->set_template($table_template);
	$this->table->set_heading(
		array('data' => lang('preference'), 'width' => "40%"),
		array('data' => lang('value')));


	    $this->table->add_row(lang('product_title'), form_input('product_title', @$product_title));
	    $this->table->add_row(lang('product_price'), form_input('regular_price',@$regular_price));
	    $this->table->add_row(lang('wholesale_price'), form_input('wholesale_price',@$wholesale_price));
	    $this->table->add_row(lang('lead_time'), form_input('lead_time', @$lead_time));
	   	$this->table->add_row(lang('product_description'), form_textarea('product_description', @$product_description, 'id="product_description"'));
	   	$this->table->add_row(lang('product_ingredients'), form_textarea('product_ingredients', @$product_ingredients, 'id="product_ingredients"'));
	    $this->table->add_row(lang('category'), form_dropdown('cat_id', @$categories, @$cat_id));
	    $this->table->add_row(lang('related_products'), form_multiselect('related_products[]', @$products, (array)@$related_products));
	    $image_tag = @$image ? (br()."<img src='/images/upload/{$image}' style='width:50px'/><br><a href='".base_url('admin/products/delete_image')."?product_id=$product_id' class='delete-image'>Remove image</a>" ): '';
	    $this->table->add_row(lang('image'), form_upload('image').$image_tag);
	    $this->table->add_row(lang('order_online'), form_checkbox('order_online', 'y', @$order_online=='y'));
	    $this->table->add_row(lang('wholesale_only'), form_checkbox('wholesale_only', 'y', @$wholesale_only=='y'));
	    $this->table->add_row(lang('show_calendar'), form_checkbox('show_calendar', 'y', @$show_calendar=='y'));
	    
	    $table = form_submit(array('name' => 'add_option', 'value' => lang('add_option'), 'class' => 'button', 'style' => 'width: 100px'))."<br><table class='price-options' width='100%'>";
	    $table .= "<thead><tr><th width='20%'>Price</th><th width='20%'>Weight</th><th width='20%'>Qty</th><th>Description</th><th>Default</th><th></th></tr></thead><tbody>";
	    $table .= "<tr class='options-template' style='display:none;'><td>".form_input('product_options[price][]', '', 'disabled')."</td><td>".form_input('product_options[qty][]', '', 'disabled')."</td><td>".form_input('product_options[description][]', '', 'disabled')."</td><td></td><td></td></tr>";
	    if( ! @$product_options)
	    {
	    	$table .= "<tr class='no-options'><td colspan=4>There are no options</th></tr>";
	    	$table .= '</tbody></table>';
	    	$this->table->add_row(lang('price_options'), $table);
	    }
	    else 
	    {
	    	foreach ($product_options->price as $k => $o)
	    	{
	    		if($o)
	    		 $table .= "<tr class='price-option'><td>".form_input('product_options[price][]', $o)."</td><td>".form_input('product_options[weight][]', @$product_options->weight[$k])."</td><td>".form_input('product_options[qty][]', $product_options->qty[$k])."</td><td>".form_input('product_options[description][]', $product_options->description[$k])."</td><td>".form_radio("product_options[default]", $k, (@$product_options->default == $k))."</td><td><a href='#' class='remove-price-option'>Remove</a></td></tr>";
	    	}
	    	$table .= '</table>';
	    	$this->table->add_row(lang('price_options'), $table);
	    }
	    
	    //shipping settings
	    $this->table->add_row(array('data' => '<h3>Shipping settings</h3>', 'colspan' => 2));
	    $radio_shipping_types = array();
	    foreach ($shipping_types as $st_key => $st):
	   		$radio_shipping_types[] = $st.nbs().form_radio('shipping_type', $st_key, @$shipping_type==$st_key, 'style="width:auto"');
	    endforeach; 
	    $this->table->add_row(lang('shipping_type'), implode(nbs(), $radio_shipping_types));
	    $this->table->add_row(lang('shipping_weight'), form_input('shipping_weight', @$shipping_weight));	    
	    $this->table->add_row(lang('shipping_schedule'), form_dropdown('shipping_schedule_id', @$shipping_schedules, @$shipping_schedule_id));	    
	echo $this->table->generate();
?>

<div style="text-align: right;margin-top:5px;">
	<?= form_submit(array('name' => 'submit', 'value' => lang('save'), 'class' => 'button')); ?>
</div>
<?= form_close(); ?>

<script language="Javascript" type="text/javascript">
$("#product_description").htmlbox({
    toolbars:[
	     ["cut","copy","paste","separator_dots","bold","italic","underline","strike","sub","sup","separator_dots","undo","redo","separator_dots",
		 "left","center","right","justify","ol","ul","indent","outdent","link","unlink","image","code","removeformat","striptags","quote","paragraph","hr"],
		 ["formats","fontsize","fontfamily",
		"separator","fontcolor","highlight",
		  ]
	],
	icons:"silk",
	skin:"default",
	idir:"/images/htmlbox/"
});
$("#product_ingredients").htmlbox({
    toolbars:[
	     ["cut","copy","paste","separator_dots","bold","italic","underline","strike","sub","sup","separator_dots","undo","redo","separator_dots",
		 "left","center","right","justify","ol","ul","indent","outdent","link","unlink","image","code","removeformat","striptags","quote","paragraph","hr"],
		 ["formats","fontsize","fontfamily",
		"separator","fontcolor","highlight",
		  ]
	],
	icons:"silk",
	skin:"default",
	idir:"/images/htmlbox/"
});
</script>
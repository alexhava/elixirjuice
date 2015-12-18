<?php  
if(@$cat_description)
{
	$cat_description2 = str_replace("\r", "", addslashes($cat_description)); 
	$cat_nl_count = count(explode("\n", $cat_description2))*11; 
	$cat_nl_count = $cat_nl_count > 12 ? $cat_nl_count . 'px' : '60px'; 
	
}
?>
<?= form_open($this->controller_base.$action, '', array('cat_id'=> @$cat_id, 'visible'=> 'n')); ?>

<?php
	$this->table->clear();
	$this->table->set_template($table_template);
	$this->table->set_heading(
		array('data' => lang('preference'), 'width' => "40%"),
		array('data' => lang('value')));

	    $this->table->add_row(lang('category_name'), form_input('cat_name', @$cat_name));
	    $this->table->add_row(lang('category_url_title'), form_input('cat_url_title', @$cat_url_title));
	    if(@$categories)$this->table->add_row(lang('category_parent'), form_dropdown('parent_id', @$categories, @$parent_id));
	    $this->table->add_row(lang('visible'), form_checkbox('visible', 'y', @$visible=='y'));
	    $this->table->add_row(array('data'=>lang('category_description').br().form_textarea('cat_description', @$cat_description, 'id="cat_description"'), 'colspan'=>2));

	echo $this->table->generate();
?>

<div style="text-align: right;margin-top:5px;">
	<?= form_submit(array('name' => 'submit', 'value' => lang('save'), 'class' => 'button')); ?>
</div>
<?= form_close(); ?>

<script language="Javascript" type="text/javascript">
<?php $css = @$cat_description ? '.css("height", "'.$cat_nl_count.'")' : '' ?>
var hb_silk_icon_set_default = $("#cat_description")<?=$css?>.htmlbox({
    toolbars:[
	     ["cut","copy","paste","separator_dots","bold","italic","underline","strike","sub","sup","separator_dots","undo","redo","separator_dots",
		 "left","center","right","justify","ol","ul","indent","outdent","link","unlink","image","code","removeformat","striptags","quote","paragraph","hr"],
		 ["formats","fontsize","fontfamily",
		"separator","fontcolor","highlight",
		  ]
	],
	icons:"silk",
	skin:"default",
	idir:"/images/htmlbox/",
	css:"<?php echo str_replace("\n",'', addslashes(file_get_contents(DOCUMENT_ROOT . 'css/main.css'))) ?>"
});

</script>
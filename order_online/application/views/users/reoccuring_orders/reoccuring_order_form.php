<script type="text/javascript">
var deliveryTypes = new Array();
var productCount = 0;
</script>
<?php echo $this->load->view('users/home','',TRUE) ?>
<div style="padding:10px;">
<h3 align="center">Reoccurring Orders</h3>
	<?= form_open($this->controller_base.$action, '', array('reoccuring_order_id'=> @$reoccuring_order_id)); ?>
<?php	
	$this->table->clear();
	$table_template2 = array(
			'table_template' => array(
				'table_open'		=> '<table  border="0" cellspacing="0" cellpadding="0">',
			),
		);
	$this->table->set_template($table_template2);

?>
			<?php if(@count(@$error)):?>				
			<?php foreach ($error as $err_mes):?>
			<div><font color="Red"><?=@$err_mes?></font></div>	<br>			
			<?php endforeach; ?>			
			<?php endif;?>									 
  <table width="100%"  border="0" cellspacing="2" cellpadding="0" id="client_info">
     <tr valign="top">
      <td width="15%">&nbsp;</td>
      <td width="40%">&nbsp;</td>
      <td >&nbsp;</td>
    </tr>
     
	 <tr>
	  <td colspan="2"><h3>Order Products</h3></td>
	  <td>Delivery Options</td>
	  </tr>
     <tr valign="top">
      <td>Products</td>
      <td >
      <?php if( ! isset($products)) : ?>
      <div class="products_dropbox">
      	<?php echo form_dropdown('products[]', $online_products, '', 'class="lst_fld"')  ?> 
      	Qty <?php echo form_input('qty[]', 1, 'style="width:30px"')  ?> 
      	<a href="#" class="new_product">[+]</a>
      	<div class="delivery_box"></div>
      </div>
       <?php else : ?>
       <?php $flipped_products = array_flip($products);
       	foreach ($products as $product_id) : ?>
	       <script type="text/javascript">
	       		deliveryTypes[<?=$product_id?>] = '<?=$delivery_type[$product_id]?>'
	       		productCount++;
	       </script>       	
	       <div class="products_dropbox">
	      	<?php echo form_dropdown('products[]', $online_products, $product_id, 'class="lst_fld"')  ?> 
	      	Qty <?php echo form_input('qty[]', $qty[$flipped_products[$product_id]], 'style="width:30px"')  ?> 
	      	<a href="#" class="new_product">[+]</a>
	      	<div class="delivery_box"></div>
	      </div>      
       <?php endforeach; ?>
       <?php endif; ?>
      
      </td>
      <td >
		<div style="position:relative;">
				<div style="font-weight:bold;" id="store_region_wrapper"> 
	   
      <label>State*</label><br><?=form_dropdown('store_region', $this->taxes_model->get_stores_states(), (@$store_region? $store_region : @$region), 'id="store_region" class="lst_fld"')?><br>Stores available for pickup<br> <span id="stores"></span><br>
      <div id="time_section"></div>
		<?php 
		
		
		?>
      </div>
				<div style="clear:both;"></div>
				<div style="font-weight:bold;"><span class="amount-text">Tax: </span> $<span id="shippingAmount">0</span></div>
				<div style="clear:both;"></div>
				<div style="font-weight:bold;"><span class="amount-text">Delivery:</span> $<span id="delivery_amount">0</span></div>				
				<div style="clear:both;"></div>
				<div style="font-weight:bold;"><h2><span class="amount-text">Total:</span> $<span id="grandTotal">0</span></h2></div>
		</div>      
      </td>
    </tr>
    
    <tr>
	  <td colspan="3"><h3>Order Frequency</h3></td>
	  </tr>
     <tr>
      <td><label>Period</label><br></td>
      <td><?php 
      	echo form_dropdown('period', array('d'=>'Daily', 'w'=>'Weekly'), @$period, 'class="lst_fld"');
      ?>
      </td>
    </tr>
     <tr>
      <td><label>Day of Week to Ship</label><br></td>
      <td><?php 
      	echo form_dropdown('week_day', array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'), @$week_day, 'class="lst_fld"');
      ?>
      </td>
    </tr>
    
    <tr>
	  <td colspan="3"><h3>Payment Details</h3></td>
	  </tr>
     <tr>
      <td><label>Credit Card Number * </label><br></td>
      <td><?php 
      	echo form_dropdown('card_id', $cards, @$card_id ? $card_id : $primary, 'class="lst_fld"');
      ?>
      </td>
      <td >&nbsp;</td>
    </tr>	 

   <tr> <td colspan="3"><h3>Customer Information</h3></td></tr>
    <tr>
      <td> 

      </td>
      <td colspan="2">      <?php 
			echo form_dropdown('address_id', $addresses, @$address_id ? $address_id : $primary_addr, 'class="lst_fld"');
		?></td>
    </tr>

    <tr>
      <td>
      <label>Allergies*</label>      
	</td>
      <td>Yes <?=form_radio('alergy', "yes", ! empty($allergies_str) and @$allergies) ?> No <?=form_radio('alergy', "no", empty($allergies_str) or ! @$allergies) ?></td>
      <td valign="top">
       <?php  if(@$cleanses_date) : ?>
       	Delivery/Start Date  <br>
       	<?=ci()->load->view('cleanses_date_info',array('cleanses_date'=> $_SESSION['cleanses_date'], true)) ?>
       <?php endif; ?>
      </td>
    </tr>
   
    <tr id="allergies_content" style="display:none;">
      <td colspan="3">
     
      Your Allergies<br>
      <?=@$allergies_table?>
      <textarea name="allergies_content" class="cmnts_fld" id="notes" disabled="disabled"><?=@$allergies_str?></textarea></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    
    <tr>
      <td colspan="3">
     
      Notes<br><textarea name="notes" class="cmnts_fld" id="notes" > </textarea></td>
      </tr>
  </table>
</div>				

	
	<div style="margin:5px 0 0 15px;">
		<?= form_submit(array('name' => 'submit', 'value' => lang('save'), 'class' => 'button')); ?>
	</div>
	<?= form_close(); ?>
</div>
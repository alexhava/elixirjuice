<div style="padding:5px">
	<?php echo $this->load->view('users/home','',TRUE) ?>
	<table cellpadding="5" cellspacing="0" width="70%" align="center">
	<tr valign="top">
		<td><h3>My Primary Address</h3>
		This address is used as the pre-selected shipping and billing address for orders placed on this store.
	
	This address is also used as the base for product and service tax calculations.</td>
		<td width="30%" style="background:#eeeeee"><b>My Primary Address</b><p style="color:green">
			<?=$primary_data['name']?><br>
			<?=$primary_data['address1']?><br>
			<?=$primary_data['address3']?>, <?=$states[$primary_data['region']]?> <?=$primary_data['postcode']?>
			</p>
	</td>
	</tr>
	<tr valign="top">
		<td colspan="3"><h3>My Address Book Entries</h3>
		</td>
	</tr>
	<?php foreach($addresses as $addr): ?>
	<tr valign="top">
		<td style="border-bottom:1px solid #eeeeee">
		<b><?= nbs(3) . $addr['name']?></b><br>
		<?= nbs(6) . $addr['address1']?><br>
		<?= nbs(6) . $addr['address3']?>, <?= $states[$addr['region']]?> <?=$addr['postcode']?>
		</td>
		<td style="border-bottom:1px solid #eeeeee">
		<?='<a href="'.$this->controller_base.'edit_address?address_id='.$addr['address_id'].'" >Edit</a>'?>
		
		<?=$addr['primary']=='n' ? '<a href="'.$this->controller_base.'remove_address_book?address_id='.$addr['address_id'].'" class="delete">'.lang('delete').'</a>' : ''?>
		
		</td>
	</tr>
	<?php endforeach;?>
	<tr>
	<td colspan="2" align="right"><?=@ form_submit(array('name' => 'button', 'value' => 'New Address', 'class' => 'button', 'style'=>'width:100px', 'onclick'=>'document.location.href=\''.$this->controller_base.'add_address\'')); ?></td>
	</tr>
	</table>
</div>

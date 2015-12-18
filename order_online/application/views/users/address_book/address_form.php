<div style="padding:5px">
	<?php echo $this->load->view('users/home','',TRUE) ?>
	<?=@ form_open($this->controller_base.$action, '', array('address_id'=>@$address_id)); ?>
					<div class="abt_main">
						<div class="abt_brdr">
							<div >
								<div class="prss_sub">
									<div class="cntct_sb_hd">
										<h1 style="font-size:30px">Address Edit</h1>
									</div>
									<div class="contct_cntnr" >
	  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
	    <tr>
	      <td colspan="4" class="register_header"> <b>Personal Details</b></td>
	    </tr>
	    <tr>
	      <td> <label>Name*</label></td>
	      <td><input type="text" name="name" id="name" class="cntct_fld" value="<?=@$name?>"/></td>
	      <td> <label>Post Code*</label></td>
	      <td><input type="text" name="postcode" id="postcode" class="cntct_fld" value="<?=@$postcode?>"/></td>
	    </tr>
	    <tr>
	      <td><label>Address Line 1*</label></td>
	      <td><input type="text" name="address1" id="address1" class="cntct_fld" value="<?=@$address1?>"/></td>
	      <td><label>City*</label></td>
	      <td><input type="text" name="address3" id="address3" class="cntct_fld" value="<?=@$address3?>"/></td>
	    </tr>    
	    <tr>
	      <td><label>Address Line 2</label></td>
	      <td><input type="text" name="address2" id="address2" class="cntct_fld" value="<?=@$address2?>"/></td>    
	      <td ><label>State/Province*</label></td>
	      <td ><?=@form_dropdown('region', $this->taxes_model->get_states(), $region, 'id="state" class="lst_fld"')?></td>
	    </tr>
	   </table>								
	<div style="float:left;">
		<?=@ form_submit(array('name' => 'submit', 'value' => $action_text, 'class' => 'button', 'style'=>'width:100px')); ?>
		<?php if(@$primary!='y'): echo nbs(3) ?>
		Set this address as my primary address <input type="checkbox" name="primary" value="y">
		<?php endif; ?>
	</div> 
	
									</div>
									<div class="clr">
									</div>
								</div>
							</div>
						</div>
						
					</div>
	</form>
</div>
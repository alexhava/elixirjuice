<?php echo $this->load->view('users/home','',TRUE) ?>
<?=@ form_open($this->controller_base.'edit'); ?>
				<div class="abt_main">
					<div class="abt_brdr">
						<div >
							<div class="prss_sub">
								<div class="cntct_sb_hd">
									<h1 style="font-size:30px">Profile Edit</h1>
								</div>
								<div class="contct_cntnr" >
			<?php if(@count(@$error)):?>				
			<?php foreach ($error as $err_mes):?>
			<div><font color="Red"><?=@$err_mes?></font></div>				
			<?php endforeach; ?>			
			<?php endif;?>	
  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td colspan="4" class="register_header"> <b>Personal Details</b></td>
    </tr>
    <tr>
      <td> <label>Name*</label></td>
      <td><input type="text" name="name" id="name" class="cntct_fld" value="<?=@$name?>"/></td>
      <td> <label>Company Name</label></td>
      <td><input type="text" name="company_name" id="company_name" class="cntct_fld" value="<?=@$company_name?>"/></td>
    </tr>
    <tr>
      <td><label>Telephone Number*</label></td>
      <td><input type="text" name="phone" id="phone" class="cntct_fld" value="<?=@$phone?>"/></td>      
      <td><label>E-Mail Address*</label></td>
      <td><input type="text" name="email" id="email" class="cntct_fld" value="<?=@$email?>"/></td>
    </tr>
  </table>								
<div style="float:left;">
	<?=@ form_submit(array('name' => 'submit', 'value' => 'Update', 'class' => 'button', 'style'=>'width:100px')); ?>
</div> 

								</div>
								<div class="clr">
								</div>
							</div>
						</div>
					</div>
					
				</div>
</form>

<?php echo $this->load->view('users/home','',TRUE) ?>
<?=@ form_open($this->controller_base.'change_password'); ?>
				<div class="abt_main">
					<div class="abt_brdr">
						<div >
							<div class="prss_sub">
								<div class="cntct_sb_hd">
									<h1 style="font-size:30px">Change Password</h1>
								</div>
								<div class="contct_cntnr" >
  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
   <tr>    
    <td><label>Old Password*</label></td>
    <td><input type="password" name="old_password" id="old_password" class="cntct_fld" value=""/></td>      
    <td >New Password*</td>
    <td ><input type="password" name="password" id="password" class="cntct_fld date" value=""/></td>

    </tr>
    
    <tr>         
    <td colspan="2">

	</td>   
    <td >Retype Password*</td>
    <td ><input type="password" name="confirm_password" id="confirm_password" class="cntct_fld date" value="<?=@$confirm_password?>"/></td>

      </tr>
  </table>								
<div style="float:left;">
	<?=@ form_submit(array('name' => 'submit', 'value' => 'Change Password', 'class' => 'button', 'style'=>'width:110px')); ?>
</div> 

								</div>
								<div class="clr">
								</div>
							</div>
						</div>
					</div>
					
				</div>
</form>

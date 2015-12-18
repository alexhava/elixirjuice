<?=@ form_open('/users/login', '', array('member_id'=> @$member_id, 'registration'=>true)); ?>

			<?php if(@count(@$error)):?>				
			<?php foreach ($error as $err_mes):?>
			<div align="left"><font color="Red"><?=@$err_mes?></font></div>				
			<?php endforeach; ?>			
			<?php endif;?>	
  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td colspan="4" class="register_header"> <b>Personal Details</b></td>
    </tr>
    <tr>
      <td> <label>First Name*</label></td>
      <td><input type="text" name="firstname" id="firstname" class="cntct_fld" value="<?=@$firstname?>"/></td>
     </tr>
    <tr>
      <td><label>Last Name* </label></td>
      <td><input type="text" name="lastname" id="lastname" class="cntct_fld" value="<?=@$lastname?>"/></td>
     </tr>     
    <tr>     
      <td> <label>Company Name</label></td>
      <td><input type="text" name="company" id="company" class="cntct_fld" value="<?=@$company?>"/></td>
    </tr>
    <tr>     
      <td><label>Telephone Number*</label></td>
      <td><input type="text" name="phone" id="phone" class="cntct_fld" value="<?=@$phone?>"/></td>
    </tr>
    <tr>
      <td><label>E-Mail Address*</label></td>
      <td><input type="text" name="email" id="email" class="cntct_fld" value="<?=@$email?>"/></td>
    </tr>
    <tr>
      <td colspan="2"  class="register_header"><b>Your Shipping Details</b></td>
    </tr>    
    <tr>
      <td><label>Address Line 1*</label></td>
      <td><input type="text" name="address1" id="address1" class="cntct_fld" value="<?=@$address1?>"/></td>
    </tr>
    <tr>
      <td><label>Address Line 2</label></td>
      <td><input type="text" name="address2" id="address2" class="cntct_fld" value="<?=@$address2?>"/></td>  
    </tr>    
    <tr>      
      <td><label>Post Code*</label></td>
      <td><input type="text" name="postcode" id="postcode" class="cntct_fld" value="<?=@$postcode?>"/></td>
    </tr>    
    <tr>
      <td><label>State/Province*</label></td>
      <td><?=@form_dropdown('region', $this->taxes_model->get_states(), $region, 'id="state" class="lst_fld"')?></td>
    </tr>
    <tr>        
      <td >City*</td>
      <td ><input type="text" name="address3" id="address3" class="cntct_fld" value="<?=@$address3?>"/></td>
    </tr>

    <tr>
      <td colspan="2" class="register_header"><b>Your Passwords</b></td>
    </tr>     
    <tr>    
    <td><label>Account Name*</label></td>
    <td><input type="text" name="username" id="username" class="cntct_fld" value="<?=@$username?>"/></td>   
     </tr>
    <tr>      
    <td >Password*</td>
    <td ><input type="password" name="password" id="password" class="cntct_fld date" value="<?=@$password?>"/></td>

    </tr>
    
    <tr>         
    <td >Retype Password*</td>
    <td ><input type="password" name="confirm_password" id="confirm_password" class="cntct_fld date" value="<?=@$confirm_password?>"/></td>

     </tr>    
     <tr>         
    <td >&nbsp;</td>
    <td >	<?=@ form_submit(array('name' => 'submit', 'value' => 'Register', 'class' => 'button', 'style'=>'width:100px')); ?><br>

	fields marked with '*' are essential</td>

     </tr>
  </table>								


</form>

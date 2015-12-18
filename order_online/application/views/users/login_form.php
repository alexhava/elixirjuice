<div class="abt_main" style="padding: 25px 10px 0;">
	<div class="abt_brdr" align="left">
			<?php if(@count(@$error)):?>				
			<?php foreach ($error as $err_mes):?>
			<div><font color="Red"><?=$err_mes?></font></div>				
			<?php endforeach; ?>			
			<?php endif;?>		
			<div style="float:left;margin-right:10px;width:30%">	
			<form action="/users/login" method="post">
					<input type="hidden" name="adminlogin" value="true">
					<fieldset>
						<legend > <h1 style="font-size:30px">LOGIN</h1></legend>
						<div >
							<div class="form" style="padding:10px;"><label for="name" style="width:110px;"><?php echo lang('login')?></label><input id="Login" style="width:200px;" name="login" /></div>
						</div>
						<div >
							<div class="form" style="padding:10px;"><label for="name" style="width:110px;"><?php echo lang('password')?></label><input id="name" style="width:200px;" type="password" name="password" /></div>
						</div>
						<div >
							<input type="submit" name="Log" value="Access My Account"  class="button" style="margin-top:27px;" />
						</div>
						<div style="clear:both"></div>
						<div style="float:left; padding:0px 0px 0px 10px;" align="left">
							<a href="/users/login/forgotpassword"><?=lang('forgot_password')?></a><br>

						</div>
					</fieldset><br><br>					

				</form>
				</div>
				<div style="float:left;width:65%">
						<fieldset style="background:#ffffff">
						<legend > <h1 style="font-size:30px">I AM A NEW CUSTOMER</h1></legend>
						<?php echo ci()->load->view('users/registration_form', @$registration_vars, true); ?>
					</fieldset>
				</div>	
	</div>
</div>				
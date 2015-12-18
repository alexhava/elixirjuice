<?php if(@count(@$error)):?>				
<?php foreach ($error as $err_mes):?>
<div><font color="Red"><?=$err_mes?></font></div>				
<?php endforeach; ?>			
<?php endif;?>				
			<form action="<?php echo $base_url?>/install/installer/set_admin_pass" method="post">
					<input type="hidden" name="adminlogin" value="true">
					<fieldset>
						<legend style="display: none"> Form</legend>
						<div >
							<div class="form" style="padding:0;"><label for="name" style="width:110px;"><?php echo lang('set_login')?></label><input id="Login" style="width:200px;" name="login" /></div>
						</div>
						<div >
							<div class="form" style="padding:0;"><label for="set_email" style="width:110px;"><?php echo lang('set_email')?></label><input id="email" style="width:200px;" name="email" /></div>
						</div>
						<div>
							<div class="form" style="padding:0;"><label for="set_password" style="width:110px;"><?php echo lang('set_password')?></label><input id="set_password" style="width:200px;" type="password" name="password" /></div>
						</div>
						<div >
							<div class="form" style="padding:0;"><label for="name" style="width:110px;"><?php echo lang('confirm_password')?></label><input id="confirm_password" style="width:200px;" type="password" name="confirm_password" /></div>
						</div>
						<div>
							<input type="submit" name="Log" value="<?php echo lang('next')?>" style="margin-top:17px;" class="button" />
						</div>
					</fieldset>
				</form>
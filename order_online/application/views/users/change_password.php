<div class="abt_main">
	<div class="abt_brdr">
	<h3>Change Password</h3>
			<?php if(@count(@$error)):?>				
			<?php foreach ($error as $err_mes):?>
			<div><font color="Red"><?=$err_mes?></font></div>				
			<?php endforeach; ?>			
			<?php endif;?>				
			<form action="/users/login/change_password" method="post">
					<input type="hidden" name="code" value="<?=$code?>">
					<fieldset>
						<legend style="display: none"> Form</legend>
						<div style="float:left; padding-left:20px;">
							<div class="form" style="padding:0;"><label for="name" style="width:110px;"><?php echo lang('new_password')?></label><input id="name" style="width:200px;" type="password" name="password" /></div>
						</div>
						<div style="float:left; padding-left:20px;">
							<div class="form" style="padding:0;"><label for="name" style="width:110px;"><?php echo lang('confirm_password')?></label><input id="name" style="width:200px;" type="password" name="confirm_password" /></div>
						</div>
						<div style="float:left; padding-left:20px;">
							<input type="submit" name="Log" value="Change Password"  class="button" style="margin-top:17px;" />
						</div>
					</fieldset>
				</form>
	</div>
</div>				
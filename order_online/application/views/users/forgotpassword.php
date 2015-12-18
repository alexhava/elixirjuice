<div class="abt_main">
	<div class="abt_brdr" align="center">
	<h3>Password Recovery</h3>

			<?php if(@count(@$error)):?>				
			<?php foreach ($error as $err_mes):?>
			<div><font color="Red"><?=$err_mes?></font></div>				
			<?php endforeach; ?>			
			<?php endif;?>				
			<form action="/users/login/forgotpassword" method="post">
					<input type="hidden" name="adminlogin" value="true">
					<fieldset style="width:30%">
						<legend style="display: none"> Form</legend>
						<div style="float:left;">
							<div class="form" style="padding:0;"><label for="email" style="width:110px;"><?php echo lang('email')?></label><input id="email" style="width:200px;" name="email" /></div>
						</div>

						<div style="float:left; padding-left:20px;">
							<input type="submit" name="Log" value="Next"  class="button" style="margin-top:17px;" />
						</div>
					</fieldset>
				</form>
	</div>
</div>				
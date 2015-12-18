<?php echo $this->load->view('users/home','',TRUE) ?>
<?=@ form_open($this->controller_base.'wholesale'); ?>
				<div class="abt_main">
					<div class="abt_brdr">
						<div >
							<div class="prss_sub">
								<div class="cntct_sb_hd">
									<h1 style="font-size:30px">Wholesale</h1>
								</div>
								<div class="contct_cntnr" >
  <table border="0" cellspacing="5" cellpadding="0">
    <tr>
      <td> <label><b>Request Wholesale Account </b> </label></td>
      <td align="left">
      	<input type="hidden" name="wholesale" value="n"/>
      	<input type="checkbox" name="wholesale" id="wholesale" value="y" <?php if(@$wholesale == 'y') { ?>checked<?php } ?>/>
      </td>
    </tr>
    <?php if(@$wholesale == 'y') :?>
    <tr>
      <td><label><b>Wholesale Status</b></label></td>
      <td> <?php if(@$wholesale_enabled == 'y') :?> Approved <?php else : ?> Not Approved<?php endif; ?></td>      
    </tr>
    <?php endif; ?>
  </table>								
<div style="float:left;">
	<?=@ form_submit(array('name' => 'submit', 'value' => 'Send Wholesale Request', 'class' => 'button', 'style'=>'width:150px')); ?>
</div> 

								</div>
								<div class="clr">
								</div>
							</div>
						</div>
					</div>
					
				</div>
</form>

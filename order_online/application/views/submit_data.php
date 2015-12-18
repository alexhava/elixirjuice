<div style="padding:5px">
	<?php echo $this->load->view('users/home','',TRUE) ?>
	
	<?php	
	$this->table->clear();
	$table_template2 = array(
	'table_template' => array(
	'table_open'		=> '<table  border="0" cellspacing="0" cellpadding="0">',
	),
	);
	$this->table->set_template($table_template2);
	
	if(@$allergies)
	{
		foreach ($allergies as $allergy)
		{
			$table_arr[] = form_checkbox('allergies[]', $allergy, true, 'class="alergy_checkbox"') . nbs() . $allergy;
			$allergy_arr[] = $allergy;
		}
	
		$allergies_table = $this->table->generate($this->table->make_columns($table_arr, 6));
		$allergies_str = implode(', ', $allergy_arr);
	}
	
	?>
	
	
	<div id="progress_pain">
	<h3>Checkout Progress</h3>
			<div class="confim-first-panel billing_address_progress" >			
				<div class="order-confirm-title">Billing Address</div>	
				<table align="left"  border="0" cellspacing="0" cellpadding="0" >
				    <tr>
				      <td> 
				      
				      <span id="billing_first_name_confirm"></span> <span id="billing_last_name_confirm"></span><br>

				      <span id="billing_email_confirm"></span><br>
					  <span id="billing_address_confirm"></span>, 
					  <span id="billing_city_confirm"></span>, <span id="billing_zip_confirm"></span><br>
					  <span id="billing_region_confirm"></span><br>
					  
				      <span id="billing_phone_confirm"></span>
				      </td>
				    </tr>
				  </table>	
			  </div>	
			  <div class="clr"></div>
			  <div class="confim-first-panel delivery_address_progress">			
				<div class="order-confirm-title">Delivery Address</div>	
				<table align="left"  border="0" cellspacing="0" cellpadding="0" >
				    <tr>
				      <td> 
				      
				      <span id="delivery_first_name_confirm"></span> <span id="delivery_last_name_confirm"></span><br>

				      <span id="delivery_email_confirm"></span><br>
					  <span id="delivery_address_confirm"></span>, 
					  <span id="delivery_city_confirm"></span>, <span id="delivery_zip_confirm"></span><br>
					  <span id="delivery_region_confirm"></span><br>
					  
				      <span id="delivery_phone_confirm"></span>
				      </td>
				    </tr>
				  </table>
			  </div>
			  <div class="clr"></div>	 
			   
			  <div class="confim-first-panel delivery_method_progress">			
				<div class="order-confirm-title">Delivery Method</div>	
				<table align="left"  border="0" cellspacing="0" cellpadding="0" >
				    <tr>
				      <td> <label>Method</label><br>
							<span id="delivery_delivery_method_confirm"></span></td>
				    </tr>
				    <tr>
				      <td> <label>Store</label><br>
							<span id="delivery_store_confirm"></span></td>
				    </tr>
				    <tr>
				      <td> <label>Delivery/Pick up date</label><br>
							<span id="delivery_pickup_date_confirm"></span></td>
				    </tr>
				    <tr>
				      <td> <label>Delivery/Pick up time</label><br>
							<span id="delivery_pickup_time_confirm"></span></td>
				    </tr>
				  </table>	
			  </div>	 
			  <div class="clr"></div> 
			  <div class="confim-first-panel alergies_notes_progress">			
				<div class="order-confirm-title">Other</div>	
				<table align="left" border="0" cellspacing="0" cellpadding="0" >
				    <tr>
				      <td> <label>Allergies</label><br>
							<span id="allergies_confirm"></span></td>
				    </tr>
				    <tr>
				      <td> <label>Notes</label><br>
							<span id="notes_confirm"></span>
					  </td>
				    </tr>
				  </table>	
			  </div>
			  <div class="clr"></div>	
	</div>
	<div id="form_pain">
		<form method="post" action="/cart/do_payment" class="submit_order">
		
		<!-- STEP 1 -->
		<div class="step-container<?=ci()->is_user_logged() ? ' skip' : ''?>">
			<div class="step-title"> <img src="/images/arrow-expand.png"/> Checkout Options</div>
			<div id="step1" class="steps <?=ci()->is_user_logged() ? 'skip steps-hide' : ''?>">
			  <table align="center" width="100%" border="0" cellspacing="10" cellpadding="0" id="checkout_options">
			    <tr>
			      <td valign="top">
			      <h3>Please register yourself or checkout as guest</h3>
			      <input type="radio" name="login_type" value="guest"> Checkout as guest<br>
			      <input type="radio" name="login_type" value="register"> Register (your billing information will be used)
				</td>
			      <td>
			      <h3>Already registered? Please log in below</h3>
								<div >
									<div class="form" style="padding:10px;"><label for="name" style="width:110px;"><?php echo lang('login')?></label><input id="Login" style="width:200px;" name="login" /></div>
								</div>
								<div >
									<div class="form" style="padding:10px;"><label for="name" style="width:110px;"><?php echo lang('password')?></label><input id="name" style="width:200px;" type="password" name="password" /></div>
								</div>
								<div style="clear:both"></div>
								<div style="float:left; padding:0px 0px 0px 10px;" align="left">
									<a href="/users/login/forgotpassword"><?=lang('forgot_password')?></a><br>
								</div>
			      </td>
			    </tr>
			  </table>	
			  <div class="next-step validate" id="checkout_options_step">CONTINUE -></div>
			  <div class="clr"></div>
			</div>
		</div>
		<!-- STEP 1 END-->
		
		<!-- STEP 1 -->
		<div class="step-container">
			<div class="step-title"> <img src="/images/arrow-expand.png"/> Billing Address</div>
			<div id="step1" class="steps <?=ci()->is_user_logged() ?'' : 'steps-hide'?>">
			  <table align="center" width="615" border="0" cellspacing="0" cellpadding="0" id="client_info">
			    <tr>
			      <td> <label>First Name*</label><br>
			<input type="text" name="first_name" id="first_name" class="cntct_fld" value="<?=@$first_name?>"/></td>
			      <td>&nbsp;</td>
			      <td><label>Last Name*</label><br><input type="text" name="last_name" id="last_name" class="cntct_fld" value="<?=@$last_name?>"/></td>
			    </tr>
			    <tr>
			      <td> <label>Email*</label><br><input type="text" name="x_email" id="x_email" class="cntct_fld" value="<?=@$email?>"/></td>
			      <td>&nbsp;</td>
				  <td><label>Address*</label><br>
			<input type="text" name="x_address" id="x_address" class="cntct_fld" value="<?=@$address1?>"/></td>	      
			    </tr>
			
			    <tr>
			      <td><label>City*</label><br>
			<input type="text" name="x_city" id="x_city" class="cntct_fld" value="<?=@$address3?>"/></td>	      
			      <td>&nbsp;</td>
			      <td>
			      <label>State*</label><br>
				  <?=form_dropdown('region', $this->taxes_model->get_states(), @$region, 'id="state" class="lst_fld"')?>
			     </td>
			    </tr>
			    <tr>
			      <td><label>Zip Code*</label><br>
			<input type="text" name="x_zip" id="x_zip" class="cntct_fld" value="<?=@$postcode?>"/></td>
			    <td>&nbsp;</td>	      
			    <td>
				 <label>Phone*</label><br>
				<input type="text" name="x_phone" id="x_phone" class="cntct_fld" value="<?=@$phone?>"/>
				</td>
				</tr>
			    <tr>
			    <tr class="hide online-registration-password">
			      <td><label>Password*</label><br>
			<input type="password" name="password" id="password" class="cntct_fld" value="" disabled/></td>
			    <td>&nbsp;</td>	      
			    <td>
				 <label>Confirm Password*</label><br>
				<input type="password_confirm" name="password_confirm" id="password" class="cntct_fld" value="" disabled/>
				</td>
				</tr>
			    <tr>
			      <td>Deliver to this address: No <?=form_radio('shipping_same_as_billing', "n", ! empty($shipping_same_as_billing) and @$shipping_same_as_billing != 'y', 'style="height:auto"') ?> Yes <?=form_radio('shipping_same_as_billing', "y", empty($shipping_same_as_billing) or @$shipping_same_as_billing == 'y', 'style="height:auto"') ?></td>
			    <td colspan="2"></td>	      
			    
				</tr>
			    <tr>
			      <td>In store pick up options will be offered as you continue on through the check out process in the Delivery Method section.</td>
			    <td colspan="2"></td>	      
			    
				</tr>
			  </table>	
			  <div class="next-step validate" id="billing_address">CONTINUE -></div>
			  <div class="clr"></div>
			</div>
		</div>
		<!-- STEP 1 END-->
		
		<!-- STEP DELIVERY -->
		<div class="step-container delivery-address">
			<div class="step-title"> <img src="/images/arrow-expand.png"/> Delivery Address</div>
			<div id="step1" class="steps steps-hide">
			
			
			<div id="delivery_table">
			  <table align="center" width="615" border="0" cellspacing="0" cellpadding="0" id="client_info">
			    <tr>
			      <td> <label>First Name*</label><br>
			<input type="text" name="delivery_first_name" id="delivery_first_name" class="cntct_fld" value="<?=@$delivery_first_name?>"/></td>
			      <td>&nbsp;</td>
			      <td><label>Last Name*</label><br><input type="text" name="delivery_last_name" id="delivery_last_name" class="cntct_fld" value="<?=@$delivery_last_name?>"/></td>
			    </tr>
			    <tr>
			      <td> <label>Email*</label><br><input type="text" name="delivery_email" id="delivery_email" class="cntct_fld" value="<?=@$delivery_email?>"/></td>
			      <td>&nbsp;</td>
				  <td><label>Address*</label><br>
			<input type="text" name="delivery_address" id="delivery_address" class="cntct_fld" value="<?=@$delivery_address1?>"/></td>	      
			    </tr>
			
			    <tr>
			      <td><label>City*</label><br>
			<input type="text" name="delivery_city" id="delivery_city" class="cntct_fld" value="<?=@$delivery_address3?>"/></td>	      
			      <td>&nbsp;</td>
			      <td>
			      <label>State*</label><br>
				  <?=form_dropdown('store_region', $this->taxes_model->get_stores_states(), @$delivery_region, 'id="store_region" class="lst_fld"')?>
			     </td>
			    </tr>
			    <tr>
			      <td><label>Zip Code*</label><br>
			<input type="text" name="delivery_zip" id="delivery_zip" class="cntct_fld" value="<?=@$delivery_postcode?>"/></td>
			    <td>&nbsp;</td>	      
			    <td>
				 <label>Phone*</label><br>
				<input type="text" name="delivery_phone" id="delivery_phone" class="cntct_fld" value="<?=@$delivery_phone?>"/>
				</td>
				</tr>
			  </table>	
			  </div>
				<!--	  -->
			  
			  <div class="next-step validate"  id="delivery_address">CONTINUE -></div>
			  <div class="clr"></div>
			</div>
		</div>
		<!-- STEP DELIVERY END-->
		
		<!-- STEP METHOD -->
		<div class="step-container">
			<div class="step-title"> <img src="/images/arrow-expand.png"/> Delivery Method</div>
			<div id="delivery_method_step" class="steps steps-hide">
			
			
				<!--	  -->
			<div style="float:left;font-weight:bold;text-align:left" id="store_region_wrapper"> 
			  <div class="delivery-options"></div>
		      <label class="delivery-label">Local stores near your address</label><span id="stores"></span>
		      <label class="delivery-label">What time would you like it by?</label>
		      <label class="instructions delivery-label">Instructions: Please use the calendar to select the day for your order.</label>
		      <input type="hidden" name="delivery_date" class="delivery-date" value="<?=@$date ? $date: ''?>">
		      <input type="text" name="date" class="delivery-date" value="<?=@$date ? $date: ''?>" disabled>
		      <div id="time_section"></div>
		    </div>
			<div id="calendar"> 
							<div id="cleanses_calendar_wrapper_outer"><div id="cleanses_calendar_wrapper"></div></div>
							<script type="text/javascript">
		
							</script>
		    </div>
						<div style="clear:both;"></div>
				<!--	  -->
			  
			  <div class="next-step validate" id='delivery_method'>CONTINUE -></div>
			  <div class="clr"></div>
			</div>
		</div>
		<!-- STEP DELIVERY METHOD END-->
		
		<!-- STEP ALLERGIES -->
		<div class="step-container">
			<div class="step-title"> <img src="/images/arrow-expand.png"/> Allergies and Notes</div>
			<div id="step_payment" class="steps steps-hide">
			  <table width="615" border="0" cellspacing="0" cellpadding="0" id="client_info">
			    <tr>
			      <td>
			      <label>Do you have allergy?</label> <br>
			      Yes <?=form_radio('alergy', "yes", ! empty($allergies_str) and @$alergy != 'no') ?> No <?=form_radio('alergy', "no", empty($allergies_str) or @$alergy == 'no') ?>
				</td>
			      <td>&nbsp;</td>
			      <td valign="top">
			       <?php  if(@$cleanses_date) : ?>
			       	Delivery/Start Date  <br>
			       	<?=ci()->load->view('cleanses_date_info',array('cleanses_date'=> $_SESSION['cleanses_date'], true)) ?>
			       <?php endif; ?>
			      </td>
			    </tr>
			   
			    <tr id="allergies_content" style="display:none;">
			      <td colspan="3">
			      <label>Your Allergies</label><br>
			      <?=@$allergies_table?>
			      <textarea name="allergies_content" class="cmnts_fld" disabled="disabled"><?=@$allergies_str?></textarea></td>
			      </tr>
			    <tr>
			      <td>&nbsp;</td>
			      <td>&nbsp;</td>
			      <td>&nbsp;</td>
			    </tr>
			    
			    <tr>
			      <td colspan="3">
			     
			      <label>Notes</label><br><textarea name="notes" class="cmnts_fld" id="notes" > </textarea></td>
			      </tr>
			  </table>	
			  <div class="next-step" id='alergies_notes'>CONTINUE -></div>	
			  <div class="clr"></div>	  
			</div>
		</div>
		<!-- STEP ALLERGIES END-->
		
		<!-- STEP PAYMENT -->
		<div class="step-container">
			<div class="step-title"> <img src="/images/arrow-expand.png"/> Payment Details</div>
			<div id="step_payment" class="steps steps-hide">
			  <table  border="0" cellspacing="0" cellpadding="0" id="client_info">
			     <tr>
			      <td><label>Credit Card Number * </label><br>
			<input type="text" name="card_number" id="card_number" class="cntct_fld" value="<?=@$card_number?>"/></td>
			      <td>&nbsp;</td>
			      <td><label>Expiry*</label><br>
			      <?php 
		
			      for ($i=0;$i<8;$i++)
			      {
			      	$years[date("y") + $i] = date("y") + $i;
			      }
		
			      for ($i=1;$i<13;$i++)
			      {
			      	$month[sprintf("%02d", $i)] = sprintf("%02d", $i);
			      }
			      echo "Month ".form_dropdown("exp_month", $month, null, 'style="width:50px"');
			      echo " Year ".form_dropdown("exp_year", $years, null, 'style="width:50px"');
		
			      ?></td>
			    </tr>
			  </table>
			  <span class='payment-load'></span><div class="next-step" id='payment_details'>CONTINUE -></div>	
			  <div class="clr"></div>
			</div>
		</div>
		<!-- STEP PAYMENT END-->
		
		<!-- STEP ORDER CONFIRM -->
		<div class="step-container">
			<div class="step-title"> <img src="/images/arrow-expand.png"/> Order Confirm</div>
			<div id="order_confirm_step" class="steps steps-hide">
				<div class="order-confirm-title">Order Items</div>
					<?php	
					$this->table->clear();
					$table_template['table_open'] = '<table class="confirm-items" border="0" cellspacing="0" cellpadding="0">';
					$this->table->set_template($table_template);
		
					$this->table->set_heading(
					array('data' => 'Item', 'width'=>'55%' ),
					array('data' => 'Price', ),
					array('data' => 'Qty', 'width'=>'50px' ),
					array('data' => 'Item Total', 'width'=>'15%')
					);
		
					foreach ($this->cart->contents() as $key => $items)
					{
						$this->table->add_row(array(
						$items['option']['product_title'],
						'$'.$this->cart->format_number($items['price']),
						$items['qty'],
						'$'.$this->cart->format_number($items['subtotal']),
						));
					}
					echo $this->table->generate();
					?>
					
					
						<div style="clear:both;"></div>
						<div class="coupon" >
							<b>Have a coupon? </b> 
							<b>Put it into field below and click Apply</b><br>
							<input type="text" name="coupon_code" value="" style="width:50px"> 
							<a href="#" id="apply_coupon">Apply</a> <br><span id="coupon_res"></span> 
						</div>	
						<div class="total-container">	
							<div style="clear:both;"></div>
							<div style="float:right;font-weight:bold;"> Shipping & Sales Tax: $<span class="simpleCart_shipping"></span></div>
							<div style="clear:both;"></div>
							<div style="float:right;font-weight:bold;">Delivery: $<span class="simpleCart_tax"></span></div>				
							<div style="clear:both;"></div>
							<div style="float:right;font-weight:bold;"><h2>Total: $<span class="simpleCart_grandTotal"></span></h2></div>
							<div style="clear:both;"></div>	
							<div style="float:right;font-weight:bold;"><h2><span class="coupon_total"></span></h2></div>	
			
							<div style="clear:both;"></div><br> 
						</div>	
						<div style="clear:both;"></div><br> 
					

			  <div class="clr"></div>		
			  <div class="next-step" id='complete_order'>Complete Order >></div>	
			  <div class="clr"></div>
			</div>
		</div>
		<!-- STEP ORDER CONFIRM END-->
		

		
		</form>
	</div>
</div>				
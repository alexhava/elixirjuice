<?php
$this->table->add_row(lang('minimum_amount'), form_input('minimum_amount', @$minimum_amount));
$this->table->add_row(lang('free_delivery_zip'), form_textarea('free_delivery_zip', @$free_delivery_zip));
$this->table->add_row(lang('delivery_fee'), form_input('delivery_fee', @$delivery_fee));
$this->table->add_row(lang('not_free_delivery_zip'), form_textarea('not_free_delivery_zip', @$not_free_delivery_zip));
//$this->table->add_row(lang('shipping_areas'), form_multiselect('shipping_areas[]', array(''=>lang('all_regoins')) + @$this->taxes_model->get_states(), @$shipping_areas, 'style="height:'.count($this->taxes_model->get_states())*10 .'px"'));
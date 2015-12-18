<?php
echo form_hidden('need_user_activation', 'n');
$this->table->add_row(lang('need_user_activation'), form_checkbox('need_user_activation', 'y', @$need_user_activation == 'y'));
$this->table->add_row("Admin Email", form_input('admin_email', @$admin_email));
$this->table->add_row("Time Zone", timezone_menu(@$timezones));
$this->table->add_row("Cleanses's time gap, hours", form_input('time_gap', @$time_gap));

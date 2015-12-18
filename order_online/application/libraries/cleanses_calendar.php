<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cleanses_calendar {

	function get_html($cMonth='', $cYear='', $store_data=array(), $store_id='', $dt='')
	{
		ci()->load->model('admin/calendar_model');
		ci()->load->helper(array('form', 'order'));

		$lead_time = 0;
		if($store_data)
		{
			$lead_time = $store_data['lead_time'] ? $store_data['lead_time'] : ci()->system_settings['time_gap'];
		}

		$open_days = Array
			(
			0 => 'Mon',
			1 => 'Tue',
			2 => 'Wed',
			3 => 'Thu',
			4 => 'Fri',
			5 => 'Sat',
			6 => 'Sun',
			);		
		$open_days = $store_data['open_days'] ? array_intersect_key($open_days, unserialize($store_data['open_days'])) : $open_days;
		$monthNames = Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
		if ( ! $cMonth) $cMonth = date("n");

		if ( ! $cYear) $cYear = date("Y");
		
		$prev_year = $cYear;
		$next_year = $cYear;
		$prev_month = $cMonth-1;
		$next_month = $cMonth+1;

		if ($prev_month == 0) 
		{
			$prev_month = 12;
			$prev_year = $cYear - 1;
		}

		if ($next_month == 13) 
		{
			$next_month = 1;
			$next_year = $cYear + 1;
		}

		$timestamp = mktime(0,0,0,$cMonth,1,$cYear);
		$current_month_stamp = mktime(0,0,0,date('m'),1,date('Y'));
		$currentstamp = mktime(date('H'),0,0,date('m'),date('d'),date('Y'))+$lead_time*3600;

		$maxday = date("t",$timestamp);
		$thismonth = getdate ($timestamp);
		$startday = $thismonth['wday'];
		
		$disable_dates = ci()->calendar_model->get_stamps();
		ob_start();
		echo form_hidden('month', sprintf('%02s', $cMonth));
		echo form_hidden('year', $cYear);
?>
<table class="cleanses_calendar_outer">
	<tr class="cleanses_calendar_prev_next">
		<td>
			<table class="cleanses_calendar_prev_next">
				<tr>
					<td class="cleanses_calendar_prev"> <?php if($current_month_stamp != $timestamp) :  ?>  <a href="<?php echo "/calendar?store_id=$store_id&delivery_type=$dt&month=". $prev_month . "&year=" . $prev_year; ?>" >Previous</a> <?php else :  ?><span class="cleanses_calendar_inactive">Previous<span><?php endif;?></td>
					<td class="cleanses_calendar_current_month"><?php echo $monthNames[$cMonth-1].' '.$cYear; ?></td>
					<td class="cleanses_calendar_next"><a href="<?php echo  "/calendar?store_id=$store_id&delivery_type=$dt&month=". $next_month . "&year=" . $next_year; ?>" >Next</a>  </td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
	
		<td>
			<table class="cleanses_calendar_body">
				<tr class="cleanses_calendar_week_days">
					<td>Sun</td>
					<td>Mon</td>
					<td>Tue</td>
					<td>Wen</td>
					<td>Thu</td>
					<td>Fri</td>
					<td>Sat</td>
				</tr>
			<?php 		

			$note = $other_reason = false;
			$first_date = 0;
			for ($i=0; $i<($maxday+$startday); $i++) 
			{
				if(($i % 7) == 0 ) echo "<tr>";
				if($i < $startday) echo "<td></td>";
				else 
				{
					$cur_day = ($i - $startday + 1);
					$cyclestamp = mktime(20,0,0,$cMonth,$cur_day,$cYear);
					$weekend = date("w", $cyclestamp);
					
					if(isset($disable_dates[$cyclestamp]))
					{
						$other_reason = true;
						$note = "<div id='cell_note'>{$disable_dates[$cyclestamp]}</div>";
					} 
					elseif (! @in_array(date('D', $cyclestamp), $open_days))
					{
						$other_reason = true;
					}
					
					$cleanses_calendar_day_class = ($cyclestamp < $currentstamp or $other_reason) ? 'cleanses_calendar_day_unactive' : 'cleanses_calendar_day_active';
					
					if( $cleanses_calendar_day_class == 'cleanses_calendar_day_active' and ! $first_date)
					{
						$first_date = date('m/d/Y', $cyclestamp);
					}
					echo "<td data-date='".date('m/d/Y', $cyclestamp)."' class='$cleanses_calendar_day_class'><div id='cell_wrapper'>". $cur_day . "$note</div></td>";
				}
				if(($i % 7) == 6 ) echo "</tr>";
				
				$other_reason = false;
				$note = '';
			}
			?>
			</table>
		</td>
	</tr>
</table>

<script type="text/javascript">	
$('.delivery-date').val("<?=$first_date?>");
$('.cleanses_calendar_prev a, .cleanses_calendar_next a').click(function(e){
	e.preventDefault();
	var link = $(this).attr('href');

	$('#cleanses_calendar_wrapper').fadeOut(50, function(){
		$.get(link, function(data){
			$('#cleanses_calendar_wrapper').html(data).fadeIn();
		});		
	});

	return false;
});
</script>	
			<?php
			$cont = ob_get_contents();
			ob_end_clean();
			return $cont;
	}
}

/* End of file cleanses_calendar.php */
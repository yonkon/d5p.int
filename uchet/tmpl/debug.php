<?php echo $output; ?>
<hr />
wrong output:<br />
<?php echo $wrongOutput; ?>
<hr />
debug:<br />
<?php if (count($debugOutput)) {
	foreach($debugOutput as $key => $val) {
		echo '[['.$val['name'].']] = '; 
		if (is_array($val['var'])) {
			self::printArray($val['var']);
		} else {
			echo $val['var']; 
			echo '<br /><br />';
		}
	}
} ?>
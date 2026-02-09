<div class="rgt-sde display-inline">
	<?php $sql = "SELECT * FROM `ads` where company_id = '".$company_id."' order by id desc limit 1";
		$total_records = mysqlFetchRow($sql);
		echo $total_records['column_text']?>
</div>
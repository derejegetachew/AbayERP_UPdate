{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ims_transfers as $ims_transfer){ if($st) echo ","; ?>			{
				"id":"<?php echo $ims_transfer['ImsTransfer']['id']; ?>",
				"name":"<?php echo $ims_transfer['ImsTransfer']['transfer_name']; ?>",
				"ims_sirv":"<?php echo $ims_transfer['s']['sirv_name']; ?>",

				"from_user":"<?php echo (
											isset($ims_transfer['from_people']['from_first_name']) ? $ims_transfer['from_people']['from_first_name'] . ' ' : ''
										) . (
											isset($ims_transfer['from_people']['from_middle_name']) ? $ims_transfer['from_people']['from_middle_name'] . ' ' : ''
										) . (
											isset($ims_transfer['from_people']['from_last_name']) ? $ims_transfer['from_people']['from_last_name'] : ''
										) ?>",
										
				"to_user":"<?php echo (
											isset($ims_transfer['to_people']['to_first_name']) ? $ims_transfer['to_people']['to_first_name'] . ' ' : ''
										) . (
											isset($ims_transfer['to_people']['to_middle_name']) ? $ims_transfer['to_people']['to_middle_name'] . ' ' : ''
										) . (
											isset($ims_transfer['to_people']['to_last_name']) ? $ims_transfer['to_people']['to_last_name'] : ''
										) ?>",


				"from_branch":"<?php echo $ims_transfer['from_branch']['from_branch_name']; ?>",
				"to_branch":"<?php echo $ims_transfer['to_branch']['to_branch_name']; ?>",
				"observer":"<?php echo (
											isset($ims_transfer['observer_people']['observer_first_name']) ? $ims_transfer['observer_people']['observer_first_name'] . ' ' : ''
										) . (
											isset($ims_transfer['observer_people']['observer_middle_name']) ? $ims_transfer['observer_people']['observer_middle_name'] . ' ' : ''
										) . (
											isset($ims_transfer['observer_people']['observer_last_name']) ? $ims_transfer['observer_people']['observer_last_name'] : ''
										) ?>",
				"approved_by":"<?php echo (
											isset($ims_transfer['approved_people']['approved_first_name']) ? $ims_transfer['approved_people']['approved_first_name'] . ' ' : ''
										) . (
											isset($ims_transfer['approved_people']['approved_middle_name']) ? $ims_transfer['approved_people']['approved_middle_name'] . ' ' : ''
										) . (
											isset($ims_transfer['approved_people']['approved_last_name']) ? $ims_transfer['approved_people']['approved_last_name'] : ''
										) ?>",
				"created":"<?php echo $ims_transfer['ImsTransfer']['created']; ?>",
				"modified":"<?php echo $ims_transfer['ImsTransfer']['modified']; ?>"			}
<?php $st = true; } ?>		]
}
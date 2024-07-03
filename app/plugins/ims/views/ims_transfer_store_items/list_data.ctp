{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($ims_transfer_store_items as $ims_transfer_store_item){ if($st) echo ","; ?>			{
				"id":"<?php echo $ims_transfer_store_item['si']['id']; ?>",
				"name":"<?php echo $ims_transfer_store_item['si']['name']; ?>",
				"from_store":"<?php echo $ims_transfer_store_item['s']['from_store']; ?>",
				"to_store":"<?php echo $ims_transfer_store_item['ss']['to_store']; ?>",
				"from_store_keeper":"<?php 
				//echo $ims_transfer_store_item['si']['from store keeper'];
				echo $ims_transfer_store_item[0]['from_store_keeper'];
					// $result = $this->requestAction(
					// 		array(
					// 			'controller' => 'ims_transfer_store_items', 
					// 			'action' => 'getUser'), 
					// 		array('userid' => $ims_transfer_store_item['ImsTransferStoreItem']['from_store_keeper'])
					// 	);				
					
						// echo $result['Person']['first_name'] .' ' .$result['Person']['middle_name'] .' '.
						// $result['Person']['last_name'];
						 ?>",
				"to_store_keeper":"<?php 
				echo $ims_transfer_store_item[0]['to_store_keeper'];
				
				//echo $ims_transfer_store_item['si']['to store keeper']; 
			
					// $result = $this->requestAction(
					// 		array(
					// 			'controller' => 'ims_transfer_store_items', 
					// 			'action' => 'getUser'), 
					// 		array('userid' => $ims_transfer_store_item['ImsTransferStoreItem']['to_store_keeper'])
					// 	);				
					
					// 	echo $result['Person']['first_name'] .' ' .$result['Person']['middle_name'] .' '.
					// 	$result['Person']['last_name']; 
					?>",
				"remark":"<?php echo $ims_transfer_store_item['si']['remark']; ?>",
				"status":"<?php if($ims_transfer_store_item['si']['status'] =='posted'){echo '<font color=#DF7401>posted</font>';}else if($ims_transfer_store_item['si']['status'] =='accepted'){echo '<font color=green>accepted</font>';} else echo $ims_transfer_store_item['si']['status'];?>",
				"created":"<?php echo $ims_transfer_store_item['si']['created']; ?>",
				"modified":"<?php echo $ims_transfer_store_item['si']['modified']; ?>"			}
<?php $st = true; } ?>		]
}
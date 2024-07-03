{
	success:true,
	results: <?php echo $results;  
		$user = $this->Session->read();	
		$user_id = $user['Auth']['User']['id'];?>,
	rows: [
<?php $st = false; foreach($dms_messages as $dms_message){  if($st) echo ","; ?>			{
				"id":"<?php echo $dms_message['m']['id']; $id=$dms_message['m']['id'];?>",
				"name":'<div id="lst<?php echo $id; ?>" style="display: block;float: left;height: 54px;width: 13px;"><input type="checkbox" value="<?php echo $id; ?>" name="checkmsg[]" style="margin-top: 21px;" onclick="if (this.checked) document.getElementById(\'lst<?php echo $id; ?>\').style.backgroundColor=\'lightslategrey\'; else document.getElementById(\'lst<?php echo $id; ?>\').style.backgroundColor=\'unset\';"/></div><div style="pointer-events:none;border-bottom: 1px solid;margin-bottom: -3px;padding-bottom: 10px;float:right;width:95%;" > ' +
						'<table style="width:100%"> ' +
							'<tr> ' +
								'<td style="padding-left:5px;padding-top: 2px;"> ' +
									'<?php
                  // var_dump($dms_message['r']);
									$premsg='color: rgb(128, 128, 128);'; 
								//	foreach($dms_message['r'] as $recp){
									if($dms_message['r']['user_id']==$user_id && $dms_message['r']['read']=='false') {
                // if($recp['user_id']==$user_id && $recp['read']=='false') {
									//$premsg= 'color: #D98880;'; 
									$premsg= 'color: rgb(49, 78, 89);';
                   }
									//$premsg= 'color: rgb(77, 93, 99);'; //temp																					
								//	}
									echo '<h1 style="'.$premsg.'font-size: 13px;text-transform: capitalize;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;width: 240px;">'.$dms_message['m']['name']; ?> </h1> '+
									'<p style="<?php echo $premsg; ?>padding-right: 25px; float:left;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;width: 175px;"><span style="color:lightslategrey;font-weight: bold;"><?php echo $dms_message['pp']['first_name'].' '.$dms_message['pp']['middle_name']; ?></span></br>' + 
									'<?php $branch='';
                                                 
									//	if(isset($dms_message['EmployeeDetail']))
									//	foreach($dms_message['EmployeeDetail'] as $emp){
									//	if($emp['end_date']=='0000-00-00'){
									//		$branch=$emp['Branch']['name'];
									//	}}
                  //  echo $branch; 
                     echo $dms_message['po']['Position'];  
                    ?> </p>' +
										'</td>' +
								'<td>' +
									'<p style="<?php echo $premsg; ?>float: right;margin-right: 20px;padding-top: 19px;"><?php echo date("F j, Y",strtotime($dms_message['m']['created'])); ?></br>' +
									'<?php 
									if(!empty($dms_message['a'][id])  ){
									echo '<img src="img/attachments.ico" alt="Attachement">' ; 
                  } 
                  ?> </p>'+
								'</td>' +
							'</tr>' +
						'</table>' +
					'</div>',
				"user":"<?php echo $dms_message['m']['id']; ?>",
				"created":"<?php echo $dms_message['m']['created']; ?>",
				"message":'',
				"status":"<?php echo $dms_message['m']['status']; ?>",
				"old_record":"<?php echo $dms_message['m']['old_record']; ?>",
				"size":"<?php echo $dms_message['m']['size']; ?>",
				"number":"<?php echo $dms_message['m']['number']; ?>"			}
<?php $st = true; } ?>		]
}
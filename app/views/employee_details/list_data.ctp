{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($employee_details as $employee_detail){ if($st) echo ","; ?>			{
				"id":"<?php echo $employee_detail['EmployeeDetail']['id']; ?>",
   	     "status":"<?php echo $employee_detail['EmployeeDetail']['status']; ?>",
				"employee":"<?php echo $employee_detail['Employee']['id']; ?>",
				"grade":"<?php echo $employee_detail['Grade']['name']; ?>",
				"step":"<?php echo $employee_detail['Step']['name']; ?>",
				"position":"<?php echo $employee_detail['Position']['name']; ?>",
                                "branch":"<?php echo $employee_detail['Branch']['name']; ?>",
				"start_date":"<?php echo $employee_detail['EmployeeDetail']['start_date']; ?>",
                                "end_date":"<?php if($employee_detail['EmployeeDetail']['end_date']=='0000-00-00') echo 'To Date'; else echo $employee_detail['EmployeeDetail']['end_date']; ?>",
				"created":"<?php echo $employee_detail['EmployeeDetail']['created']; ?>",
				"modified":"<?php echo $employee_detail['EmployeeDetail']['modified']; ?>"			}
<?php $st = true; } ?>		]
}
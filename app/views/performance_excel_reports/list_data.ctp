{
	success:true,
	results: <?php echo $results; ?>,
	rows: [
<?php $st = false; foreach($performance_excel_reports as $performance_excel_report){ if($st) echo ","; ?>			{
				"id":"<?php echo $performance_excel_report['PerformanceExcelReport']['id']; ?>",
				"employee":"<?php echo $performance_excel_report['Employee']['id']; ?>",
				"budget_year":"<?php echo $performance_excel_report['BudgetYear']['name']; ?>",
				"card_number":"<?php echo $performance_excel_report['PerformanceExcelReport']['card_number']; ?>",
				"first_name":"<?php echo $performance_excel_report['PerformanceExcelReport']['first_name']; ?>",
				"middle_name":"<?php echo $performance_excel_report['PerformanceExcelReport']['middle_name']; ?>",
				"last_name":"<?php echo $performance_excel_report['PerformanceExcelReport']['last_name']; ?>",
				"sex":"<?php echo $performance_excel_report['PerformanceExcelReport']['sex']; ?>",
				"date_of_employment":"<?php echo $performance_excel_report['PerformanceExcelReport']['date_of_employment']; ?>",
				"status":"<?php echo $performance_excel_report['PerformanceExcelReport']['status']; ?>",
				"last_position":"<?php echo $performance_excel_report['PerformanceExcelReport']['last_position']; ?>",
				"branch":"<?php echo $performance_excel_report['PerformanceExcelReport']['branch']; ?>",
				"branch_district":"<?php echo $performance_excel_report['PerformanceExcelReport']['branch_district']; ?>",
				"budget_year":"<?php echo $performance_excel_report['PerformanceExcelReport']['budget_year']; ?>",
				"q1":"<?php echo $performance_excel_report['PerformanceExcelReport']['q1']; ?>",
				"q2":"<?php echo $performance_excel_report['PerformanceExcelReport']['q2']; ?>",
				"q1q290":"<?php echo $performance_excel_report['PerformanceExcelReport']['q1q290']; ?>",
				"behavioural1":"<?php echo $performance_excel_report['PerformanceExcelReport']['behavioural1']; ?>",
				"semi_annual_one":"<?php echo $performance_excel_report['PerformanceExcelReport']['semi_annual_one']; ?>",
				"q3":"<?php echo $performance_excel_report['PerformanceExcelReport']['q3']; ?>",
				"q4":"<?php echo $performance_excel_report['PerformanceExcelReport']['q4']; ?>",
				"q3q490":"<?php echo $performance_excel_report['PerformanceExcelReport']['q3q490']; ?>",
				"behavioural2":"<?php echo $performance_excel_report['PerformanceExcelReport']['behavioural2']; ?>",
				"semi_annual_two":"<?php echo $performance_excel_report['PerformanceExcelReport']['semi_annual_two']; ?>",
				"annual":"<?php echo $performance_excel_report['PerformanceExcelReport']['annual']; ?>",
				"q1_training1":"<?php echo $performance_excel_report['PerformanceExcelReport']['q1_training1']; ?>",
				"q1_training2":"<?php echo $performance_excel_report['PerformanceExcelReport']['q1_training2']; ?>",
				"q1_training3":"<?php echo $performance_excel_report['PerformanceExcelReport']['q1_training3']; ?>",
				"q2_training1":"<?php echo $performance_excel_report['PerformanceExcelReport']['q2_training1']; ?>",
				"q2_training2":"<?php echo $performance_excel_report['PerformanceExcelReport']['q2_training2']; ?>",
				"q2_training3":"<?php echo $performance_excel_report['PerformanceExcelReport']['q2_training3']; ?>",
				"q3_training1":"<?php echo $performance_excel_report['PerformanceExcelReport']['q3_training1']; ?>",
				"q3_training2":"<?php echo $performance_excel_report['PerformanceExcelReport']['q3_training2']; ?>",
				"q3_training3":"<?php echo $performance_excel_report['PerformanceExcelReport']['q3_training3']; ?>",
				"q4_training1":"<?php echo $performance_excel_report['PerformanceExcelReport']['q4_training1']; ?>",
				"q4_training2":"<?php echo $performance_excel_report['PerformanceExcelReport']['q4_training2']; ?>",
				"q4_training3":"<?php echo $performance_excel_report['PerformanceExcelReport']['q4_training3']; ?>",
				"q1_technical_plan_status":"<?php echo $performance_excel_report['PerformanceExcelReport']['q1_technical_plan_status']; ?>",
				"q1_technical_result_status":"<?php echo $performance_excel_report['PerformanceExcelReport']['q1_technical_result_status']; ?>",
				"q1_technical_comment":"<?php echo $performance_excel_report['PerformanceExcelReport']['q1_technical_comment']; ?>",
				"q2_technical_plan_status":"<?php echo $performance_excel_report['PerformanceExcelReport']['q2_technical_plan_status']; ?>",
				"q2_technical_result_status":"<?php echo $performance_excel_report['PerformanceExcelReport']['q2_technical_result_status']; ?>",
				"q2_technical_comment":"<?php echo $performance_excel_report['PerformanceExcelReport']['q2_technical_comment']; ?>",
				"q2_behavioural_result_status":"<?php echo $performance_excel_report['PerformanceExcelReport']['q2_behavioural_result_status']; ?>",
				"q2_behavioural_comment":"<?php echo $performance_excel_report['PerformanceExcelReport']['q2_behavioural_comment']; ?>",
				"q3_technical_plan_status":"<?php echo $performance_excel_report['PerformanceExcelReport']['q3_technical_plan_status']; ?>",
				"q3_technical_result_status":"<?php echo $performance_excel_report['PerformanceExcelReport']['q3_technical_result_status']; ?>",
				"q3_technical_comment":"<?php echo $performance_excel_report['PerformanceExcelReport']['q3_technical_comment']; ?>",
				"q4_technical_plan_status":"<?php echo $performance_excel_report['PerformanceExcelReport']['q4_technical_plan_status']; ?>",
				"q4_technical_result_status":"<?php echo $performance_excel_report['PerformanceExcelReport']['q4_technical_result_status']; ?>",
				"q4_technical_comment":"<?php echo $performance_excel_report['PerformanceExcelReport']['q4_technical_comment']; ?>",
				"q4_behavioural_result_status":"<?php echo $performance_excel_report['PerformanceExcelReport']['q4_behavioural_result_status']; ?>",
				"q4_behavioural_comment":"<?php echo $performance_excel_report['PerformanceExcelReport']['q4_behavioural_comment']; ?>",
				"report_status":"<?php echo $performance_excel_report['PerformanceExcelReport']['report_status']; ?>",
				"report_time":"<?php echo $performance_excel_report['PerformanceExcelReport']['report_time']; ?>"			}
<?php $st = true; } ?>		]
}
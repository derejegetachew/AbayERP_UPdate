<?php
class BranchPerformanceSettingsController extends AppController {

	var $name = 'BranchPerformanceSettings';
	
	function index() {
		$positions = $this->BranchPerformanceSetting->Position->find('all');
		$this->set(compact('positions'));
	}

	function get_total_weight( $budget_year_id, $q, $position_id){

		$this->loadModel('BudgetYear');
	$conditions3 = array('BudgetYear.id' => $budget_year_id );
	$hoBudgetYear = $this->BudgetYear->find('first', array('conditions' => $conditions3));
	
	//find out if it is branch or not--------------------------------------------------------------------------
	$from_date = $hoBudgetYear['BudgetYear']['from_date'];
	$to_date = $hoBudgetYear['BudgetYear']['to_date'];

		
		$dates_array = array();
	   $year_only_from = date('Y', strtotime($from_date));
	  $year_only_to = date('Y', strtotime($to_date));

	   if($q == 1){
		   $quarter_start_date = $year_only_from."-07-01";
		   $quarter_end_date = $year_only_from."-09-30";
	   }
	   if($q == 2){
		   $quarter_start_date = $year_only_from."-10-01";
		   $quarter_end_date = $year_only_from."-12-31";
	   }
	   if($q == 3){
		   $quarter_start_date = $year_only_to."-01-01";
		   $quarter_end_date = $year_only_to."-03-31";
	   }
	   if($q == 4){
		   $quarter_start_date = $year_only_to."-04-01";
		   $quarter_end_date = $year_only_to."-06-30";
	   }

	//    $start_date = date('Y-m-d', strtotime($quarter_start_date . ' - 10 days')); // for the new one marks the start
	//    $end_date = date('Y-m-d', strtotime($quarter_start_date . ' + 10 days'));  //for the previous one marks the end
	//    $dates_array.push($start_date);
	//    $dates_array.push($end_date);

	//    return $dates_array ;
	$total_weight = 0;
	$total_weight_row = $this->BranchPerformanceSetting->query('select sum(weight) as sum_weight from branch_performance_settings where position_id = '. $position_id. '  and start_date <= "'.$quarter_start_date.'" and (end_date >= "'.$quarter_end_date.'" || end_date is NULL)');
	$sum_weight = $weight_row[0][0]['sum_weight'];
			if($sum_weight != null) {
				$total_weight =  $sum_weight;
			}
			else {
				$total_weight = 0;
			}
    return $total_weight; 

}
	
	function index2($id = null) {
		$this->set('parent_id', $id);
	}

	function search() {

	}
	
	function list_data($id = null) {
		$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
		$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 5;
		$position_id = (isset($_REQUEST['position_id'])) ? $_REQUEST['position_id'] : -1;
		if($id)
			$position_id = ($id) ? $id : -1;
        $conditions = (isset($_REQUEST['conditions'])) ? $_REQUEST['conditions'] : '';

        eval("\$conditions = array( " . $conditions . " );");
		if ($position_id != -1) {
            $conditions['BranchPerformanceSetting.position_id'] = $position_id;
        }
        
        $positions = $this->get_positions();
		
		$this->set('branchPerformanceSettings', $this->BranchPerformanceSetting->find('all', array('conditions' => $conditions, 'limit' => $limit, 'offset' => $start)));
		$this->set('results', $this->BranchPerformanceSetting->find('count', array('conditions' => $conditions)));
   $this->set(compact('positions'));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid branch performance setting', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->BranchPerformanceSetting->recursive = 2;
		$this->set('branchPerformanceSetting', $this->BranchPerformanceSetting->read(null, $id));
	}

	function add2($id = null){
		if (!empty($this->data)) {
			$original_data = $this->data;
		
			$this_weight = $original_data['BranchPerformanceSetting']['weight'];
			$position = $original_data['BranchPerformanceSetting']['position_id'];
			$goal = str_replace("'", "`", $original_data['BranchPerformanceSetting']['goal']);
			$measure = str_replace("'", "`", $original_data['BranchPerformanceSetting']['measure']);
			$target = str_replace("'", "`", $original_data['BranchPerformanceSetting']['target']);

			$original_data['BranchPerformanceSetting']['goal'] = $goal;
			$original_data['BranchPerformanceSetting']['measure'] = $measure;
			$original_data['BranchPerformanceSetting']['target'] = $target;

//---------------------------------------------check for duplicate----------------------------------------------------------------
			$goal_row = $this->BranchPerformanceSetting->query("select * from branch_performance_settings 
			where position_id = ".$position."
			and goal = '".$goal."' and measure = '".$measure."' and target = '".$target."' ");
//---------------------------------------------end of check for duplicates--------------------------------------------------------

//--------------------------------------check if the pointers are numeric-----------------------------------------------------------
$pointers_numeric = false;
if(is_numeric($original_data['BranchPerformanceSetting']['five_pointer_min']) && is_numeric($original_data['BranchPerformanceSetting']['five_pointer_max_included'])
	&& is_numeric($original_data['BranchPerformanceSetting']['four_pointer_min']) && is_numeric($original_data['BranchPerformanceSetting']['four_pointer_max_included'])
	&& is_numeric($original_data['BranchPerformanceSetting']['three_pointer_min']) && is_numeric($original_data['BranchPerformanceSetting']['three_pointer_max_included'])
	&& is_numeric($original_data['BranchPerformanceSetting']['two_pointer_min']) && is_numeric($original_data['BranchPerformanceSetting']['two_pointer_max_included'])
	&& is_numeric($original_data['BranchPerformanceSetting']['one_pointer_min']) && is_numeric($original_data['BranchPerformanceSetting']['one_pointer_max_included'])
){
	$pointers_numeric = true;
} 
//-----------------------------------end of check if the pointers are numeric-------------------------------------------------------

			$this->Session->setFlash(__('The branch performance setting has been saved', true), '');
			$this->render('/elements/success');
		}
		
						if($id)
			$this->set('parent_id', $id);
		$positions = $this->BranchPerformanceSetting->Position->find('list');
		$this->set(compact('positions'));
	}

	function get_positions(){
		
		$this->loadModel('Position');
		
		//-----------------------------------------find the branches of that district-----------------------------------------------
		$positions_array = array();
		$positions_row = $this->Position->query("select * from positions  ");
		foreach($positions_row as $item){
			$positions_array[$item['positions']['id']] = $item['positions']['name']." (".$item['positions']['id'].")";
		}
		//--------------------------------------------end of the branches of that district-------------------------------------------

		return $positions_array;


	}


	function get_start_end_date( $from_date, $to_date, $q){

		
         $dates_array = array();
		$year_only_from = date('Y', strtotime($from_date));
	   $year_only_to = date('Y', strtotime($to_date));

		if($q == 1){
			$quarter_start_date = $year_only_from."-07-01";
			$quarter_end_date = $year_only_from."-09-30";
		}
		if($q == 2){
			$quarter_start_date = $year_only_from."-10-01";
			$quarter_end_date = $year_only_from."-12-31";
		}
		if($q == 3){
			$quarter_start_date = $year_only_to."-01-01";
			$quarter_end_date = $year_only_to."-03-31";
		}
		if($q == 4){
			$quarter_start_date = $year_only_to."-04-01";
			$quarter_end_date = $year_only_to."-06-30";
		}

		$start_date = date('Y-m-d', strtotime($quarter_start_date . ' - 10 days')); // for the new one marks the start
		$end_date = date('Y-m-d', strtotime($quarter_start_date . ' + 10 days'));  //for the previous one marks the end
		
   array_push($dates_array, $start_date);
   array_push($dates_array, $end_date);
   

        return $dates_array ;

}

function get_start_end_date2(){

	//find current date-------
//	$currentDate = date('Y-m-d');
 $currentDate = new DateTime();
 
 
	$year_only_date = date('Y', strtotime($currentDate->format('Y-m-d')));
//	$q = 1;

	if(strtotime($currentDate->format('Y-m-d')) >=  strtotime($year_only_date."-07-01") && strtotime($currentDate->format('Y-m-d')) <= strtotime($year_only_date."-09-30")){
	//	$q = 1;
		$quarter_start_date = $year_only_date."-07-01";
	   $quarter_end_date = $year_only_date."-09-30";
		
	}
	if(strtotime($currentDate->format('Y-m-d')) >= strtotime($year_only_date."-10-01") && strtotime($currentDate->format('Y-m-d')) <= strtotime($year_only_date."-12-31")) {
	//	$q = 2;
		$quarter_start_date = $year_only_date."-10-01";
	   $quarter_end_date = $year_only_date."-12-31";
	}
	if(strtotime($currentDate->format('Y-m-d')) >= strtotime($year_only_date."-01-01") && strtotime($currentDate->format('Y-m-d')) <= strtotime($year_only_date."-03-31")) {
	//	$q = 3;
		$quarter_start_date = $year_only_date."-01-01";
		$quarter_end_date = $year_only_date."-03-31";

	}
	if(strtotime($currentDate->format('Y-m-d')) >= strtotime($year_only_date."-04-01") && strtotime($currentDate->format('Y-m-d')) <= strtotime($year_only_date."-06-30")) {
	//	$q = 4;
		$quarter_start_date = $year_only_date."-04-01";
		$quarter_end_date = $year_only_date."-06-30";
	}
	
//	$dates_array = array();
//    $year_only_from = date('Y', strtotime($from_date));
//   $year_only_to = date('Y', strtotime($to_date));

//    if($q == 1){
// 	   $quarter_start_date = $year_only_from."-07-01";
// 	   $quarter_end_date = $year_only_from."-09-30";
//    }
//    if($q == 2){
// 	   $quarter_start_date = $year_only_from."-10-01";
// 	   $quarter_end_date = $year_only_from."-12-31";
//    }
//    if($q == 3){
// 	   $quarter_start_date = $year_only_to."-01-01";
// 	   $quarter_end_date = $year_only_to."-03-31";
//    }
//    if($q == 4){
// 	   $quarter_start_date = $year_only_to."-04-01";
// 	   $quarter_end_date = $year_only_to."-06-30";
//    }

//    $start_date = date('Y-m-d', strtotime($quarter_start_date . ' - 10 days')); // for the new one marks the start
    // $end_date = date('Y-m-d', strtotime($quarter_end_date . ' + 10 days'));  //for the previous one marks the end
    $end_date = date('Y-m-d', strtotime($quarter_start_date . ' + 10 days'));  //for the previous one marks the end
//    $dates_array.push($start_date);
//    $dates_array.push($end_date);

//    return $dates_array ;
		return $end_date;

}

// 	function get_each_quarter_position( $from_date, $to_date, $q){

// 		$this->loadModel('EmployeeDetail');

// 	$year_only_from = date('Y', strtotime($from_date));
// 	   $year_only_to = date('Y', strtotime($to_date));

// 		if($q == 1){
// 			$quarter_start_date = $year_only_from."-07-01";
// 			$quarter_end_date = $year_only_from."-09-30";
// 		}
// 		if($q == 2){
// 			$quarter_start_date = $year_only_from."-10-01";
// 			$quarter_end_date = $year_only_from."-12-31";
// 		}
// 		if($q == 3){
// 			$quarter_start_date = $year_only_to."-01-01";
// 			$quarter_end_date = $year_only_to."-03-31";
// 		}
// 		if($q == 4){
// 			$quarter_start_date = $year_only_to."-04-01";
// 			$quarter_end_date = $year_only_to."-06-30";
// 		}
  
 
// $position_id_for_quarter_row = array();
// 		$check_q_row =  $this->EmployeeDetail->query('select * from employee_details 
// where employee_id = '. $e_id .' and start_date <= "'. $quarter_end_date .'" order by start_date');
// if(count($check_q_row) > 0){  // this means the emp has worked in this quarter so now decide where he worked
// 	//-------------------are there any emp detail entries during this quarter---------------------------------------------
// 	$transition_date_row =  $this->EmployeeDetail->query('select * from employee_details 
// 	where employee_id = '. $e_id .' and start_date > "'. $quarter_start_date .'" and start_date < "'.$quarter_end_date.'" order by start_date');
// 	//------------------end of are there any emp detail entries during this quarter---------------------------------------
	
// 	if(count($transition_date_row) > 0){ // means there have been transitions(in this case we have to decide where)----------------------------------------------
// 	  $max_date_worked = 0; //
// 	  $max_worked_id = 0;
// 	  $initial_date = $quarter_start_date;
// 	  foreach($transition_date_row as $index => $value){  //subtract quarter start date from the transition date

	
// 			if($index == (count($transition_date_row)-1)){ //common case if it is zero
// 				$num_days1 = strtotime($value['employee_details']['start_date']) - strtotime($initial_date);
// 				$num_days2 = strtotime($quarter_end_date) - strtotime($value['employee_details']['start_date']) ;
// 				if($num_days1 >= $max_date_worked || $num_days2 >= $max_date_worked){
// 					if($num_days1 > $num_days2){

// 						$position_id_for_quarter_row = $this->EmployeeDetail->query('select * from employee_details 
// 						where employee_id = '. $e_id .' and start_date < "'. $value['employee_details']['start_date'].'" order by start_date desc' );
					
// 					}
// 					else {
// 						$position_id_for_quarter_row = $this->EmployeeDetail->query('select * from employee_details 
// 						where employee_id = '. $e_id .' and start_date <= "'. $value['employee_details']['start_date'].'" order by start_date desc' );
// 					}
// 				}
				
// 			} else {//
// 				$num_days = strtotime($value['employee_details']['start_date']) - strtotime($initial_date);
// 				if($num_days >= $max_date_worked){
// 					$position_id_for_quarter_row = $this->EmployeeDetail->query('select * from employee_details 
// 				where employee_id = '. $e_id .' and start_date < "'. $value['employee_details']['start_date'].'" order by start_date desc' );
// 				   $max_date_worked = $num_days;
				   
// 				}

// 				$initial_date = $value['employee_details']['start_date'];
// 			}
							  
// 	  }
// 	}
// 	else { // there has been no transitions
// 		$position_id_for_quarter_row = $this->EmployeeDetail->query('select * from employee_details 
// 		where employee_id = '. $e_id .' and start_date <= "'. $quarter_start_date.'" order by start_date desc' );
// 	}

// }
// else { //means everything is zero for this quarter b/se the emp hasn't be hired yet
// 	//----------------------------- the emp hasn't been hired just return an empty array--------------------------------------------------------
// 		$position_id_for_quarter_row = $this->EmployeeDetail->query('select * from employee_details 
// 		where employee_id = -1 order by start_date' );
// }

// return $position_id_for_quarter_row;

// }

	function add($id = null) {
		if (!empty($this->data)) {
			$original_data = $this->data;
			//the new setting------------------------------------------------------
			$effective_budget_year_id = $original_data['BranchPerformanceSetting']['start_budget_year_id'];
			$effective_quarter = $original_data['BranchPerformanceSetting']['start_quarter'];
			$this->loadModel('BudgetYear');
	$conditions3 = array('BudgetYear.id' => $effective_budget_year_id );
	$hoBudgetYear = $this->BudgetYear->find('first', array('conditions' => $conditions3));
	
	//find out if it is branch or not--------------------------------------------------------------------------
	$from_date = $hoBudgetYear['BudgetYear']['from_date'];
	$to_date = $hoBudgetYear['BudgetYear']['to_date'];

	$start_end_date_array = $this->get_start_end_date($from_date, $to_date, $effective_quarter);
			
	$start_date = $start_end_date_array[0];
	$end_date = $start_end_date_array[1];

			//---------end of the new setting------------------------------------------------

		
			$this_weight = $original_data['BranchPerformanceSetting']['weight'];
			$position = $original_data['BranchPerformanceSetting']['position_id'];
			$goal = str_replace("'", "`", $original_data['BranchPerformanceSetting']['goal']);
			$measure = str_replace("'", "`", $original_data['BranchPerformanceSetting']['measure']);
			$target = str_replace("'", "`", $original_data['BranchPerformanceSetting']['target']);

			$original_data['BranchPerformanceSetting']['goal'] = str_replace(",", "", $goal);
			$original_data['BranchPerformanceSetting']['measure'] = str_replace(",", "", $measure);
			$original_data['BranchPerformanceSetting']['target'] = str_replace(",", "", $target);
			$original_data['BranchPerformanceSetting']['is_active'] = 1;
			$original_data['BranchPerformanceSetting']['start_date'] = $start_date;
      
      $goal = str_replace(",", "", $goal);
			$measure = str_replace(",", "", $$measure);
			$target = str_replace(",", "", $target);

//---------------------------------------------check for duplicate------------------------------------------------------------------
			$goal_row = $this->BranchPerformanceSetting->query("select * from branch_performance_settings 
			where position_id = ".$position." and goal = '".$goal."' and measure = '".$measure."' 
			and target = '".$target."' order by id asc ");
//---------------------------------------------end of check for duplicates----------------------------------------------------------
//--------------------------------------check if the pointers are numeric-----------------------------------------------------------
		$pointers_numeric = false;

    if(is_numeric($original_data['BranchPerformanceSetting']['five_pointer_min']) && is_numeric($original_data['BranchPerformanceSetting']['five_pointer_max_included'])
		&& is_numeric($original_data['BranchPerformanceSetting']['four_pointer_min']) && is_numeric($original_data['BranchPerformanceSetting']['four_pointer_max_included'])
		&& is_numeric($original_data['BranchPerformanceSetting']['three_pointer_min']) && is_numeric($original_data['BranchPerformanceSetting']['three_pointer_max_included'])
		&& is_numeric($original_data['BranchPerformanceSetting']['two_pointer_min']) && is_numeric($original_data['BranchPerformanceSetting']['two_pointer_max_included'])
		&& is_numeric($original_data['BranchPerformanceSetting']['one_pointer_min']) && is_numeric($original_data['BranchPerformanceSetting']['one_pointer_max_included'])
	){
		$pointers_numeric = true;
	} 
//-----------------------------------end of check if the pointers are numeric-------------------------------------------------------


		if(is_numeric($this_weight)){
//-------------------------------------------------find weight sum-----------------------------------------------------------------------
			
			$total_weight = $this_weight;
			// $weight_row = $this->BranchPerformanceSetting->query("select sum(weight) as sum_weight from branch_performance_settings
			// where position_id = ".$position." ");
			// $sum_weight = $weight_row[0][0]['sum_weight'];
			// if($sum_weight != null) {
			// 	$total_weight +=  $sum_weight;
			// }
			// else {
			// 	$total_weight = $this_weight;
			// }
			$total_weight += $this->get_total_weight( $budget_year_id, $q, $position_id);
			if(count($goal_row) > 0 ){
				if($goal_row[0][0]['end_date'] == NULL){
					$total_weight -= $goal_row[0][0]["weight"];
				}
				
			}
            
//---------------------------------------------end of find weight sum--------------------------------------------------------------------
		if($pointers_numeric){

			

			if($total_weight <= 100){

				
               $overlapping_validation = false;
				if(count($goal_row) == 0){ //it does not exist
				
					//do nothing just register it
				   }	
			
				   else {

					//-------------------check if overlapping--------------------------------------------------
					
					if($goal_row[0][0]['end_date'] != NULL ){
						$past_end_date = new DateTime($goal_row[0][0]['end_date']);
						$new_start_date = new DateTime($start_date);
						if($past_end_date->diff($new_start_date) > 30  ){  // normally the different is 20 days. the 10 days is just for safety
							$overlapping_validation = true;
						}
					
					}
 
				 //--------------------------end of if overlapping-------------------------------------
				 if($overlapping_validation == false){
					$update_previous_row = $this->BranchPerformanceSetting->query("update branch_performance_settings set end_date = '".$end_date."'
				where position_id = ".$position." and end_date is NULL and goal = '".$goal."' and measure = '".$measure."' 
				and target = '".$target."' ");
				 }
					// $this->Session->setFlash(__('the plan already exists!', true), '');
					// $this->render('/elements/failure3');
				   }

if($overlapping_validation == false){
	$this->BranchPerformanceSetting->create();
				$this->autoRender = false;
			//	if ($this->BranchPerformanceSetting->save($this->data)) {
				if ($this->BranchPerformanceSetting->save($original_data)) {
					$this->Session->setFlash(__('The branch performance setting has been saved', true), '');
					$this->render('/elements/success');
				} else {
					$this->Session->setFlash(__('The branch performance setting could not be saved. Please, try again.', true), '');
					$this->render('/elements/failure');
				}
}
else {
	$this->Session->setFlash(__('There is an overlapping setting for this setting!', true), '');
	$this->render('/elements/failure3');
}
			
			}

			else {

				$this->Session->setFlash(__('Weight cannot exceed 100!', true), '');
				$this->render('/elements/failure3');
			}
			
		
		
			}
			else {
				$this->Session->setFlash(__('The ratings must be numeric!', true), '');
				$this->render('/elements/failure3');
			}
		}	
			else {
			$this->Session->setFlash(__('Weight must be numeric!', true), '');
			$this->render('/elements/failure3');
		}
           	
		}
		if($id)
			$this->set('parent_id', $id);
			$positions = $this->get_positions();
		//$positions = $this->BranchPerformanceSetting->Position->find('list');
		$this->loadModel('BudgetYear');
		$budget_years = $this->BudgetYear->find('list');
		$this->set(compact('positions' , 'budget_years'));
	}

	function edit($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid branch performance setting', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {

			$original_data = $this->data;

		//---------the new setting------------------------------------------------------
				$effective_budget_year_id = $original_data['BranchPerformanceSetting']['start_budget_year_id'];
				$effective_quarter = $original_data['BranchPerformanceSetting']['start_quarter'];
				$this->loadModel('BudgetYear');
		$conditions3 = array('BudgetYear.id' => $effective_budget_year_id );
		$hoBudgetYear = $this->BudgetYear->find('first', array('conditions' => $conditions3));
		
		//find out if it is branch or not--------------------------------------------------------------------------
		$from_date = $hoBudgetYear['BudgetYear']['from_date'];
		$to_date = $hoBudgetYear['BudgetYear']['to_date'];
	
		$start_end_date_array = $this->get_start_end_date($from_date, $to_date, $effective_quarter);
				
		$start_date = $start_end_date_array[0];
		$end_date = $start_end_date_array[1];
	
				//---------end of the new setting------------------------------------------------
			$id = $original_data['BranchPerformanceSetting']['id'];
			$this_weight = $original_data['BranchPerformanceSetting']['weight'];
			$position = $original_data['BranchPerformanceSetting']['position_id'];
			$goal = str_replace("'", "`", $original_data['BranchPerformanceSetting']['goal']);
			$measure = str_replace("'", "`", $original_data['BranchPerformanceSetting']['measure']);
			$target = str_replace("'", "`", $original_data['BranchPerformanceSetting']['target']);

			$original_data['BranchPerformanceSetting']['goal'] = str_replace(",", "", $goal);
			$original_data['BranchPerformanceSetting']['measure'] = str_replace(",", "", $$measure);
			$original_data['BranchPerformanceSetting']['target'] = str_replace(",", "", $target);
      
      $goal = str_replace(",", "", $goal);
			$measure = str_replace(",", "", $$measure);
			$target = str_replace(",", "", $target);
      
		//	$original_data['BranchPerformanceSetting']['is_active'] = 1;

		//---------------------------------------------check for duplicate------------------------------------------------------------------
			$goal_row = $this->BranchPerformanceSetting->query("select * from branch_performance_settings 
			where position_id = ".$position." and goal = '".$goal."' and measure = '".$measure."' 
			and target = '".$target."' and id < ".$id. " order by id asc");
		//---------------------------------------------end of check for duplicates----------------------------------------------------------

		//--------------------------------------check if the pointers are numeric-----------------------------------------------------------
				$pointers_numeric = false;

			if(is_numeric($original_data['BranchPerformanceSetting']['five_pointer_min']) && is_numeric($original_data['BranchPerformanceSetting']['five_pointer_max_included'])
				&& is_numeric($original_data['BranchPerformanceSetting']['four_pointer_min']) && is_numeric($original_data['BranchPerformanceSetting']['four_pointer_max_included'])
				&& is_numeric($original_data['BranchPerformanceSetting']['three_pointer_min']) && is_numeric($original_data['BranchPerformanceSetting']['three_pointer_max_included'])
				&& is_numeric($original_data['BranchPerformanceSetting']['two_pointer_min']) && is_numeric($original_data['BranchPerformanceSetting']['two_pointer_max_included'])
				&& is_numeric($original_data['BranchPerformanceSetting']['one_pointer_min']) && is_numeric($original_data['BranchPerformanceSetting']['one_pointer_max_included'])
			){
				$pointers_numeric = true;
			} 
		//-----------------------------------end of check if the pointers are numeric-------------------------------------------------------

		if(is_numeric($this_weight)){
//-------------------------------------------------find weight sum-----------------------------------------------------------------------
			
			 $total_weight = $this_weight;
			// $weight_row = $this->BranchPerformanceSetting->query("select sum(weight) as sum_weight from branch_performance_settings
			// where position_id = ".$position." and id != ". $id);
			// $sum_weight = $weight_row[0][0]['sum_weight'];
			// if($sum_weight != null) {
			// 	$total_weight +=  $sum_weight;
			// }
			// else {
			// 	$total_weight = $this_weight;
			// }

 $total_weight += $this->get_total_weight( $budget_year_id, $q, $position_id);
					if(count($goal_row) > 0 ){
						if($goal_row[0][0]['end_date'] == NULL){
							$total_weight -= $goal_row[0][0]["weight"];
						}
						
					}
//---------------------------------------------end of find weight sum--------------------------------------------------------------------
$overlapping_validation = false;
				if($pointers_numeric) {


				//	if(count($goal_row) == 0){
						if($total_weight <= 100){

			

							if(count($goal_row) > 0){

								
					//-------------------check if overlapping--------------------------------------------------
					
					if($goal_row[0][0]['end_date'] != NULL ){
						$past_end_date = new DateTime($goal_row[0][0]['end_date']);
						$new_start_date = new DateTime($start_date);
						if($past_end_date->diff($new_start_date) > 30  ){  // normally the different is 20 days. the 10 days is just for safety
							$overlapping_validation = true;
						}
					
					}
 
				 //--------------------------end of if overlapping-------------------------------------
				 if($overlapping_validation == false){
					$update_previous_row = $this->BranchPerformanceSetting->query("update branch_performance_settings set end_date = '".$end_date."'
					where position_id = ".$position." and end_date is NULL and goal = '".$goal."' and measure = '".$measure."' 
					and target = '".$target."' ");
				 }

								
							}

							if($overlapping_validation == false){
								//----------------------we have to reset the previous change made to the previous setting---------------
							$goal_row2 = $this->BranchPerformanceSetting->query("select * from branch_performance_settings 
							where id = ".$id);

							$goal_row3 = $this->BranchPerformanceSetting->query("select * from branch_performance_settings 
			where position_id = ".$goal_row2[0][0]["position_id"]." and goal = '".$goal_row2[0][0]["goal"]."' and measure = '".$goal_row2[0][0]["measure"]."' 
			and target = '".$goal_row2[0][0]["target"]."' and id < ".$id. " order by id asc");

			if(count($goal_row3) > 0){
				$goal_row4 = $this->BranchPerformanceSetting->query("update branch_performance_settings set end_date = NULL  
				where id = ".$goal_row3[0][0]["target"]);
			}
	//----------------------end of we have to reset the previous change made to the previous setting---------------
	$this->autoRender = false;
							if ($this->BranchPerformanceSetting->save($this->data)) {
								$this->Session->setFlash(__('The branch performance setting has been saved', true), '');
								$this->render('/elements/success');
							} else {
								$this->Session->setFlash(__('The branch performance setting could not be saved. Please, try again.', true), '');
								$this->render('/elements/failure');
							}

							}
							else {
								$this->Session->setFlash(__('There is an overlapping setting !', true), '');
							$this->render('/elements/failure3');

								
							}

							
						} else {
							$this->Session->setFlash(__('Weight cannot exceed 100!', true), '');
							$this->render('/elements/failure3');
						}
						
					// }else{
					// 	$this->Session->setFlash(__('the plan already exists!', true), '');
					// 	$this->render('/elements/failure3');
					// }
					
				}
				else {
					$this->Session->setFlash(__('The ratings must be numeric!', true), '');
					$this->render('/elements/failure3');
				}

			

		 } else {
			$this->Session->setFlash(__('Weight must be numeric!', true), '');
			$this->render('/elements/failure3');
		}

			
		}
		$this->set('branch_performance_setting', $this->BranchPerformanceSetting->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			$positions = $this->get_positions();
		//$positions = $this->BranchPerformanceSetting->Position->find('list');
		$this->loadModel('BudgetYear');
		$budget_years = $this->BudgetYear->find('list');
		$this->set(compact('positions', 'budget_years'));

	}

	function close_setting($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ho performance plan', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$original_data = $this->data;
			$id = $original_data['BranchPerformanceSetting']['id'];

			$end_date = $this->get_start_end_date2();

			$goal_row = $this->BranchPerformanceSetting->query("select * from branch_performance_settings 
			where end_date is NULL and id = ".$id);

            if(count($goal_row) > 0){
				$update_previous_row = $this->BranchPerformanceSetting->query("update branch_performance_settings set end_date = '".$end_date."'
								where id = ".$id);
							$this->Session->setFlash(__('The setting has been closed successfully'. $id, true), '');
				$this->render('/elements/success');

			}
			else {
				$this->Session->setFlash(__('The setting is already closed!', true), '');
			$this->render('/elements/failure3');

			}

	
		}
		
		$this->set('branch_performance_setting', $this->BranchPerformanceSetting->read(null, $id));
		
	}
	function edit2($id = null, $parent_id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid branch performance setting', true), '');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$original_data = $this->data;
			$id = $original_data['BranchPerformanceSetting']['id'];
			$this_weight = $original_data['BranchPerformanceSetting']['weight'];
			$position = $original_data['BranchPerformanceSetting']['position_id'];
			$goal = str_replace("'", "`", $original_data['BranchPerformanceSetting']['goal']);
			$measure = str_replace("'", "`", $original_data['BranchPerformanceSetting']['measure']);
			$target = str_replace("'", "`", $original_data['BranchPerformanceSetting']['target']);

			$original_data['BranchPerformanceSetting']['goal'] = $goal;
			$original_data['BranchPerformanceSetting']['measure'] = $measure;
			$original_data['BranchPerformanceSetting']['target'] = $target;
		//	$original_data['BranchPerformanceSetting']['is_active'] = 1;

			$this->Session->setFlash(__('The branch performance setting has been saved', true), '');
			$this->render('/elements/success');

			
		}

		$this->set('branch_performance_setting', $this->BranchPerformanceSetting->read(null, $id));
		
		if($parent_id) {
			$this->set('parent_id', $parent_id);
		}
			
		$positions = $this->BranchPerformanceSetting->Position->find('list');
		$this->set(compact('positions'));

	}

	function delete($id = null) {
		$this->autoRender = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for branch performance setting', true), '');
			$this->render('/elements/failure');
		}
		if (stripos($id, '_') !== false) {
            $ids = explode('_', $id);
            try{
                foreach ($ids as $i) {
                    $this->BranchPerformanceSetting->delete($i);
                }
				$this->Session->setFlash(__('Branch performance setting deleted', true), '');
				$this->render('/elements/success');
            }
            catch (Exception $e){
				$this->Session->setFlash(__('Branch performance setting was not deleted', true), '');
				$this->render('/elements/failure');
            }
        } else {
            if ($this->BranchPerformanceSetting->delete($id)) {
				$this->Session->setFlash(__('Branch performance setting deleted', true), '');
				$this->render('/elements/success');
			} else {
				$this->Session->setFlash(__('Branch performance setting was not deleted', true), '');
				$this->render('/elements/failure');
			}
        }
	}
}
?>
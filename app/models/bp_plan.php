<?php
class BpPlan extends AppModel {
	var $name = 'BpPlan';
	var $validate = array(
		'branch_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'month' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'bp_item_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'budget_year_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Branch' => array(
			'className' => 'Branch',
			'foreignKey' => 'branch_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'BpItem' => array(
			'className' => 'BpItem',
			'foreignKey' => 'bp_item_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'BudgetYear' => array(
			'className' => 'BudgetYear',
			'foreignKey' => 'budget_year_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'BpMonth' => array(
			'className' => 'BpMonth',
			'foreignKey' => 'bp_month_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>
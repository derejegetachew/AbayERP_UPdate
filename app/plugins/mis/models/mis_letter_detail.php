<?php
class MisLetterDetail extends AppModel {
	var $name = 'MisLetterDetail';
	var $validate = array(
		'mis_letter_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'type' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'account_of' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'account_number' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'branch_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'status' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'created_by' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'replied_by' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'completed_by' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'letter_prepared_by' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'released_by' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'MisLetter' => array(
			'className' => 'MisLetter',
			'foreignKey' => 'mis_letter_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Branch' => array(
			'className' => 'Branch',
			'foreignKey' => 'branch_id',  // Corrected foreignKey
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CreatedUser' => array(
			'className' => 'User',
			'foreignKey' => 'created_by',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'RepliedUser' => array(
			'className' => 'User',
			'foreignKey' => 'replied_by',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CompletedUser' => array(
			'className' => 'User',
			'foreignKey' => 'completed_by',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'LetterPreparedUser' => array(
			'className' => 'User',
			'foreignKey' => 'letter_prepared_by',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ReleasedUser' => array(
			'className' => 'User',
			'foreignKey' => 'released_by',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>
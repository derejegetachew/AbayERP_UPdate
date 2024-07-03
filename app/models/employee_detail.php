<?php

class EmployeeDetail extends AppModel {

    var $name = 'EmployeeDetail';
    var $validate = array(
        'start_date' => array(
            'date' => array(
                'rule' => array('date'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
        ), 'notempty' => array(
                'rule' => array('notempty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ))
        , 'end_date' => array(
            'date' => array(
                'rule' => array('date'),
            //'message' => 'Your custom message here',
            'allowEmpty' => true,
            'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
        ))
    );
    //The Associations below have been created with all possible keys, those that are not needed can be removed

    var $belongsTo = array(
        'Employee' => array(
            'className' => 'Employee',
            'foreignKey' => 'employee_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Grade' => array(
            'className' => 'Grade',
            'foreignKey' => 'grade_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Step' => array(
            'className' => 'Step',
            'foreignKey' => 'step_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Position' => array(
            'className' => 'Position',
            'foreignKey' => 'position_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Branch' => array(
            'className' => 'Branch',
            'foreignKey' => 'branch_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

}

?>
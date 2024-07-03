<?php
/* Experience Fixture generated on: 2013-03-06 17:03:26 : 1362592106 */
class ExperienceFixture extends CakeTestFixture {
	var $name = 'Experience';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'employer' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'job_title' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'from_date' => array('type' => 'date', 'null' => false, 'default' => NULL),
		'to_date' => array('type' => 'date', 'null' => false, 'default' => NULL),
		'employee_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'indexes' => array(),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'employer' => 'Lorem ipsum dolor sit amet',
			'job_title' => 'Lorem ipsum dolor sit amet',
			'from_date' => '2013-03-06',
			'to_date' => '2013-03-06',
			'employee_id' => 1
		),
	);
}
?>
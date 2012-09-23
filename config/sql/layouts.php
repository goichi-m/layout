<?php 
/* SVN FILE: $Id$ */
/* LayoutChanges schema generated on: 2011-07-23 12:07:31 : 1311391891*/
class LayoutsSchema extends CakeSchema {
	var $name = 'Layouts';

	var $file = 'layouts.php';

	var $connection = 'plugin';

	function before($event = array()) {
		return true;
	}

	function after($event = array()) {
	}

	var $layouts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'page_categories_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'layout' => array('type' => 'text', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
}
?>
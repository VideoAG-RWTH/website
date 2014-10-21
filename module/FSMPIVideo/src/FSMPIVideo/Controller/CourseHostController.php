<?php
namespace FSMPIVideo\Controller;

class CourseHostController extends ListController
{
	public function __construct(){
		$params = array('list_columns' => array('Id' => 'id', 'Name' => 'name'));
		parent::__construct($params);
	}
}

<?php
namespace FSMPIVideo\Controller;

class LecturerController extends ListController
{
	public function __construct(){
		$params = array('list_columns' => array('Id' => 'id', 'Name' => 'name', 'Email' => 'email'));
		parent::__construct($params);
	}
}

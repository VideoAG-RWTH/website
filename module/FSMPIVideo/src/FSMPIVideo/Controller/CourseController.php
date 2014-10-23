<?php
namespace FSMPIVideo\Controller;

class CourseController extends ListController
{
	public function __construct(){
		$params = array('list_columns' => array('Id' => 'id', 'Abbreviation' => 'abbreviation', 'Title' => 'title', 'Subject' => 'subject', 'Type' => 'typeName'));
		parent::__construct($params);
	}
}

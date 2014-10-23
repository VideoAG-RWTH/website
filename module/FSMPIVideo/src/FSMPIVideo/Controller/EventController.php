<?php
namespace FSMPIVideo\Controller;

class EventController extends ListController
{
	public function __construct(){
		$params = array('list_columns' => array('Id' => 'id', 'Title' => 'title', 'Date' => 'date', 'Place' => 'place'));
		parent::__construct($params);
	}
}

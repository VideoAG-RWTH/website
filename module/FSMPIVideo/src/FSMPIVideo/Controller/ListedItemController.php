<?php
namespace FSMPIVideo\Controller;

class ListedItemController extends ListController
{
	public function __construct(){
		$params = array('list_columns' => array('Id' => 'id', 'Title' => 'title'));
		parent::__construct($params);
	}
}

<?php
namespace FSMPIVideo\Controller;

class VideoQualityController extends ListController
{
	public function __construct(){
		$params = array('list_columns' => array('Id' => 'id', 'Name' => 'name', 'Height' => 'height'));
		parent::__construct($params);
	}
}

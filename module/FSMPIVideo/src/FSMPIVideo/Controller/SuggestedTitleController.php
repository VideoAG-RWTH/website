<?php
namespace FSMPIVideo\Controller;

class SuggestedTitleController extends ListController
{
	public function __construct(){
		$params = array(
			'list_columns' => array(
				'Id' => 'id', 
				'Suggested at' => 'suggestedAt', 
				'Suggested by' => 'suggestedBy', 
				'Listed Item' => 'listedItem', 
				'Title' => 'title', 
				'IsViewed' => 'isViewed', 
				'Viewed by' => 'viewedBy'
			)
		);
		parent::__construct($params);
	}
}

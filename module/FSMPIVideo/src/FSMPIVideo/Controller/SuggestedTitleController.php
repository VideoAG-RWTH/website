<?php
namespace FSMPIVideo\Controller;

class SuggestedTitleController extends ListController
{
	public function __construct(){
		$params = array(
			'list_columns' => array(
				'Id' => 'id', 
				'Suggested at' => 'suggested_at', 
				'Suggested by' => 'suggested_by', 
				'Listed Item' => 'listed_item', 
				'Title' => 'title', 
				'IsViewed' => 'is_viewed', 
				'Viewed by' => 'viewed_by'
			)
		);
		parent::__construct($params);
	}
}

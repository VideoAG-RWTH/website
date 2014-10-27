<?php
namespace FSMPIVideo\Controller;

class EventController extends ListedItemController
{
	public function __construct(){
		$params = array('list_columns' => array('Id' => 'id', 'Title' => 'title', 'Date' => 'date', 'Place' => 'place'));
		parent::__construct($params);
	}
	
	protected function getAll(){
		$em = $this->getEntityManager();
		$items = $em->getRepository("\\FSMPIVideo\\Entity\\Event")->findAll();
		$events = array();
		foreach($items as $item){
			if(empty($item->getSeriesAssociations()) || count($item->getSeriesAssociations()) == 0)
				$events[] = $item;
		}
		return $events;
	}
	
	protected function _preCreate($item){
		if(!$this->zfcUserAuthentication()->hasIdentity()){
			return;
		}
		
		$identity = $this->zfcUserAuthentication()->getIdentity();
		
		$item->setCreatedBy($identity);
		$item->setChangedBy($identity);
	}
	
	protected function _preUpdate($item){
		if(!$this->zfcUserAuthentication()->hasIdentity()){
			return;
		}
		
		$identity = $this->zfcUserAuthentication()->getIdentity();
		
		$item->setChangedBy($identity);
	}
}

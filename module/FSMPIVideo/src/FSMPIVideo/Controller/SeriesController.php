<?php
namespace FSMPIVideo\Controller;

use FSMPIVideo\Entity\Event;
use FSMPIVideo\Entity\SeriesEventAssociation;

class SeriesController extends ListedItemController
{
	public function __construct(){
		$params = array(
			'list_columns' => array('Id' => 'id', 'Title' => 'title', 'Course' => 'course', 'Super Admin' => 'superAdmin'),
			'subcreate_title' => 'Create new Event',
			'sublist_title' => 'Events',
			'subedit_title' => 'Edit Event',
			'sublist_route' => 'zfcadmin/series/events/list',
			'subcreate_route' => 'zfcadmin/series/events/create',
			'subedit_route' => 'zfcadmin/series/events/edit',
			'subdelete_route' => 'zfcadmin/series/events/delete',
			'subdelete_warning_text' => 'Really delete Event?',
			'subcreate_text' => 'New Event',
			'sublist_columns' => array('Id' => 'id', 'Title' => 'title', 'Date' => 'date', 'Place' => 'place'),
			'subdelete_param_name' => 'eventId',
			'subedit_param_name' => 'eventId',
			'sublist_parent_param_name' => 'id',
			'sublist_route' => 'zfcadmin/series/events/list',
			'sublist_link_name' => 'Events'
		);
		parent::__construct($params);
	}
	
	public function eventsAction(){
		$em = $this->getEntityManager();
		$id = $this->getEvent()->getRouteMatch()->getParam($this->params['sublist_parent_param_name']);
		
		$series = $em->getRepository("\\FSMPIVideo\\Entity\\Series")->find($id);
		if(!$series)
			return $this->_redirectToList();
		
		$eventAssociations = $series->getEventAssociations();
		$events = array();
		$currentOrderingEvents = array();
		$currentOrdering = null;
		foreach($eventAssociations as $association){
			if($currentOrdering === null || $currentOrdering != $association->getCustomOrder()){
				$events = array_merge($events, $currentOrderingEvents);
				$currentOrderingEvents = array();
				$currentOrdering = $association->getCustomOrder();
			}
			$event = $association->getEvent();
			$currentOrderingEvents[] = $event;
		}
		$events = array_merge($events, $currentOrderingEvents);
		
		$params = array(
			'title' => $this->params['sublist_title'],
			'list_route' => $this->params['sublist_route'],
			'create_route' => $this->params['subcreate_route'],
			'edit_route' => $this->params['subedit_route'],
			'delete_route' => $this->params['subdelete_route'],
			'delete_warning_text' => $this->params['subdelete_warning_text'],
			'create_text' => $this->params['subcreate_text'],
			'columns' => $this->params['sublist_columns'],
			'rows' => $events,
			'page_length' => $this->params['page_length'],
			'edit_param_name' => $this->params['subedit_param_name'],
			'delete_param_name' => $this->params['subdelete_param_name'],
			'parent_list_route' => $this->params['list_route'],
			'parent_param_name' => $this->params['sublist_parent_param_name'],
			'parent_id' => $series->getId(),
			'parent_alias' => $series->getAlias(),
		);
		return $this->_showList($params);
	}
	
	public function createEventAction(){
		$em = $this->getEntityManager();
        $request = $this->getRequest();

		$id = $this->getEvent()->getRouteMatch()->getParam($this->params['sublist_parent_param_name']);
		$series = $em->getRepository("\\FSMPIVideo\\Entity\\Series")->find($id);
		if(!$series)
			return $this->_redirectToList();

		$form = $this->getForm('Event');
		
		/** @var $request \Zend\Http\Request */
		if ($request->isPost()) {
			$event = new Event();
			if($this->_createItem($event, $form)){
				
				// Create Link between event and series
				$em->refresh($event);
				$association = new SeriesEventAssociation();
				$association->setEvent($event);
				$association->setSeries($series);
				$em->persist($association);
				$em->flush();
				
				$this->flashMessenger()->addSuccessMessage('The Event was created');
				return $this->redirect()->toRoute($this->params['sublist_route'], array('id' => $series->getId()));
			}
        } else {
			$formData = array(
				'isDownloadable' => $series->getIsDownloadable(),
				'isAccessable' => $series->getIsAccessable(),
				'isListed' => $series->getIsListed(),
				'accessType' => $series->getAccessType(),
				'superAdmin' => $series->getSuperAdmin()->getId(),
				'semester' => $series->getSemester(),
			);
			$form->setData($formData);
		}
		
		$params = array(
			'title' => $this->params['subcreate_title'],
			'list_route' => $this->params['sublist_route'],
			'create_route' => $this->params['subcreate_route'],
			'parent_param_name' => $this->params['sublist_parent_param_name'],
			'parent_id' => $series->getId(),
			'parent_alias' => $series->getAlias(),
			'form' => $form,
		);
		return $this->_showCreateForm($params);
	}
	
	
    public function editEventAction(){
		$em = $this->getEntityManager();
		
		$id = $this->getEvent()->getRouteMatch()->getParam($this->params['sublist_parent_param_name']);
		$series = $em->getRepository("\\FSMPIVideo\\Entity\\Series")->find($id);
		if(!$series)
			return $this->_redirectToList();
		
        $eventId = $this->getEvent()->getRouteMatch()->getParam($this->params['subedit_param_name']);
		
		$item = $em->getRepository("\\FSMPIVideo\\Entity\\Event")->find((int)$eventId);
		
        $form = $this->getForm('Event');

		if($this->_editItem($item, $form)){
            $this->flashMessenger()->addSuccessMessage('The Event was edited');
            return $this->redirect()->toRoute($this->params['sublist_route'], array($this->params['sublist_parent_param_name'] => $series->getId()));
		}

		$params = array(
			'title' => $this->params['subedit_title'],
			'list_route' => $this->params['sublist_route'],
			'edit_route' => $this->params['subedit_route'],
			'delete_route' => $this->params['subdelete_route'],
			'delete_warning_text' => $this->params['subdelete_warning_text'],
			'parent_param_name' => $this->params['sublist_parent_param_name'],
			'parent_id' => $series->getId(),
			'parent_alias' => $series->getAlias(),
            'form' => $form,
            'id' => $id
		);
		return $this->_showEditForm($params);
    }

    public function deleteEventAction(){
		$em = $this->getEntityManager();
		
		$id = $this->getEvent()->getRouteMatch()->getParam($this->params['sublist_parent_param_name']);
		$series = $em->getRepository("\\FSMPIVideo\\Entity\\Series")->find($id);
		if(!$series)
			return $this->_redirectToList();
	
        $eventId = $this->getEvent()->getRouteMatch()->getParam($this->params['subdelete_param_name']);
		
		if(!$eventId)
			return $this->_redirectToList();
		
		$item = $em->getRepository("\\FSMPIVideo\\Entity\\Event")->find((int)$eventId);
		
		if($this->_delteItem($item)){
			$em->remove($item);
			$em->flush();
	        $this->flashMessenger()->addSuccessMessage('The Event was deleted');
		}
        return $this->redirect()->toRoute($this->params['sublist_route'], array($this->params['sublist_parent_param_name'] => $series->getId()));
    }

	protected function _preCreate($item){
		if(!$this->zfcUserAuthentication()->hasIdentity()){
			return;
		}
		
		$identity = $this->zfcUserAuthentication()->getIdentity();
		
		$item->setCreatedBy($identity);
		$item->setChangedBy($identity);
		
		if($item instanceof Event){
			$id = $this->getEvent()->getRouteMatch()->getParam($this->params['sublist_parent_param_name']);
			$series = $em->getRepository("\\FSMPIVideo\\Entity\\Series")->find($id);
			if(!$series)
				return;
			
			$item->setSuperAdmin($series->getSuperAdmin());
		}
	}
	
	protected function _preUpdate($item){
		if(!$this->zfcUserAuthentication()->hasIdentity()){
			return;
		}
		
		$identity = $this->zfcUserAuthentication()->getIdentity();
		
		$item->setChangedBy($identity);
	}
}

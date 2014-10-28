<?php
namespace FSMPIVideo\Controller;

use Zend\View\Model\ViewModel;
use FSMPIVideo\Entity\Event;

class EventController extends ListedItemController
{
	public function __construct(){
		$params = array(
			'list_columns' => array('Id' => 'id', 'Title' => 'title', 'Date' => 'date', 'Place' => 'place'),
			'markerlist_title' => 'Markers',
			'markerlist_route' => 'zfcadmin/event/markers/list',
			'markerlist_columns' => array('Id' => 'id', 'Time' => 'time', 'Title' => 'title', 'Published' => 'isPublished'),
			'markerlist_parent_param_name' => 'id',
			'markeraccept_route' => 'zfcadmin/event/markers/accept',
			'markeraccept_param_name' => 'markerId',
			'markerdecline_route' => 'zfcadmin/event/markers/decline',
			'markerdecline_param_name' => 'markerId',
			// Videos
			'video_parent_param_name' => 'eventId',
			'videounassign_route' => 'zfcadmin/event/videos/unassign',
			'videounassign_param_name' => 'videoId',
		);
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
	
	public function listAction(){
		if(!$this->_authenticate()) return;
		$em = $this->getEntityManager();
		$items = $this->getAll();
		
		$params = array(
			'title' => $this->params['list_title'],
			'list_route' => $this->params['list_route'],
			'create_route' => $this->params['create_route'],
			'edit_route' => $this->params['edit_route'],
			'delete_route' => $this->params['delete_route'],
			'delete_warning_text' => $this->params['delete_warning_text'],
			'create_text' => $this->params['create_text'],
			'columns' => $this->params['list_columns'],
			'rows' => $items,
			'page_length' => $this->params['page_length'],
			'sublist_route' => $this->params['sublist_route'],
			'parent_param_name' => $this->params['sublist_parent_param_name'],
			'sublist_link_name' => $this->params['sublist_link_name'],
			'item_alias_name' => $this->params['item_alias_name'],
			'video_buttons' => array(
				array(
					'title' => 'Unassign',
					'route' => $this->params['videounassign_route'],
					'param_name' => $this->params['videounassign_param_name'],
				)
			),
		);
		$page = $this->getEvent()->getRouteMatch()->getParam('p');
		$params['page'] = $page;
	
		$view = new ViewModel($params);
		$view->setTemplate('fsmpi-video/series/events.phtml');
		return $view;
	}
	
	
	public function markersAction(){
		$em = $this->getEntityManager();
		$id = $this->getEvent()->getRouteMatch()->getParam($this->params['markerlist_parent_param_name']);
		
		$event = $em->getRepository("\\FSMPIVideo\\Entity\\Event")->find($id);
		if(!$event)
			return $this->_redirectToList();
		
		$markers = $event->getMarkers();
		$markers = $markers->toArray();
		
		$params = array(
			'title' => $this->params['markerlist_title'],
			'list_route' => $this->params['markerlist_route'],
			'columns' => $this->params['markerlist_columns'],
			'rows' => $markers,
			'page_length' => $this->params['page_length'],
			'parent_list_route' => $this->params['list_route'],
			'parent_param_name' => $this->params['markerlist_parent_param_name'],
			'parent_id' => $event->getId(),
			'parent_alias' => $event->getAlias(),
			'row_buttons' => array(
				array(
					'title' => 'Accept',
					'route' => $this->params['markeraccept_route'],
					'param_name' => $this->params['markeraccept_param_name']
				),
				array(
					'title' => 'Decline',
					'route' => $this->params['markerdecline_route'],
					'param_name' => $this->params['markerdecline_param_name'],
				)
			)
		);
		return $this->_showList($params);
	}
	
	public function acceptMarkerAction(){
		return $this->_acceptMarker(array(
			'markerlist_parent_param_name' => $this->params['markerlist_parent_param_name'],
			'markeraccept_param_name' => $this->params['markeraccept_param_name'],
		));
	}
	
	protected function _acceptMarker($params){
		$em = $this->getEntityManager();
		
		$id = $this->getEvent()->getRouteMatch()->getParam($params['markerlist_parent_param_name']);
		$event = $em->getRepository("\\FSMPIVideo\\Entity\\Event")->find($id);
		if(!$event)
			return $event->_redirectToList();
	
        $markerId = $this->getEvent()->getRouteMatch()->getParam($params['markeraccept_param_name']);
		
		if(!$markerId)
			return $this->_redirectToMarkerlist($event);
		
		$marker = $em->getRepository("\\FSMPIVideo\\Entity\\EventMarker")->find((int)$markerId);
		if(!$marker)
			return $this->_redirectToMarkerlist($event);
		
		$marker->setIsPublished(true);
		
		if($this->zfcUserAuthentication()->hasIdentity()){
			$identity = $this->zfcUserAuthentication()->getIdentity();
			$marker->setPublishedBy($identity);
		}
		$em->flush();
		
		$this->flashMessenger()->addSuccessMessage('The marker was accepted correctly');
		return $this->_redirectToMarkerlist($event);
	}
	
	public function declineMarkerAction(){
		return $this->_declineMarker(array(
			'markerlist_parent_param_name' => $this->params['markerlist_parent_param_name'],
			'markerdecline_param_name' => $this->params['markerdecline_param_name'],
		));
	}
	
	protected function _declineMarker($params){
		$em = $this->getEntityManager();

		$id = $this->getEvent()->getRouteMatch()->getParam($params['markerlist_parent_param_name']);
		$event = $em->getRepository("\\FSMPIVideo\\Entity\\Event")->find($id);
		if(!$event)
			return $this->_redirectToList();

        $markerId = $this->getEvent()->getRouteMatch()->getParam($params['markerdecline_param_name']);

		if(!$markerId)
			return $this->_redirectToMarkerlist($event);

		$marker = $em->getRepository("\\FSMPIVideo\\Entity\\EventMarker")->find((int)$markerId);
		if(!$marker)
			return $this->_redirectToMarkerlist($event);

		$marker->setIsPublished(false);

		if($this->zfcUserAuthentication()->hasIdentity()){
			$identity = $this->zfcUserAuthentication()->getIdentity();
			$marker->setPublishedBy($identity);
		}
		$em->flush();

		$this->flashMessenger()->addSuccessMessage('The marker was declined correctly');
		return $this->_redirectToMarkerlist($event);
	}
	
	protected function _redirectToMarkerlist($item){
        return $this->redirect()->toRoute($this->params['markerlist_route'], array($this->params['markerlist_parent_param_name'] => $item->getId(), 'alias' => $item->getAlias()));
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
		if($item instanceof Event){
			$item->setChangedBy($identity);
		}
		return parent::_preUpdate($item);
	}
	
	protected function _postUpdate($item){
		if(!$this->zfcUserAuthentication()->hasIdentity()){
			return;
		}
		$identity = $this->zfcUserAuthentication()->getIdentity();
		$script = new jsonRPCClient(self::scriptURL);
		
		try{
			$script->eventHasBeenEdited($identity->getId(), $item->getId());
		} catch (Exception $e){
	        $this->flashMessenger()->addErrorMessage('Script could not be notified');
		}
		
		return parent::_postUpdate($item);
	}
	
	
	public function assignVideo(){
		if(!$this->_authenticate()) return;
		$identity = $this->zfcUserAuthentication()->getIdentity();
		$script = new jsonRPCClient(self::scriptURL);

		$id = $this->getEvent()->getRouteMatch()->getParam($this->params['video_parent_param_name']);
		$event = $em->getRepository("\\FSMPIVideo\\Entity\\Event")->find($id);
		if(!$event)
			return $this->_redirectToList();
		
		if($request->isPost()){
			$data = $request->getPost();
			$filenames = $data['videos'];
			$success = true;
			foreach($filenames as $videoFilename){
				try{
					$success = $success && $script->assignVideoToEvent((int)$identity->getId(), $event->getId(), $videoFilename);
				} catch (Exception $e){
					$success = false;
				}
			}
			if($success)
				$this->flashMessenger()->addSuccessMessage('All videos assigned');
			else
				$this->flashMessenger()->addErrorMessage('Not all videos could be assigned');
            return $this->_redirectToSublist($series);
		}
		
		// TODO assign videos view
	}
	
	public function unassignVideo(){
		if(!$this->_authenticate()) return;
		$identity = $this->zfcUserAuthentication()->getIdentity();
		$script = new jsonRPCClient(self::scriptURL);

		$id = $this->getEvent()->getRouteMatch()->getParam($this->params['video_parent_param_name']);
		$event = $em->getRepository("\\FSMPIVideo\\Entity\\Event")->find($id);
		if(!$event)
			return $this->_redirectToList();

		$videoId = $this->getEvent()->getRouteMatch()->getParam($this->params['videounassign_param_name']);
		$video = $em->getRepository("\\FSMPIVideo\\Entity\\Video")->find($videoId);
		if(!$video)
            return $this->_redirectToSublist($series);
		
		try{
			$res = $script->unassignVideoFromEvent($identity->getId(), $video->getId());
			$this->flashMessenger()->addSuccessMessage('Video successfully unassigned');
		} catch (Exception $e){
			$this->flashMessenger()->addErrorMessage('Video could not be unassigned');
		}
        return $this->_redirectToSublist($series);
	}
	
	
}

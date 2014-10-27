<?php
namespace FSMPIVideo\Controller;

class ListedItemController extends ListController
{
	public function __construct($params){
		$baseRoute = 'zfcadmin/'.strtolower($this->getName()).'/titles';
		if(empty($params['titlelist_route']) && !empty($params['list_route']))
			$baseRoute = preg_replace('/\/list$/', '/titles', $params['list_route']);
		
		$default = array(
			'list_columns' => array('Id' => 'id', 'Title' => 'title'),
			'titlelist_title' => 'Suggested Titles',
			'titlelist_columns' => array('Id' => 'id', 'Date' => 'suggestedAt', 'Title' => 'title', 'Viewed' => 'isViewed'),
			'titlelist_pagelength' => 10,
			'titlelist_parent_param_name' => 'id',
			'titlelist_route' => $baseRoute."/list",
			'titleaccept_route' => $baseRoute."/accept",
			'titleaccept_param_name' => 'titleId',
			'titledecline_route' => $baseRoute."/decline",
			'titledecline_param_name' => 'titleId',
		);
		$params = $params + $default;
		parent::__construct($params);
	}
	
	
	public function listAction(){
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
			'row_buttons' => array(
				array(
					'title' => 'Titles',
					'route' => $this->params['titlelist_route'],
					'param_name' => $this->params['titlelist_parent_param_name'],
				)
			)
			
		);
		return $this->_showList($params);
	}
	
	
	public function titlesAction(){
		$em = $this->getEntityManager();
		$id = $this->getEvent()->getRouteMatch()->getParam($this->params['titlelist_parent_param_name']);
		
		$item = $em->getRepository("\\FSMPIVideo\\Entity\\ListedItem")->find($id);
		if(!$item)
			return $this->_redirectToList();
		
		$titles = $item->getSuggestedTitles();
		$titles = $titles->toArray();
		
		$params = array(
			'title' => $this->params['titlelist_title'],
			'list_route' => $this->params['titlelist_route'],
			'columns' => $this->params['titlelist_columns'],
			'rows' => $titles,
			'page_length' => $this->params['page_length'],
			'parent_list_route' => $this->params['list_route'],
			'parent_param_name' => $this->params['sublist_parent_param_name'],
			'parent_id' => $item->getId(),
			'parent_alias' => $item->getAlias(),
			'row_buttons' => array(
				array(
					'title' => 'Accept',
					'route' => $this->params['titleaccept_route'],
					'param_name' => $this->params['titleaccept_param_name']
				),
				array(
					'title' => 'Decline',
					'route' => $this->params['titledecline_route'],
					'param_name' => $this->params['titledecline_param_name'],
				)
			)
		);
		return $this->_showList($params);
	}
	
	public function acceptTitleAction(){
		return $this->_acceptTitle(array(
			'titlelist_parent_param_name' => $this->params['titlelist_parent_param_name'],
			'titleaccept_param_name' => $this->params['titleaccept_param_name'],
		));
	}
	
	protected function _acceptTitle($params){
		$em = $this->getEntityManager();
		
		$id = $this->getEvent()->getRouteMatch()->getParam($params['titlelist_parent_param_name']);
		$item = $em->getRepository("\\FSMPIVideo\\Entity\\ListedItem")->find($id);
		if(!$item)
			return $this->_redirectToList();
	
        $titleId = $this->getEvent()->getRouteMatch()->getParam($params['titleaccept_param_name']);
		
		if(!$titleId)
			return $this->_redirectToTitlelist($item);
		
		$title = $em->getRepository("\\FSMPIVideo\\Entity\\SuggestedTitle")->find((int)$titleId);
		if(!$title)
			return $this->_redirectToTitlelist($item);
		
		$item->setTitle($title->getTitle());
		$title->setIsViewed(true);
		
		if($this->zfcUserAuthentication()->hasIdentity()){
			$identity = $this->zfcUserAuthentication()->getIdentity();
			$title->setViewedBy($identity);
			$item->setChangedBy($identity);
		}
		$em->flush();
		
		$this->flashMessenger()->addSuccessMessage('The title was accepted correctly');
		return $this->_redirectToTitlelist($item);
	}
	
	public function declineTitleAction(){
		return $this->_declineTitle(array(
			'titlelist_parent_param_name' => $this->params['titlelist_parent_param_name'],
			'titledecline_param_name' => $this->params['titledecline_param_name'],
		));
	}
	
	protected function _declineTitle($params){
		$em = $this->getEntityManager();

		$id = $this->getEvent()->getRouteMatch()->getParam($params['titlelist_parent_param_name']);
		$item = $em->getRepository("\\FSMPIVideo\\Entity\\ListedItem")->find($id);
		if(!$item)
			return $this->_redirectToList();

        $titleId = $this->getEvent()->getRouteMatch()->getParam($params['titledecline_param_name']);

		if(!$titleId)
			return $this->_redirectToTitlelist($item);

		$title = $em->getRepository("\\FSMPIVideo\\Entity\\SuggestedTitle")->find((int)$titleId);
		if(!$title)
			return $this->_redirectToTitlelist($item);

		$title->setIsViewed(true);

		if($this->zfcUserAuthentication()->hasIdentity()){
			$identity = $this->zfcUserAuthentication()->getIdentity();
			$title->setViewedBy($identity);
		}
		$em->flush();

		$this->flashMessenger()->addSuccessMessage('The title was declined correctly');
		return $this->_redirectToTitlelist($item);
	}
	
	protected function _redirectToTitlelist($item){
        return $this->redirect()->toRoute($this->params['titlelist_route'], array($this->params['titlelist_parent_param_name'] => $item->getId(), 'alias' => $item->getAlias()));
	}
}

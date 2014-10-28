<?php
namespace FSMPIVideo\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Stdlib\Hydrator\ClassMethods;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject;

abstract class ListController extends AbstractActionController
{
	/**
	 * @var Doctrine\ORM\EntityManager
	 */
	protected $em;
	
	protected $params;
	
	/**
	 * 
	 */
	public function __construct($params){
		$name = $this->getName();
		
		$defaults = array(
			'list_title' => $name.'s',
			'edit_title' => 'Edit ' . $name,
			'create_title' => 'Create ' . $name,
			'list_route' => 'zfcadmin/'.strtolower($name).'/list',
			'create_route' => 'zfcadmin/'.strtolower($name).'/create',
			'edit_route' => 'zfcadmin/'.strtolower($name).'/edit',
			'delete_route' => 'zfcadmin/'.strtolower($name).'/delete',
			'delete_warning_text' => 'Really delete '.$name.'?',
			'create_text' => 'Add new '.$name,
			'list_columns' => array('Id' => 'id'),
			'page_length' => 10,
			'delete_param_name' => 'id',
			'edit_param_name' => 'id',
			'id_name' => 'id',
			'sublist_route' => '',
			'sublist_parent_param_name' => '',
			'sublist_link_name' => '',
			'item_alias_name' => 'alias',
		);
		
		$this->params = $params + $defaults;
	}
	
	protected function getName(){
		$classname = get_class($this);
		
		$parts = explode("\\", $classname);
		$classname = $parts[count($parts) - 1];
		
		$classname = preg_replace('/ListController$/', '', $classname);
		$classname = preg_replace('/Controller$/', '', $classname);
		
		if(empty($classname))
			throw new \Exception('Empty name');
		return $classname;
	}
	
	protected function str_lreplace($search, $replace, $subject){
		$pos = strrpos($subject, $search);
		if($pos !== false){
			$subject = substr_replace($subject, $replace, $pos, strlen($search));
		}
		return $subject;
	}
		
	protected function getAll(){
		$em = $this->getEntityManager();
		$name = $this->getName();
		$items = $em->getRepository("\\FSMPIVideo\\Entity\\".$name)->findAll();
		return $items;
	}
	
	protected function getItem($id = null){
		$em = $this->getEntityManager();
		$name = "\\FSMPIVideo\\Entity\\".$this->getName();
		if($id)
			$item = $em->getRepository($name)->find((int)$id);
		else
			$item = new $name();
		return $item;
	}
	
	public function setEntityManager(EntityManager $em){
		$this->em = $em;
	}

	public function getEntityManager(){
		if (null === $this->em) {
			$this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		}
		return $this->em;
	}
	
	protected function getForm($name = null){
		if(!$name)
			$name = $this->getName();
		$em = $this->getEntityManager();
		$frmCls = '\\FSMPIVideo\\Form\\'.$name.'Form';
		$form = new $frmCls($em);
        $form->setHydrator(new DoctrineObject($em));
		return $form;
	}
	
	public function indexAction(){
		return $this->_redirectToList();
	}
	
	public function _redirectToList(){
		return $this->redirect()->toRoute($this->params['list_route']);
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
		);
		return $this->_showList($params);
	}
	
	protected function _showList($params){
		$page = $this->getEvent()->getRouteMatch()->getParam('p');
		$params['page'] = $page;
		
		$view = new ViewModel($params);
		$view->setTemplate('partial/admin_list.phtml');
		return $view;
	}
	
	public function createAction(){
		if(!$this->_authenticate()) return;
		$em = $this->getEntityManager();
		$form = $this->getForm();
        $request = $this->getRequest();
		
        /** @var $request \Zend\Http\Request */
        if ($request->isPost()) {
			$item = $this->getItem();
			if($this->_createItem($item, $form)){
				$this->flashMessenger()->addSuccessMessage('The '.$this->getName().' was created');
				return $this->redirect()->toRoute($this->params['list_route']);
			}
        }
		$params = array(
			'title' => $this->params['create_title'],
			'list_route' => $this->params['list_route'],
			'create_route' => $this->params['create_route'],
			'form' => $form,
		);
		return $this->_showCreateForm($params);
	}
	
	protected function _preCreate($item){
		return;
	}
	
	protected function _postCreate($item){
		return;
	}
	
	protected function _createItem($item, $form){
		$em = $this->getEntityManager();
        $request = $this->getRequest();
		
        $form->bind($item);
        $form->setData($request->getPost());
        if ($form->isValid()) {
			$this->_preCreate($item);
			$em->persist($item);
			$em->flush();
			$this->_postCreate($item);
			return true;
        }
		return false;
	}
	
	protected function _showCreateForm($params){
		$view = new ViewModel($params);
		$view->setTemplate('partial/admin_create.phtml');
		return $view;
	}
	
    public function editAction(){
		if(!$this->_authenticate()) return;
		$em = $this->getEntityManager();
        $id = $this->getEvent()->getRouteMatch()->getParam($this->params['edit_param_name']);
        $item = $this->getItem($id);
		
        $form = $this->getForm();

		if($this->_editItem($item, $form)){
            $this->flashMessenger()->addSuccessMessage('The '.$this->getName().' was edited');
            return $this->redirect()->toRoute($this->params['list_route']);
		}

		$params = array(
			'title' => $this->params['edit_title'],
			'list_route' => $this->params['list_route'],
			'edit_route' => $this->params['edit_route'],
			'delete_route' => $this->params['delete_route'],
			'delete_warning_text' => $this->params['delete_warning_text'],
            'form' => $form,
            'id' => $id
		);
		return $this->_showEditForm($params);
    }

	protected function _preUpdate($item){
		return;
	}

	protected function _postUpdate($item){
		return;
	}
	
	protected function _editItem($item, $form){
		$em = $this->getEntityManager();
		$form->setBindOnValidate(false);
		$form->bind($item);
		
        /** @var $request \Zend\Http\Request */
        $request = $this->getRequest();
		if ($request->isPost()) {
			$form->setData($request->getPost());
			if ($form->isValid()) {
				$form->bindValues();
				$this->_preUpdate($item);
				$em->flush();
				$this->_postUpdate($item);
				
				return true;
			}
        }
		return false;
	}
	
	protected function _showEditForm($params){
		$view = new ViewModel($params);
		$view->setTemplate('partial/admin_edit.phtml');
		return $view;
	}

    public function deleteAction(){
		if(!$this->_authenticate()) return;
        $id = $this->getEvent()->getRouteMatch()->getParam($this->params['delete_param_name']);
		
		if(!$id)
			return $this->_redirectToList();
		
		$item = $this->getItem($id);
		
		if($this->_delteItem($item)){
	        $this->flashMessenger()->addSuccessMessage('The '.$this->getName().' was deleted');
		}
		return $this->_redirectToList();
    }
	
	protected function _delteItem($item){
		$em = $this->getEntityManager();
		if($item){
			$em->remove($item);
			$em->flush();
			return true;
		}
		return false;
	}
	
	protected function _authenticate(){
		if(!$this->zfcUserAuthentication()->hasIdentity()){
			$redirect = $this->getRequest()->getRequestUri();
            $this->redirect()->toUrl($this->url()->fromRoute('zfcuser/login').'?redirect='. rawurlencode($redirect) );
			return false;
		}
		return true;
	}
}

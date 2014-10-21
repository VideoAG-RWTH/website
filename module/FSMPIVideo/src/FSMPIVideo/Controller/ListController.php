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
	
	private $params;
	
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
			'page_length' => 10
		);
		
		$this->params = $params + $defaults;
	}
	
	public function getName(){
		$classname = get_class($this);
		
		$parts = explode("\\", $classname);
		$classname = $parts[count($parts) - 1];
		
		$classname = preg_replace('/ListController$/', '', $classname);
		$classname = preg_replace('/Controller$/', '', $classname);
		
		if(empty($classname))
			throw new \Exception('Empty name');
		return $classname;
	}
	
	public function str_lreplace($search, $replace, $subject){
		$pos = strrpos($subject, $search);
		if($pos !== false){
			$subject = substr_replace($subject, $replace, $pos, strlen($search));
		}
		return $subject;
	}
		
	public function getAll(){
		$em = $this->getEntityManager();
		$name = $this->getName();
		$items = $em->getRepository("\\FSMPIVideo\\Entity\\".$name)->findAll();
		return $items;
	}
	
	public function getItem($id){
		$em = $this->getEntityManager();
		$name = $this->getName();
		$item = $em->getRepository("\\FSMPIVideo\\Entity\\".$name)->find((int)$id);
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
	

	public function getForm(){
		$em = $this->getEntityManager();
		$frmCls = '\\FSMPIVideo\\Form\\'.$this->getName() . 'Form';
		$form = new $frmCls($em);
        $form->setHydrator(new DoctrineObject($em));
		return $form;
	}
	
	public function indexAction(){
		return $this->redirect()->toRoute($this->params['list_route']);
	}
	
	public function listAction(){
		$em = $this->getEntityManager();
		$items = $this->getAll();
		$page = $this->getEvent()->getRouteMatch()->getParam('p');
		
		$view = new ViewModel(array(
			'title' => $this->params['list_title'],
			'list_route' => $this->params['list_route'],
			'create_route' => $this->params['create_route'],
			'edit_route' => $this->params['edit_route'],
			'delete_route' => $this->params['delete_route'],
			'delete_warning_text' => $this->params['delete_warning_text'],
			'create_text' => $this->params['create_text'],
			'columns' => $this->params['list_columns'],
			'rows' => $items,
			'page' => $page,
			'page_length' => $this->params['page_length']
		));
		$view->setTemplate('partial/admin_list.phtml');
		return $view;
	}
	
	public function createAction(){
		$em = $this->getEntityManager();
		$form = $this->getForm();
        $request = $this->getRequest();

        /** @var $request \Zend\Http\Request */
        if ($request->isPost()) {
			$itemName = '\\FSMPIVideo\\Entity\\'.$this->getName();
			$item = new $itemName();
            $form->bind($item);
            $form->setData($request->getPost());
			
            if ($form->isValid()) {
				$em->persist($item);
				$em->flush();
				$this->flashMessenger()->addSuccessMessage('The '.$this->getName().' was created');
				return $this->redirect()->toRoute($this->params['list_route']);
            }
        }
		
		$view = new ViewModel(array(
			'title' => $this->params['create_title'],
			'list_route' => $this->params['list_route'],
			'create_route' => $this->params['create_route'],
			'form' => $form,
		));
		$view->setTemplate('partial/admin_create.phtml');
		return $view;
	}
	
    public function editAction()
    {
		$em = $this->getEntityManager();
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        $item = $this->getItem($id);
		
        $form = $this->getForm();
		$form->setBindOnValidate(false);
		$form->bind($item);
		
        /** @var $request \Zend\Http\Request */
        $request = $this->getRequest();
		if ($request->isPost()) {
			$form->setData($request->getPost());
			if ($form->isValid()) {
				$form->bindValues();
				$em->flush();

				// Redirect to list of albums
                $this->flashMessenger()->addSuccessMessage('The '.$this->getName().' was edited');
                return $this->redirect()->toRoute($this->params['list_route']);
			}
        }

		$view = new ViewModel(array(
			'title' => $this->params['edit_title'],
			'list_route' => $this->params['list_route'],
			'edit_route' => $this->params['edit_route'],
			'delete_route' => $this->params['delete_route'],
			'delete_warning_text' => $this->params['delete_warning_text'],
            'form' => $form,
            'id' => $id
		));
		$view->setTemplate('partial/admin_edit.phtml');
		return $view;
    }

    public function deleteAction()
    {
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
		
		if(!$id){
			return $this->redirect()->toRoute($this->params['list_route'], array());
		}
		$em = $this->getEntityManager();
		$item = $this->getItem($id);
		if($item){
			$em->remove($item);
			$em->flush();
		}
		// Redirect to list of albums
        $this->flashMessenger()->addSuccessMessage('The '.$this->getName().' was deleted');
		return $this->redirect()->toRoute($this->params['list_route']);
    }

	
	
}

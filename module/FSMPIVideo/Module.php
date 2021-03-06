<?php
namespace FSMPIVideo;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use FSMPIVideo\Entity\User;

use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerInterface;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
		$app = $e->getApplication();
		$eventManager = $app->getEventManager(); 
		$sm = $app->getServiceManager();
		
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

		// Protect all views except whitelist by login form
		//$this->protectViewsLogin($e);
		// Extend the ZfcUser registration form with custom fields 
		$this->extendUserRegistrationForm($eventManager);	
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

	public function getServiceConfig()
	{
		return array(
            'invokables' => array(
            ),
			'factories' => array(
				'Navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
			),
		);
	}
	
	
	/**
	 * Extends the ZfcUser registration form with custom fields
	 * 
	 * @param EventManager $eventManager
	 */
	protected function extendUserRegistrationForm(EventManager $eventManager){
		// custom fields of registration form (ZfcUser)
		$sharedEvents = $eventManager->getSharedManager();
		$addFields = function($e){
			/* @var $form \ZfcUser\Form\Register */
			$form = $e->getTarget();
			
			// Add bootstrap classes
			$elementsToEdit = array('email', 'username', 'display_name', 'password', 'passwordVerify');
			foreach($elementsToEdit as $elm){
				if($form->has($elm)){
					$element = $form->get($elm);
					$element->setAttribute('class', $element->getAttribute('class').' form-control');
					//$email->setAttribute('placeholder', 'E-Mail');
					$form->remove($elm);
					$form->add($element);
				}
			}
			
			if($form->has('submit')){
				$element = $form->get('submit');
				$element->setAttribute('class', $element->getAttribute('class').' btn btn-success');
				$form->remove('submit');
				$form->add($element, array('priority' => -100));
			}
			
			// add custom fields
			$form->add(
				array(
					'name' => 'jabber',
					'type' => 'Text',
					'options' => array(
						'label' => 'Jabber',
					),
					'attributes' => array(
						'id' => 'user_jabber',
						'class' => 'form-control',
					)
				)
			);

			// add custom fields
			$form->add(
				array(
					'name' => 'phone',
					'type' => 'Text',
					'options' => array(
						'label' => 'Phone',
					),
					'attributes' => array(
						'id' => 'user_phone',
						'class' => 'form-control',
					)
				)
			);

			// add custom fields
			$form->add(
				array(
					'name' => 'coded_directory',
					'type' => 'Text',
					'options' => array(
						'label' => 'Coded Directory',
					),
					'attributes' => array(
						'id' => 'user_coded_directory',
						'class' => 'form-control',
					)
				)
			);

			$form->add(
				array(
					'name' => 'role',
					'type' => 'Select',
					'options' => array(
						'label' => 'Role',
						'options' => User::getAllowedRoles(),
					),
					'attributes' => array(
						'id' => 'user_role',
					)
				)
			);
		};
		
		$sharedEvents->attach(
			'ZfcUser\Form\Register',
			'init',
			$addFields
		);

		$sharedEvents->attach(
			'ZfcUserAdmin\Form\CreateUser',
			'init',
			$addFields
		);

		$sharedEvents->attach(
			'ZfcUserAdmin\Form\EditUser',
			'init',
			$addFields
		);
 		
        // Validators for custom fields
        $sharedEvents->attach(
			'ZfcUser\Form\RegisterFilter',
			'init',
			function($e){
				/* @var $form \ZfcUser\Form\RegisterFilter */
				$filter = $e->getTarget();
 
				// Custom field company
				$filter->add(array(
					'name'       => 'jabber',
					'required'   => true,
					'filters'  => array(
						array('name' => 'StripTags'),
						array('name' => 'StringTrim'),
					),
					'validators' => array(
						array(
							'name'    => 'StringLength',
							'options' => array(
								'min' => 3,
								'max' => 255,
							)
						),
					),
				));

				// Custom field company
				$filter->add(array(
					'name'       => 'phone',
					'required'   => true,
					'filters'  => array(
						array('name' => 'StripTags'),
						array('name' => 'StringTrim'),
					),
					'validators' => array(
						array(
							'name'    => 'StringLength',
							'options' => array(
								'min' => 3,
								'max' => 255,
							)
						),
					),
				));

				// Custom field company
				$filter->add(array(
					'name'       => 'coded_directory',
					'required'   => true,
					'filters'  => array(
						array('name' => 'StripTags'),
						array('name' => 'StringTrim'),
					),
					'validators' => array(
						array(
							'name'    => 'StringLength',
							'options' => array(
								'min' => 3,
								'max' => 255,
							)
						),
					),
				));
 				
				// Custom field role                    
				$filter->add(array(
					'name'      => 'role',
					'required'  => true,
					'filters'  => array(
						array('name' => 'Int'),
					),
					'validators' => array(
						array(
							'name' => 'InArray',
							'options' => array(
								'haystack' => array_keys(User::getAllowedRoles()),
								'strict' => 'false'
							)
						),
					),
				)); 
			}
		);
	}
	
}

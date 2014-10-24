<?php
namespace FSMPIVideo\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class SuggestableItemForm extends Form
{
	public function __construct(\Doctrine\ORM\EntityManager $em, $name){
		parent::__construct($name);
		
		$this->add(array(
			'name' => 'id',
			'type' => 'Hidden',
		));
		
		$this->add(array(
			'name' => 'suggestedAt',
			'type' => 'DateTimeLocal',
			'options' => array(
				'label' => 'Suggested At',
			),
			'attributes' => array(
				'id' => 'suggestableitem_suggested_at',
				'class' => 'form-control',
			)
		));
		
		$this->add(array(
			'name' => 'suggestedBy',
			'type' => 'DoctrineModule\Form\Element\ObjectSelect',
			'options' => array(
				'object_manager' => $em,
				'target_class' => 'FSMPIVideo\Entity\User',
				'property' => 'displayName',
				'label' => 'Suggested By',
				'display_empty_item' => true,
				'empty_item_label'   => '---',
			),
			'attributes' => array(
				'id' => 'suggestableitem_suggested_by',
			)
		));

	    $submitElement = new Element\Submit('submit');
	    $submitElement
	        ->setLabel('Submit')
	        ->setAttributes(array(
	            'type'  => 'submit',
				'value' => 'Go',
				'class' => 'btn btn-primary'
	        ));

	    $this->add($submitElement, array(
	        'priority' => -100,
	    ));

	}
}
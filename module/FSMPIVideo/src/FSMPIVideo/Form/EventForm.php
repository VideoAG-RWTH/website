<?php
namespace FSMPIVideo\Form;

use Zend\Form\Form;

class EventForm extends ListedItemForm
{
	public function __construct(\Doctrine\ORM\EntityManager $em){
		parent::__construct($em, 'event');
		
		$this->add(array(
			'name' => 'date',
			'type' => 'DateTimeLocal',
			'options' => array(
				'label' => 'Date',
			),
			'attributes' => array(
				'id' => 'event_date',
				'class' => 'form-control',
			)
		));
	
		$this->add(array(
			'name' => 'place',
			'type' => 'Text',
			'options' => array(
				'label' => 'Place',
			),
			'attributes' => array(
				'id' => 'event_place',
				'class' => 'form-control',
			)
		));
		
		$this->add(array(
			'name' => 'duration',
			'type' => 'Number',
			'options' => array(
				'label' => 'Duration',
			),
			'attributes' => array(
				'id' => 'event_duration',
				'class' => 'form-control',
			)
		));
		
		$this->add(array(
			'name' => 'speaker',
			'type' => 'DoctrineModule\Form\Element\ObjectSelect',
			'options' => array(
				'object_manager' => $em,
				'target_class' => 'FSMPIVideo\Entity\Lecturer',
				'property' => 'name',
				'label' => 'Speaker',
				'display_empty_item' => true,
				'empty_item_label'   => '-',
			),
			'attributes' => array(
				'id' => 'event_speaker',
			)
		));
	}
}
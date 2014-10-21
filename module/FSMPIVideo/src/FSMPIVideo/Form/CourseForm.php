<?php
namespace FSMPIVideo\Form;

use Zend\Form\Form;

class CourseForm extends Form
{
	public function __construct(\Doctrine\ORM\EntityManager $em){
		// we want to ignore the name passed
		parent::__construct('course');
		
		$this->add(array(
			'name' => 'id',
			'type' => 'Hidden',
		));
		
		$this->add(array(
			'name' => 'title',
			'type' => 'Text',
			'options' => array(
				'label' => 'Title',
			),
			'attributes' => array(
				'id' => 'course_title',
				'class' => 'form-control',
			)
		));
		
		$this->add(array(
			'name' => 'abbreviation',
			'type' => 'Text',
			'options' => array(
				'label' => 'Abbreviation',
			),
			'attributes' => array(
				'id' => 'course_abbreviation',
				'class' => 'form-control',
			)
		));
		
		$this->add(array(
			'name' => 'subject',
			'type' => 'Text',
			'options' => array(
				'label' => 'Subject',
			),
			'attributes' => array(
				'id' => 'course_subject',
				'class' => 'form-control',
			)
		));
		
		$this->add(array(
			'name' => 'type',
			'type' => 'DoctrineModule\Form\Element\ObjectSelect',
			'options' => array(
				'object_manager' => $em,
				'target_class' => 'FSMPIVideo\Entity\CourseType',
				'property' => 'name',
				'label' => 'Type',
			),
			'attributes' => array(
				'id' => 'course_type',
			)
		));

		$this->add(array(
			'name' => 'submit',
			'type' => 'Submit',
			'attributes' => array(
				'value' => 'Go',
				'id' => 'submitbutton',
				'class' => 'btn btn-primary'
			),
		));

	}
}
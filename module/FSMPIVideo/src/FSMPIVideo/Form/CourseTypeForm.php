<?php
namespace FSMPIVideo\Form;

use Zend\Form\Form;

class CourseTypeForm extends Form
{
	public function __construct(\Doctrine\ORM\EntityManager $em){
		// we want to ignore the name passed
		parent::__construct('course_type');
		
		$this->add(array(
			'name' => 'id',
			'type' => 'Hidden',
		));
		
		$this->add(array(
			'name' => 'name',
			'type' => 'Text',
			'options' => array(
				'label' => 'Name',
			),
			'attributes' => array(
				'id' => 'coursetype_name',
				'class' => 'form-control',
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
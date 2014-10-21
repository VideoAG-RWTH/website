<?php
namespace FSMPIVideo\Form;

use Zend\Form\Form;

class LecturerForm extends Form
{
	public function __construct(\Doctrine\ORM\EntityManager $em){
		// we want to ignore the name passed
		parent::__construct('lecturer');
		
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
				'id' => 'lecturer_name',
				'class' => 'form-control',
			)
		));
		
		$this->add(array(
			'name' => 'email',
			'type' => 'Email',
			'options' => array(
				'label' => 'Email',
			),
			'attributes' => array(
				'id' => 'lecturer_email',
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
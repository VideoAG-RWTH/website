<?php
namespace FSMPIVideo\Form;

use Zend\Form\Form;

class SeriesForm extends ListedItemForm
{
	public function __construct(\Doctrine\ORM\EntityManager $em){
		parent::__construct($em, 'series');
		
		$this->add(array(
			'name' => 'linkElearning',
			'type' => 'Url',
			'options' => array(
				'label' => 'Link Elearning',
			),
			'attributes' => array(
				'id' => 'series_link_elearning',
				'class' => 'form-control',
			)
		));
		
		$this->add(array(
			'name' => 'linkCampus',
			'type' => 'Url',
			'options' => array(
				'label' => 'Link Campus',
			),
			'attributes' => array(
				'id' => 'series_link_campus',
				'class' => 'form-control',
			)
		));
		
		$this->add(array(
			'name' => 'linkSeries',
			'type' => 'Url',
			'options' => array(
				'label' => 'Link Series',
			),
			'attributes' => array(
				'id' => 'series_link_series',
				'class' => 'form-control',
			)
		));
		
		$this->add(array(
			'name' => 'course',
			'type' => 'DoctrineModule\Form\Element\ObjectSelect',
			'options' => array(
				'object_manager' => $em,
				'target_class' => 'FSMPIVideo\Entity\Course',
				'property' => 'title',
				'label' => 'Course',
			),
			'attributes' => array(
				'id' => 'series_course',
			)
		));
		
		$this->add(array(
			'name' => 'host',
			'type' => 'DoctrineModule\Form\Element\ObjectSelect',
			'options' => array(
				'object_manager' => $em,
				'target_class' => 'FSMPIVideo\Entity\CourseHost',
				'property' => 'name',
				'label' => 'Host',
				'display_empty_item' => true,
				'empty_item_label'   => '-',
			),
			'attributes' => array(
				'id' => 'series_host',
			)
		));
		
		$this->add(array(
			'name' => 'lecturer',
			'type' => 'DoctrineModule\Form\Element\ObjectSelect',
			'options' => array(
				'object_manager' => $em,
				'target_class' => 'FSMPIVideo\Entity\Lecturer',
				'property' => 'name',
				'label' => 'Lecturer',
				'display_empty_item' => true,
				'empty_item_label'   => '-',
			),
			'attributes' => array(
				'id' => 'series_lecturer',
			)
		));
	}
}
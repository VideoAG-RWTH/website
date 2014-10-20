<?php
namespace FSMPIVideo\Form;

use Zend\Form\Form;

class VideoSearchForm extends Form
{
	public function __construct($name = null)
	{
		// we want to ignore the name passed
		parent::__construct('video_search');

		$this->add(array(
			'name' => 'search',
			'type' => 'Text',
			'options' => array(
				'label' => '',
			),
			'attributes' => array(
				'id' => 'search_search',
				'class' => 'form-control',
				'placeholder' => 'Search...'
			)
		));
	}
}
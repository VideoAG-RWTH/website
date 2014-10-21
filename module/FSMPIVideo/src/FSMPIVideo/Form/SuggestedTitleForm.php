<?php
namespace FSMPIVideo\Form;

use Zend\Form\Form;

class SuggestedTitleForm extends SuggestableItemForm
{
	public function __construct(\Doctrine\ORM\EntityManager $em){
		parent::__construct($em, 'suggestedtitle');
		
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
				'id' => 'suggestedtitle_title',
				'class' => 'form-control',
			)
		));
		
		$this->add(array(
			'name' => 'listed_item',
			'type' => 'DoctrineModule\Form\Element\ObjectSelect',
			'options' => array(
				'object_manager' => $em,
				'target_class' => 'FSMPIVideo\Entity\ListedItem',
				'property' => 'title',
				'label' => 'Listed Item',
			),
			'attributes' => array(
				'id' => 'suggestedtitle_listed_item',
			)
		));
		
		$this->add(array(
			'name' => 'is_viewed',
			'type' => 'Checkbox',
			'options' => array(
				'use_hidden_element' => true,
				'checked_value' => '1',
				'unchecked_value' => '0',
				'label' => 'Is Viewed',
			),
			'attributes' => array(
				'id' => 'suggestedtitle_is_viewed',
				'class' => 'form-control',
			)
		));

		$this->add(array(
			'name' => 'viewed_by',
			'type' => 'DoctrineModule\Form\Element\ObjectSelect',
			'options' => array(
				'object_manager' => $em,
				'target_class' => 'FSMPIVideo\Entity\User',
				'property' => 'displayName',
				'display_empty_item' => true,
				'empty_item_label'   => '---',
				'label' => 'Viewed By',
			),
			'attributes' => array(
				'id' => 'suggestedtitle_viewed_by',
			)
		));

	}
}
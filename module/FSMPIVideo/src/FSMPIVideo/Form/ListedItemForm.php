<?php
namespace FSMPIVideo\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use FSMPIVideo\Entity\ListedItem;

class ListedItemForm extends Form
{
	public function __construct(\Doctrine\ORM\EntityManager $em, $name = 'listeditem'){
		parent::__construct($name);
		
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
				'id' => 'listeditem_title',
				'class' => 'form-control',
			)
		));
		
		$this->add(array(
			'name' => 'alias',
			'type' => 'Text',
			'options' => array(
				'label' => 'Alias',
			),
			'attributes' => array(
				'id' => 'listeditem_alias',
				'class' => 'form-control',
			)
		));
	
		$this->add(array(
			'name' => 'description',
			'type' => 'Textarea',
			'options' => array(
				'label' => 'Description',
			),
			'attributes' => array(
				'id' => 'listeditem_description',
				'class' => 'form-control',
			)
		));
		
		$this->add(array(
			'name' => 'internalComment',
			'type' => 'Textarea',
			'options' => array(
				'label' => 'Internal Comment',
			),
			'attributes' => array(
				'id' => 'listeditem_internal_comment',
				'class' => 'form-control',
			)
		));
		
		$this->add(array(
			'name' => 'semester',
			'type' => 'Text',
			'options' => array(
				'label' => 'Semester',
			),
			'attributes' => array(
				'id' => 'listeditem_semester',
				'class' => 'form-control',
			)
		));
		
		$this->add(array(
			'name' => 'createdBy',
			'type' => 'DoctrineModule\Form\Element\ObjectSelect',
			'options' => array(
				'object_manager' => $em,
				'target_class' => 'FSMPIVideo\Entity\User',
				'property' => 'displayName',
				'label' => 'Created By',
				//'display_empty_item' => true,
				//'empty_item_label'   => '---',
			),
			'attributes' => array(
				'id' => 'listeditem_created_by',
			)
		));
	
		$this->add(array(
			'name' => 'createdAt',
			'type' => 'DateTimeSelect',
			'options' => array(
				'label' => 'Created At',
			),
			'attributes' => array(
				'id' => 'listeditem_created_at',
				'class' => 'form-control',
				//'disabled' => 'true',
			)
		));
		
		$this->add(array(
			'name' => 'superAdmin',
			'type' => 'DoctrineModule\Form\Element\ObjectSelect',
			'options' => array(
				'object_manager' => $em,
				'target_class' => 'FSMPIVideo\Entity\User',
				'property' => 'displayName',
				'label' => 'Super Admin',
				'display_empty_item' => true,
				'empty_item_label'   => '---',
			),
			'attributes' => array(
				'id' => 'listeditem_super_admin',
			)
		));

		$this->add(array(
			'name' => 'lastChange',
			'type' => 'DateTimeSelect',
			'options' => array(
				'label' => 'Last Change',
			),
			'attributes' => array(
				'id' => 'listeditem_last_change',
				'class' => 'form-control',
				//'disabled' => 'true',
			)
		));
		
		$this->add(array(
			'name' => 'changedBy',
			'type' => 'DoctrineModule\Form\Element\ObjectSelect',
			'options' => array(
				'object_manager' => $em,
				'target_class' => 'FSMPIVideo\Entity\User',
				'property' => 'displayName',
				'label' => 'Changed By',
				'display_empty_item' => true,
				'empty_item_label'   => '---',
			),
			'attributes' => array(
				'id' => 'listeditem_changed_by',
			)
		));
		
		$this->add(array(
			'name' => 'isDownloadable',
			'type' => 'Checkbox',
			'options' => array(
				'checked_value' => '1',
				'unchecked_value' => '0',
				'label' => 'Is Downloadable',
			),
			'attributes' => array(
				'id' => 'listeditem_is_downloadable',
				'class' => 'toggle_switch',
				'data-on-text' => 'Yes',
				'data-off-text' => 'No'
			)
		));
		
		$this->add(array(
			'name' => 'isListed',
			'type' => 'Checkbox',
			'options' => array(
				'checked_value' => '1',
				'unchecked_value' => '0',
				'label' => 'Is Listed',
			),
			'attributes' => array(
				'id' => 'listeditem_is_listed',
				'class' => 'toggle_switch',
				'data-on-text' => 'Yes',
				'data-off-text' => 'No'
			)
		));
		
		$this->add(array(
			'name' => 'isAccessable',
			'type' => 'Checkbox',
			'options' => array(
				'checked_value' => '1',
				'unchecked_value' => '0',
				'label' => 'Is Accessable',
			),
			'attributes' => array(
				'id' => 'listeditem_is_accessable',
				'class' => 'toggle_switch',
				'data-on-text' => 'Yes',
				'data-off-text' => 'No'
			)
		));

		$this->add(array(
			'name' => 'accessType',
			'type' => 'Select',
			'options' => array(
				'label' => 'Access Type',
				'options' => ListedItem::getAccessTypes(),
			),
			'attributes' => array(
				'id' => 'listeditem_access_type',
			)
		));
		
		$this->add(array(
			'name' => 'responsibleUsers',
			'type' => 'DoctrineModule\Form\Element\ObjectSelect',
			'options' => array(
				'object_manager' => $em,
				'target_class' => 'FSMPIVideo\Entity\User',
				'property' => 'displayName',
				'label' => 'Responsible users',
			),
			'attributes' => array(
				'id' => 'listeditem_responsible_users',
				'multiple' => 'multiple',
			)
		));
		
		$this->add(array(
			'name' => 'responsibleText',
			'type' => 'Text',
			'options' => array(
				'label' => 'Responsible',
			),
			'attributes' => array(
				'id' => 'listeditem_responsible_text',
				'class' => 'form-control',
			)
		));
		
		$this->add(array(
			'name' => 'username',
			'type' => 'Text',
			'options' => array(
				'label' => 'Username (for Access Type password)',
			),
			'attributes' => array(
				'id' => 'listeditem_username',
				'class' => 'form-control',
			)
		));
		
		$this->add(array(
			'name' => 'password',
			'type' => 'Text',
			'options' => array(
				'label' => 'Password (for Access Type password)',
			),
			'attributes' => array(
				'id' => 'listeditem_password',
				'class' => 'form-control',
			)
		));
		
		$this->add(array(
			'name' => 'thumbnailImage',
			'type' => 'Text',
			'options' => array(
				'label' => 'Thumbnail image',
			),
			'attributes' => array(
				'id' => 'listeditem_thumbnail_image',
				'class' => 'form-control',
			)
		));
		
	    $submitElement = new Element\Submit('submit');
	    $submitElement
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
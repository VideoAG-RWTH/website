<?php
namespace FSMPIVideo\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface; 
use Zend\Json\Json;
use JsonSerializable;

use FSMPIVideo\Entity\SuggestableItem;

/**
 * A Suggested Title.
 *
 * @ORM\Entity
 * @ORM\Table(name="suggested_title")
 * @property string $title
 * @property ListedItem $listed_item
 * @property boolean $is_viewed
 * @property User $viewed_by
 */
class SuggestedTitle extends SuggestableItem
{
	protected $inputFilter;
 	
	/**
	 * @ORM\Column(type="string");
	 */
	protected $title;
 	
	/**
     * @ORM\ManyToOne(targetEntity="ListedItem")
	 * @ORM\JoinColumn(name="listed_item_id", referencedColumnName="id")
	 */
	protected $listed_item;
	
	/**
	 * @ORM\Column(type="boolean");
	 */
	protected $is_viewed;
	
	/**
     * @ORM\ManyToOne(targetEntity="User")
	 * @ORM\JoinColumn(name="viewed_by_id", referencedColumnName="user_id")
	 */
	protected $viewed_by;

	/**
	 * Getter for Title
	 * @return string
	 */
	public function getTitle(){ return $this->title; }

	/**
	 * Getter for ListedItem
	 * @return ListedItem
	 */
	public function getListedItem(){ return $this->listed_item; }

	/**
	 * Getter for IsViewed
	 * @return boolean
	 */
	public function getIsViewed(){ return $this->is_viewed; }

	/**
	 * Getter for ViewedBy
	 * @return User
	 */
	public function getViewedBy(){ return $this->viewed_by; }
	
	/** 
	 * Setter for Title
	 * @param string $time
	 */
	public function setTitle($title){ $this->title = $title; }
	
	/** 
	 * Setter for ListedItem
	 * @param ListedItem $listed_item
	 */
	public function setListedItem($listed_item){ $this->listed_item = $listed_item; }
	
	/** 
	 * Setter for IsViewed
	 * @param boolean $is_viewed
	 */
	public function setIsViewed($is_viewed){ $this->is_viewed = $is_viewed; }
	
	/** 
	 * Setter for ViewedBy
	 * @param User $viewed_by
	 */
	public function setViewedBy($viewed_by){ $this->viewed_by = $viewed_by; }
	
	/**
	 * Populate from an array.
	 *
	 * @param array $data
	 */
	public function populate($data = array()){
		parent::populate($data);
		$this->setTitle($data['title']);
		$this->setListedItem($data['listed_item']);
		$this->setIsViewed($data['is_viewed']);
		$this->setViewedBy($data['viewed_by']);
	}
 
	public function setInputFilter(InputFilterInterface $inputFilter){
		throw new \Exception("Not used");
	}
 
	/**
	 * Returns input filters for this entity
	 * @return \Zend\InputFilter\InputFilter
	 */
	public function getInputFilter(){
		if (!$this->inputFilter) {
			$inputFilter = parent::getInputFilter();
 
			$factory = new InputFactory();

			$inputFilter->add($factory->createInput(array(
				'name'     => 'title',
				'required' => false,
				'filters'  => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
			)));


			$this->inputFilter = $inputFilter;        
		}

		return $this->inputFilter;
	}

	/**
	 * Returns data to show in json
	 * @return array
	 */
	public function jsonSerialize(){
		$data = array(
			"listed_item" => $this->getListedItem(),
			"title" => $this->getTitle(),
			"is_viewed" => $this->getIsViewed(),
			"viewed_by" => $this->getViewedBy()
		);
		return array_merge(parent::jsonSerialize(), $data);
	}
}
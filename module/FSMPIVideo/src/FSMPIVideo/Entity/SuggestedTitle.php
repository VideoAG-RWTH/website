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
 * @property ListedItem $listedItem
 * @property boolean $isViewed
 * @property User $viewedBy
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
	 * @ORM\JoinColumn(name="listedItem_id", referencedColumnName="id")
	 */
	protected $listedItem;
	
	/**
	 * @ORM\Column(type="boolean");
	 */
	protected $isViewed;
	
	/**
     * @ORM\ManyToOne(targetEntity="User")
	 * @ORM\JoinColumn(name="viewedBy_id", referencedColumnName="user_id")
	 */
	protected $viewedBy;

	/**
	 * Getter for Title
	 * @return string
	 */
	public function getTitle(){ return $this->title; }

	/**
	 * Getter for ListedItem
	 * @return ListedItem
	 */
	public function getListedItem(){ return $this->listedItem; }

	/**
	 * Getter for IsViewed
	 * @return boolean
	 */
	public function getIsViewed(){ return $this->isViewed; }

	/**
	 * Getter for ViewedBy
	 * @return User
	 */
	public function getViewedBy(){ return $this->viewedBy; }
	
	/** 
	 * Setter for Title
	 * @param string $time
	 */
	public function setTitle($title){ $this->title = $title; }
	
	/** 
	 * Setter for ListedItem
	 * @param ListedItem $listedItem
	 */
	public function setListedItem($listedItem){ $this->listedItem = $listedItem; }
	
	/** 
	 * Setter for IsViewed
	 * @param boolean $isViewed
	 */
	public function setIsViewed($isViewed){ $this->isViewed = $isViewed; }
	
	/** 
	 * Setter for ViewedBy
	 * @param User $viewedBy
	 */
	public function setViewedBy($viewedBy){ $this->viewedBy = $viewedBy; }
	
	/**
	 * Populate from an array.
	 *
	 * @param array $data
	 */
	public function populate($data = array()){
		parent::populate($data);
		$this->setTitle($data['title']);
		$this->setListedItem($data['listedItem']);
		$this->setIsViewed($data['isViewed']);
		$this->setViewedBy($data['viewedBy']);
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
			"listedItem" => $this->getListedItem(),
			"title" => $this->getTitle(),
			"isViewed" => $this->getIsViewed(),
			"viewedBy" => $this->getViewedBy()
		);
		return array_merge(parent::jsonSerialize(), $data);
	}
}
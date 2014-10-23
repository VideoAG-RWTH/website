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
 * An Event Marker.
 *
 * @ORM\Entity
 * @ORM\Table(name="event_marker")
 * @property Event $event
 * @property float $timeSeconds
 * @property string $title
 * @property User $publishedBy
 * @property boolean $isPublished
 */
class EventMarker extends SuggestableItem
{
	protected $inputFilter;
 	
	/**
     * @ORM\ManyToOne(targetEntity="Event", inversedBy="markers")
	 * @ORM\JoinColumn(name="event_id", referencedColumnName="id")
	 */
	protected $event;

	/**
	 * @ORM\Column(type="float");
	 */
	protected $timeSeconds;
 
	/**
	 * @ORM\Column(type="string");
	 */
	protected $title;
 
	/**
	 * @ORM\Column(type="boolean");
	 */
	protected $isPublished;
 
	/**
     * @ORM\ManyToOne(targetEntity="User")
	 * @ORM\JoinColumn(name="publishedBy_id", referencedColumnName="user_id")
	 */
	protected $publishedBy;
 
	/**
	 * Getter for Event
	 * @return Event
	 */
	public function getEvent(){ return $this->event; }
	
	/**
	 * Getter for Time
	 * @return float
	 */
	public function getTime(){ return $this->timeSeconds; }
	
	/**
	 * Getter for Title
	 * @return string
	 */
	public function getTitle(){ return $this->title; }
	
	/**
	 * Getter for IsPublished
	 * @return boolean
	 */
	public function getIsPublished(){ return $this->isPublished; }
	
	/**
	 * Getter for PublishedBy
	 * @return User
	 */
	public function getPublishedBy(){ return $this->publishedBy; }
	
	/** 
	 * Setter for Event
	 * @param Event $event
	 */
	public function setEvent($event){ $this->event = $event; }
	
	/** 
	 * Setter for Time
	 * @param float $time
	 */
	public function setTime($time){ $this->timeSeconds = $time; }
	
	/** 
	 * Setter for Title
	 * @param string $title
	 */
	public function setTitle($title){ $this->title = $title; }
	
	/** 
	 * Setter for IsPublished
	 * @param boolean $isPublished
	 */
	public function setIsPublished($isPublished){ $this->isPublished = $isPublished; }
	
	/** 
	 * Setter for PublishedBy
	 * @param User $publishedBy
	 */
	public function setPublishedBy($publishedBy){ $this->publishedBy = $publishedBy; }
	
	/**
	 * Populate from an array.
	 *
	 * @param array $data
	 */
	public function populate($data = array()){
		parent::populate($data);
		$this->setEvent($data['event']);
		$this->setTime($data['timeSeconds']);
		$this->setTitle($data['title']);
		$this->setIsPublished($data['isPublished']);
		$this->setPublishedBy($data['publishedBy']);
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
				'name'       => 'title',
				'required'   => true,
				'filters' => array(
			        array('name' => 'StripTags'),
			        array('name' => 'StringTrim'),
				),
			)));

			$inputFilter->add($factory->createInput(array(
				'name'       => 'isPublished',
				'required'   => true,
				'filters' => array(
			        array('name' => 'Boolean'),
				),
			)));

			$inputFilter->add($factory->createInput(array(
				'name'       => 'timeSeconds',
				'required'   => true,
				'validators' => array(
			        array('name' => 'Float'),
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
			//"event" => $this->getEvent(),
			"timeSeconds" => $this->getTime(),
			"title" => $this->getTitle(),
			"isPublished" => $this->getIsPublished(),
			"publishedBy" => $this->getPublishedBy()
		);
		return array_merge(parent::jsonSerialize(), $data);
	}
}
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
 * @property float $time_seconds
 * @property string $title
 * @property User $published_by
 * @property boolean $is_published
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
	protected $time_seconds;
 
	/**
	 * @ORM\Column(type="string");
	 */
	protected $title;
 
	/**
	 * @ORM\Column(type="boolean");
	 */
	protected $is_published;
 
	/**
     * @ORM\ManyToOne(targetEntity="User")
	 * @ORM\JoinColumn(name="published_by_id", referencedColumnName="user_id")
	 */
	protected $published_by;
 
	/**
	 * Getter for Event
	 * @return Event
	 */
	public function getEvent(){ return $this->event; }
	
	/**
	 * Getter for Time
	 * @return float
	 */
	public function getTime(){ return $this->time_seconds; }
	
	/**
	 * Getter for Title
	 * @return string
	 */
	public function getTitle(){ return $this->title; }
	
	/**
	 * Getter for IsPublished
	 * @return boolean
	 */
	public function getIsPublished(){ return $this->is_published; }
	
	/**
	 * Getter for PublishedBy
	 * @return User
	 */
	public function getPublishedBy(){ return $this->published_by; }
	
	/** 
	 * Setter for Event
	 * @param Event $event
	 */
	public function setEvent($event){ $this->event = $event; }
	
	/** 
	 * Setter for Time
	 * @param float $time
	 */
	public function setTime($time){ $this->time_seconds = $time; }
	
	/** 
	 * Setter for Title
	 * @param string $title
	 */
	public function setTitle($title){ $this->title = $title; }
	
	/** 
	 * Setter for IsPublished
	 * @param boolean $is_published
	 */
	public function setIsPublished($is_published){ $this->is_published = $is_published; }
	
	/** 
	 * Setter for PublishedBy
	 * @param User $published_by
	 */
	public function setPublishedBy($published_by){ $this->published_by = $published_by; }
	
	/**
	 * Populate from an array.
	 *
	 * @param array $data
	 */
	public function populate($data = array()){
		parent::populate($data);
		$this->setEvent($data['event']);
		$this->setTime($data['time_seconds']);
		$this->setTitle($data['title']);
		$this->setIsPublished($data['is_published']);
		$this->setPublishedBy($data['published_by']);
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
				'name'       => 'is_published',
				'required'   => true,
				'filters' => array(
			        array('name' => 'Boolean'),
				),
			)));

			$inputFilter->add($factory->createInput(array(
				'name'       => 'time_seconds',
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
			"time_seconds" => $this->getTime(),
			"title" => $this->getTitle(),
			"is_published" => $this->getIsPublished(),
			"published_by" => $this->getPublishedBy()
		);
		return array_merge(parent::jsonSerialize(), $data);
	}
}
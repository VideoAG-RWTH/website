<?php
namespace FSMPIVideo\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface; 
use Zend\Json\Json;
use JsonSerializable;

/**
 * A Series-Event Association.
 *
 * @ORM\Entity
 * @ORM\Table(name="series_event_association")
 * @property Series $series
 * @property Event $event
 * @property int $custom_order
 */
class SeriesEventAssociation implements InputFilterAwareInterface, JsonSerializable
{
	protected $inputFilter;
 	
	/**
	 * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Series", inversedBy="events_associations")
	 * @ORM\JoinColumn(name="series_id", referencedColumnName="id")
	 */
	protected $series;
 	
	/**
	 * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Event", inversedBy="series_associations")
	 * @ORM\JoinColumn(name="event_id", referencedColumnName="id")
	 */
	protected $event;
 	
	/**
	 * @ORM\Column(type="integer");
	 */
	protected $custom_order;
	

	/**
	 * Getter for Event
	 * @return Event
	 */
	public function getEvent(){ return $this->event; }

	/**
	 * Getter for Series
	 * @return Series
	 */
	public function getSeries(){ return $this->series; }

	/**
	 * Getter for CustomOrder
	 * @return int
	 */
	public function getCustomOrder(){ return $this->custom_order; }
	
	/** 
	 * Setter for Event
	 * @param Event $event
	 */
	public function setEvent($event){ $this->event = $event; }
	
	/** 
	 * Setter for Series
	 * @param Series $series
	 */
	public function setSeries($series){ $this->series = $series; }
	
	/** 
	 * Setter for CustomOrder
	 * @param int $custom_order
	 */
	public function setCustomOrder($custom_order){ $this->custom_order = $custom_order; }
	
	/**
	 * Populate from an array.
	 *
	 * @param array $data
	 */
	public function populate($data = array()){
		$this->setEvent($data['event']);
		$this->setSeries($data['series']);
		$this->setCustomOrder($data['custom_order']);
	}
 
	public function getArrayCopy(){
		return $this->jsonSerialize();
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
			$inputFilter = new InputFilter();
 
			$factory = new InputFactory();
 
			$inputFilter->add($factory->createInput(array(
				'name'       => 'custom_order',
				'required'   => true,
				'filters' => array(
					array('name'    => 'Int'),
				),
			)));
 
			$this->inputFilter = $inputFilter;        
		}

		return $this->inputFilter;
	}

	/**
	 * Returns json String
	 * @return string
	 */
	public function toJson(){
		$data = $this->jsonSerialize();
		return Json::encode($data, true, array('silenceCyclicalExceptions' => true));
	}
	
	/**
	 * Returns data to show in json
	 * @return array
	 */
	public function jsonSerialize(){
		$data = array(
			"event" => $this->getEvent(),
			"series" => $this->getSeries(),
			"custom_order" => $this->getCustomOrder()
		);
		return $data;
	}
}
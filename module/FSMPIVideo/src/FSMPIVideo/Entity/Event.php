<?php
namespace FSMPIVideo\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface; 
use Zend\Json\Json;
use JsonSerializable;

use FSMPIVideo\Entity\ListedItem;

/**
 * An Event.
 *
 * @ORM\Entity
 * @ORM\Table(name="event")
 * @property DateTime $date
 * @property string $place
 * @property int $duration
 * @property Lecturer $speaker
 */
class Event extends ListedItem
{
	protected $inputFilter;
 	
	/**
	 * @ORM\Column(type="datetime");
	 */
	protected $date;
 	
	/**
	 * @ORM\Column(type="string");
	 */
	protected $place;
 	
	/**
	 * @ORM\Column(type="integer");
	 */
	protected $duration;
 	
	/**
     * @ORM\ManyToOne(targetEntity="Lecturer")
	 * @ORM\JoinColumn(name="speaker_id", referencedColumnName="id")
	 */
	protected $speaker;
 	
	/**
	 * @ORM\OneToMany(targetEntity="EventMarker", mappedBy="event")
	 */
	protected $markers;
	
	/**
     * @ORM\OneToMany(targetEntity="SeriesEventAssociation",mappedBy="event")
	 */
	protected $series_associations;
	
	/**
	 * Getter for Date
	 * @return DateTime
	 */
	public function getDate(){ return $this->date; }

	/**
	 * Getter for Place
	 * @return string
	 */
	public function getPlace(){ return $this->place; }

	/**
	 * Getter for Duration
	 * @return int
	 */
	public function getDuration(){ return $this->duration; }

	/**
	 * Getter for Speaker
	 * @return Lecturer
	 */
	public function getSpeaker(){ return $this->speaker; }

	/**
	 * Getter for Series Associations
	 * @return array
	 */
	public function getSeriesAssociations(){ return $this->series_associations; }

	/**
	 * Getter for Markers
	 * @return array
	 */
	public function getMarkers(){ return $this->markers; }
	
	/** 
	 * Setter for Date
	 * @param DateTime $date
	 */
	public function setDate(DateTime $date){ $this->date = $date; }
	
	/** 
	 * Setter for Place
	 * @param DateTime $place
	 */
	public function setPlace($place){ $this->place = $place; }
	
	/** 
	 * Setter for Duration
	 * @param DateTime $duration
	 */
	public function setDuration($duration){ $this->duration = $duration; }
	
	/** 
	 * Setter for Speaker
	 * @param Lecturer $speaker
	 */
	public function setSpeaker($speaker){ $this->speaker = $speaker; }
	
	/**
	 * Populate from an array.
	 *
	 * @param array $data
	 */
	public function populate($data = array()){
		parent::populate($data);
		$this->setDate($data['date']);
		$this->setPlace($data['place']);
		$this->setDuration($data['duration']);
		$this->setSpeaker($data['speaker']);
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
				'name'       => 'place',
				'required'   => true,
				'filters' => array(
			        array('name' => 'StripTags'),
			        array('name' => 'StringTrim'),
				),
			)));

			$inputFilter->add($factory->createInput(array(
				'name'       => 'duration',
				'required'   => true,
				'filters' => array(
			        array('name' => 'Int'),
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
			"date" => $this->getDate(),
			"place" => $this->getPlace(),
			"duration" => $this->getDuration(),
			"speaker" => $this->getSpeaker(),
			"markers" => $this->getMarkers()
		);
		return array_merge(parent::jsonSerialize(), $data);
	}
}
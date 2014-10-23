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
 * A Series.
 *
 * @ORM\Entity
 * @ORM\Table(name="series")
 * @property string $linkElearning
 * @property string $linkCampus
 * @property string $linkSeries
 * @property CourseHost $host
 * @property Lecturer $lecturer
 * @property Course $course
 */
class Series extends ListedItem
{
	protected $inputFilter;
 	
	/**
	 * @ORM\Column(type="text");
	 */
	protected $linkElearning;
 	
	/**
	 * @ORM\Column(type="text");
	 */
	protected $linkCampus;
 	
	/**
	 * @ORM\Column(type="text");
	 */
	protected $linkSeries;
 	
	/**
     * @ORM\ManyToOne(targetEntity="CourseHost")
	 * @ORM\JoinColumn(name="host_id", referencedColumnName="id")
	 */
	protected $host;
 	
	/**
     * @ORM\ManyToOne(targetEntity="Lecturer")
	 * @ORM\JoinColumn(name="lecturer_id", referencedColumnName="id")
	 */
	protected $lecturer;
 	
	/**
     * @ORM\ManyToOne(targetEntity="Course")
	 * @ORM\JoinColumn(name="course_id", referencedColumnName="id")
	 */
	protected $course;
	
	/**
     * @ORM\OneToMany(targetEntity="SeriesEventAssociation",mappedBy="series")
	 * @ORM\OrderBy({"customOrder" = "ASC"})
	 */
	protected $eventAssociations;
 
	/**
	 * Getter for ELearning Link
	 * @return string
	 */
	public function getLinkELearning(){ return $this->linkElearning; }

	/**
	 * Getter for Campus Link
	 * @return string
	 */
	public function getLinkCampus(){ return $this->linkCampus; }

	/**
	 * Getter for Series Link
	 * @return string
	 */
	public function getLinkSeries(){ return $this->linkSeries; }

	/**
	 * Getter for Host
	 * @return CourseHost
	 */
	public function getHost(){ return $this->host; }

	/**
	 * Getter for Lecturer
	 * @return Lecturer
	 */
	public function getLecturer(){ return $this->lecturer; }

	/**
	 * Getter for Course
	 * @return Course
	 */
	public function getCourse(){ return $this->course; }

	/**
	 * Getter for Event Associations
	 * @return array
	 */
	public function getEventAssociations(){ return $this->eventAssociations; }


	
	/** 
	 * Setter for ELearning Link
	 * @param string $link
	 */
	public function setLinkELearning($link){ $this->linkElearning = $link; }
	
	/**
	 * Setter for Campus Link
	 * @param string $linkCampus
	 */
	public function setLinkCampus($linkCampus){ $this->linkCampus = $linkCampus; }

	/**
	 * Setter for Series Link
	 * @param string $linkSeries
	 */
	public function setLinkSeries($linkSeries){ $this->linkSeries = $linkSeries; }

	/**
	 * Setter for Course
	 * @param CourseHost $course
	 */
	public function setCourse($course){ $this->course = $course; }

	/**
	 * Setter for Host
	 * @param CourseHost $host
	 */
	public function setHost($host){ $this->host = $host; }

	/**
	 * Setter for Lecturer
	 * @param Lecturer $lecturer
	 */
	public function setLecturer($lecturer){ $this->lecturer = $lecturer; }

	/**
	 * Setter for Course Type
	 * @param CourseType $course_type
	 */
	public function setCourseType($course_type){ $this->course_type = $course_type; }
	
	
	
	/**
	 * Populate from an array.
	 *
	 * @param array $data
	 */
	public function populate($data = array()){
		parent::populate($data);
		$this->setLinkELearning($data['linkElearning']);
		$this->setLinkCampus($data['linkCampus']);
		$this->setLinkSeries($data['linkSeries']);
		$this->setHost($data['host']);
		$this->setLecturer($data['lecturer']);
		$this->setCourse($data['course']);
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
	            'name'     => 'linkElearning',
	            'required' => false,
	            'filters'  => array(
	                array('name' => 'StripTags'),
	                array('name' => 'StringTrim'),
	            ),
	        )));

	        $inputFilter->add($factory->createInput(array(
	            'name'     => 'linkCampus',
	            'required' => false,
	            'filters'  => array(
	                array('name' => 'StripTags'),
	                array('name' => 'StringTrim'),
	            ),
	        )));

		    $inputFilter->add($factory->createInput(array(
		        'name'     => 'linkSeries',
		        'required' => false,
		        'filters'  => array(
		            array('name' => 'StripTags'),
		            array('name' => 'StringTrim'),
		        ),
		    )));

		    $inputFilter->add($factory->createInput(array(
		        'name'     => 'lecturer',
		        'required' => false,
		    )));

		    $inputFilter->add($factory->createInput(array(
		        'name'     => 'host',
		        'required' => false,
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
			"linkElearning" => $this->getLinkELearning(),
			"linkCampus" => $this->getLinkCampus(),
			"linkSeries" => $this->getLinkSeries(),
			"host" => $this->getHost(),
			"lecturer" => $this->getLecturer(),
			"course" => $this->getCourse(),
			"eventAssociations" => $this->getEventAssociations(),
		);
		return array_merge(parent::jsonSerialize(), $data);
	}
}
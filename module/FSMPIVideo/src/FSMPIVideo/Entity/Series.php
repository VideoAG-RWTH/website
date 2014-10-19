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
 * @property string $link_elearning
 * @property string $link_campus
 * @property string $link_series
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
	protected $link_elearning;
 	
	/**
	 * @ORM\Column(type="text");
	 */
	protected $link_campus;
 	
	/**
	 * @ORM\Column(type="text");
	 */
	protected $link_series;
 	
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
	 */
	protected $events_associations;
 
	/**
	 * Getter for ELearning Link
	 * @return string
	 */
	public function getLinkELearning(){ return $this->link_elearning; }

	/**
	 * Getter for Campus Link
	 * @return string
	 */
	public function getLinkCampus(){ return $this->link_campus; }

	/**
	 * Getter for Series Link
	 * @return string
	 */
	public function getLinkSeries(){ return $this->link_series; }

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
	public function getEventAssociations(){ return $this->event_associations; }


	
	/** 
	 * Setter for ELearning Link
	 * @param string $link
	 */
	public function setLinkELearning($link){ $this->link_elearning = $link; }
	
	/**
	 * Setter for Campus Link
	 * @param string $link_campus
	 */
	public function setLinkCampus($link_campus){ $this->link_campus = $link_campus; }

	/**
	 * Setter for Series Link
	 * @param string $link_series
	 */
	public function setLinkSeries($link_series){ $this->link_series = $link_series; }

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
		$this->setLinkELearning($data['link_elearning']);
		$this->setLinkCampus($data['link_campus']);
		$this->setLinkSeries($data['link_series']);
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
	            'name'     => 'link_elearning',
	            'required' => false,
	            'filters'  => array(
	                array('name' => 'StripTags'),
	                array('name' => 'StringTrim'),
	            ),
	        )));

	        $inputFilter->add($factory->createInput(array(
	            'name'     => 'link_campus',
	            'required' => false,
	            'filters'  => array(
	                array('name' => 'StripTags'),
	                array('name' => 'StringTrim'),
	            ),
	        )));

		    $inputFilter->add($factory->createInput(array(
		        'name'     => 'link_series',
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
			"link_elearning" => $this->getLinkELearning(),
			"link_campus" => $this->getLinkCampus(),
			"link_series" => $this->getLinkSeries(),
			"host" => $this->getHost(),
			"lecturer" => $this->getLecturer(),
			"course" => $this->getCourse(),
			"event_associations" => $this->getEventAssociations(),
		);
		return array_merge(parent::jsonSerialize(), $data);
	}
}
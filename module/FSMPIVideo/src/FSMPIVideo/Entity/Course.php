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
 * A Course.
 *
 * @ORM\Entity
 * @ORM\Table(name="course")
 * @property int $id
 * @property string $title
 * @property string $abbreviation
 * @property string $subject
 * @property CourseType $type
 */
class Course implements InputFilterAwareInterface, JsonSerializable
{
	protected $inputFilter;
 	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer");
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
 	
	/**
	 * @ORM\Column(type="string");
	 */
	protected $title;
 	
	/**
	 * @ORM\Column(type="string");
	 */
	protected $abbreviation;
 	
	/**
	 * @ORM\Column(type="string");
	 */
	protected $subject;
 	
	/**
     * @ORM\ManyToOne(targetEntity="CourseType")
	 * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
	 */
	protected $type;
 
	/**
	 * Getter for ID
	 * @return int
	 */
	public function getId(){ return $this->id; }

	/**
	 * Getter for Title
	 * @return string
	 */
	public function getTitle(){ return $this->title; }

	/**
	 * Getter for Abbreviation
	 * @return string
	 */
	public function getAbbreviation(){ return $this->abbreviation; }

	/**
	 * Getter for Subject
	 * @return string
	 */
	public function getSubject(){ return $this->subject; }
	
	/**
	 * Getter for Type
	 * @return CourseType
	 */
	public function getType(){ return $this->type; }
	
	/**
	 * Getter for Type name
	 * @return CourseType
	 */
	public function getTypeName(){ return $this->type->getName(); }
	
	/** 
	 * Setter for ID
	 * @param int $id
	 */
	public function setId($id){ $this->id = $id; }
	
	/** 
	 * Setter for Abbreviation
	 * @param string $abbreviation
	 */
	public function setAbbreviation($abbreviation){ $this->abbreviation = $abbreviation; }
	
	/** 
	 * Setter for Title
	 * @param string $title
	 */
	public function setTitle($title){ $this->title = $title; }
	
	/** 
	 * Setter for Subject
	 * @param string $subject
	 */
	public function setSubject($subject){ $this->subject = $subject; }
	
	/** 
	 * Setter for Type
	 * @param CourseType $type
	 */
	public function setType($type){ $this->type = $type; }
	
	/**
	 * Populate from an array.
	 *
	 * @param array $data
	 */
	public function populate($data = array()){
		if(!empty($data['id']))
			$this->setId($data['id']);
		$this->setAbbreviation($data['abbreviation']);
		$this->setSubject($data['subject']);
		$this->setType($data['type']);
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
				'name'       => 'id',
				'required'   => true,
				'filters' => array(
					array('name'    => 'Int'),
				),
			)));

			$inputFilter->add($factory->createInput(array(
				'name'       => 'title',
				'required'   => true,
				'filters' => array(
			        array('name' => 'StripTags'),
			        array('name' => 'StringTrim'),
				),
			)));

			$inputFilter->add($factory->createInput(array(
				'name'       => 'abbreviation',
				'required'   => true,
				'filters' => array(
			        array('name' => 'StripTags'),
			        array('name' => 'StringTrim'),
				),
			)));

			$inputFilter->add($factory->createInput(array(
				'name'       => 'subject',
				'required'   => true,
				'filters' => array(
			        array('name' => 'StripTags'),
			        array('name' => 'StringTrim'),
				),
			)));

			$this->inputFilter = $inputFilter;        
		}

		return $this->inputFilter;
	}
	
	public function __toString(){
		return $this->getAbbreviation() . " (" . $this->getTitle() . ")";
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
			"id" => $this->getId(),
			"title" => $this->getTitle(),
			"abbreviation" => $this->getAbbreviation(),
			"subject" => $this->getSubject(),
			"type" => $this->getType()
		);
		return $data;
	}
}
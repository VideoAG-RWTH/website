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
 * A Lecturer.
 *
 * @ORM\Entity
 * @ORM\Table(name="lecturer")
 * @property int $id
 * @property string $name
 * @property string $email
 */
class Lecturer implements InputFilterAwareInterface, JsonSerializable
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
	protected $name;
 	
	/**
	 * @ORM\Column(type="string");
	 */
	protected $email;
 	
	/**
	 * Getter for ID
	 * @return int
	 */
	public function getId(){ return $this->id; }

	/**
	 * Getter for Name
	 * @return string
	 */
	public function getName(){ return $this->name; }

	/**
	 * Getter for EMail
	 * @return string
	 */
	public function getEMail(){ return $this->email; }

	/** 
	 * Setter for ID
	 * @param int $id
	 */
	public function setId($id){ $this->id = $id; }
	
	/** 
	 * Setter for Name
	 * @param string $name
	 */
	public function setName($name){ $this->name = $name; }
	
	/** 
	 * Setter for EMail
	 * @param string $email
	 */
	public function setEMail($email){ $this->email = $email; }
	
	/**
	 * Populate from an array.
	 *
	 * @param array $data
	 */
	public function populate($data = array()){
		if(!empty($data['id']))
			$this->setId($data['id']);
		$this->setName($data['name']);
		$this->setEMail($data['email']);
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
				'name'       => 'name',
				'required'   => true,
				'filters' => array(
			        array('name' => 'StripTags'),
			        array('name' => 'StringTrim'),
				),
			)));

			$inputFilter->add($factory->createInput(array(
				'name'       => 'email',
				'required'   => true,
				'filters' => array(
			        array('name' => 'StripTags'),
			        array('name' => 'StringTrim'),
				),
	            'validators' => array(
	                array('name'    => 'EmailAddress'),
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
			"id" => $this->getId(),
			"name" => $this->getName(),
			"email" => $this->getEMail(),
		);
		return $data;
	}
}
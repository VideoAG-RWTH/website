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
 * A Video Quality.
 *
 * @ORM\Entity
 * @ORM\Table(name="video_quality")
 * @property int $id
 * @property string $name
 * @property int $height
 */
class VideoQuality implements InputFilterAwareInterface, JsonSerializable
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
	 * @ORM\Column(type="integer");
	 */
	protected $height;
 
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
	 * Getter for Height
	 * @return int
	 */
	public function getHeight(){ return $this->height; }
	
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
	 * Setter for Height
	 * @param int $height
	 */
	public function setHeight($height){ $this->height = $height; }
	
	/**
	 * Populate from an array.
	 *
	 * @param array $data
	 */
	public function populate($data = array()){
		if(!empty($data['id']))
			$this->setId($data['id']);
		$this->setName($data['name']);
		$this->setHeight($data['height']);
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
				'name'       => 'height',
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
			"height" => $this->getHeight()
		);
		return $data;
	}
}
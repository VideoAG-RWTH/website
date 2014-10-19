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
 * A Suggestable Item.
 *
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\Table(name="suggestable_item")
 * @property int $id
 */
class SuggestableItem implements InputFilterAwareInterface, JsonSerializable
{
	protected $inputFilter;
 	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer");
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
 	
	/**
	 * @ORM\Column(type="datetime");
	 */
	protected $suggested_at;
	
	/**
     * @ORM\ManyToOne(targetEntity="User")
	 * @ORM\JoinColumn(name="suggested_by_id", referencedColumnName="user_id")
	 */
	protected $suggested_by;
 
	/**
	 * Getter for Id
	 * @return int
	 */
	public function getId(){ return $this->id; }

	/**
	 * Getter for SuggestedAt
	 * @return DateTime
	 */
	public function getSuggestedAt(){ return $this->suggested_at; }

	/**
	 * Getter for SuggestedBy
	 * @return User
	 */
	public function getSuggestedBy(){ return $this->suggested_by; }
	
	/** 
	 * Setter for ID
	 * @param int $id
	 */
	public function setId($id){ $this->id = $id; }
	
	/** 
	 * Setter for SuggestedAt
	 * @param DateTime $suggested_at
	 */
	public function setSuggestedAt($suggested_at){ $this->suggested_at = $suggested_at; }
	
	/** 
	 * Setter for SuggestedBy
	 * @param User $suggested_by
	 */
	public function setSuggestedBy($suggested_by){ $this->suggested_by = $suggested_by; }
	
	/**
	 * Populate from an array.
	 *
	 * @param array $data
	 */
	public function populate($data = array()){
		if(!empty($data['id']))
			$this->setId($data['id']);
		$this->setSuggestedAt($data['suggested_at']);
		$this->setSuggestedBy($data['suggested_by']);
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
			"suggested_at" => $this->getSuggestedAt(),
			"suggested_by" => $this->getSuggestedBy()
		);
		return $data;
	}
}
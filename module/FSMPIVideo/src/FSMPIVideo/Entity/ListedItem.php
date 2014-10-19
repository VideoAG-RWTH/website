<?php
namespace FSMPIVideo\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface; 
use Zend\Json\Json;

use JsonSerializable;
use DateTime;

/**
 * A Listed Item.
 *
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\Table(name="listed_item")
 * @property int $id
 * @property string $alias
 * @property string $title
 * @property string $description
 * @property string $internal_comment
 * @property string $semester
 * @property User $created_by
 * @property string $created_at
 * @property User $super_admin
 * @property string $last_change
 * @property User $changed_by
 * @property boolean $is_downloadable
 * @property boolean $is_listed
 * @property boolean $is_accessable
 * @property string $access_type
 * @property array $responsible_users
 * @property string $responsible_text
 * @property string $username
 * @property string $password
 * @property string $thumbnail_image
 */
class ListedItem implements InputFilterAwareInterface, JsonSerializable
{
	protected $inputFilter;
 	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer");
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
 	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $alias;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $title;
	
	/**
	 * @ORM\Column(type="text")
	 */
	protected $description;
	
	/**
	 * @ORM\Column(type="text")
	 */
	protected $internal_comment;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $semester;
	
	/**
     * @ORM\ManyToOne(targetEntity="User")
	 * @ORM\JoinColumn(name="created_by_id", referencedColumnName="user_id")
	 */
	protected $created_by;
	
	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $created_at;
	
	/**
     * @ORM\ManyToOne(targetEntity="User")
	 * @ORM\JoinColumn(name="super_admin_id", referencedColumnName="user_id")
	 */
	protected $super_admin;
	
	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $last_change;
	
	/**
     * @ORM\ManyToOne(targetEntity="User")
	 * @ORM\JoinColumn(name="changed_by_id", referencedColumnName="user_id")
	 */
	protected $changed_by;
	
	/**
	 * @ORM\Column(type="boolean")
	 */
	protected $is_downloadable;
	
	/**
	 * @ORM\Column(type="boolean")
	 */
	protected $is_listed;
	
	/**
	 * @ORM\Column(type="boolean")
	 */
	protected $is_accessable;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $access_type;
	
	/**
     * @ORM\ManyToMany(targetEntity="User")
     * @ORM\JoinTable(name="listeditem_responsible_users",
	 *   joinColumns={
	 *     @ORM\JoinColumn(name="listeditem_id", referencedColumnName="id")
	 *   },
	 *   inverseJoinColumns={
	 *     @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
	 *   }
	 * )
	 */
	protected $responsible_users;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $responsible_text;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $username;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $password;
	
	/**
	 * @ORM\Column(type="text")
	 */
	protected $thumbnail_image;
	
	//---------------------------
	// GETTER
	//---------------------------
	/**
	 * @return int
	 */
	public function getId(){ return $this->id; }

	/**
	 * @return string
	 */
	public function getAlias(){ return $this->alias; }

	/**
	 * @return string
	 */
	public function getTitle(){ return $this->title; }

	/**
	 * @return string
	 */
	public function getDescription(){ return $this->description; }

	/**
	 * @return string
	 */
	public function getInternalComment(){ return $this->internal_comment; }

	/**
	 * @return string
	 */
	public function getSemester(){ return $this->semester; }

	/**
	 * @return User
	 */
	public function getCreatedBy(){ return $this->created_by; }

	/**
	 * @return DateTime
	 */
	public function getCreatedAt(){ return $this->created_at; }

	/**
	 * @return User
	 */
	public function getSuperAdmin(){ return $this->super_admin; }

	/**
	 * @return DateTime
	 */
	public function getLastChange(){ return $this->last_change; }

	/**
	 * @return User
	 */
	public function getChangedBy(){ return $this->changed_by; }

	/**
	 * @return boolean
	 */
	public function getIsDownloadable(){ return $this->is_downloadable; }

	/**
	 * @return boolean
	 */
	public function getIsListed(){ return $this->is_listed; }

	/**
	 * @return boolean
	 */
	public function getIsAccessable(){ return $this->is_accessable; }

	/**
	 * @return string
	 */
	public function getAccessType(){ return $this->access_type; }

	/**
	 * @return array
	 */
	public function getResponsibleUsers(){ return $this->responsible_users; }

	/**
	 * @return string
	 */
	public function getResponsibleText(){ return $this->responsible_text; }

	/**
	 * @return string
	 */
	public function getUsername(){ return $this->username; }

	/**
	 * @return string
	 */
	public function getPassword(){ return $this->password; }

	/**
	 * @return string
	 */
	public function getThumbnailImage(){ return $this->thumbnail_image; }
	
	//---------------------------
	// Setter
	//---------------------------
	
	/**
	 * @param int $id
	 */
	public function setId($id){ $this->id; }
	

	/**
	 * @param string $alias
	 */
	public function setAlias($alias){ $this->alias = $alias; }

	/**
	 * @param string $title
	 */
	public function setTitle($title){ $this->title = $title; }

	/**
	 * @param string $description
	 */
	public function setDescription($description){ $this->description = $description; }

	/**
	 * @param string $internal_comment
	 */
	public function setInternalComment($internal_comment){ $this->internal_comment = $internal_comment; }

	/**
	 * @param string $semester
	 */
	public function setSemester($semester){ $this->semester = $semester; }

	/**
	 * @param User $created_by
	 */
	public function setCreatedBy($created_by){ $this->created_by =  $created_by; }

	/**
	 * @param DateTime $created_at
	 */
	public function setCreatedAt($created_at){ $this->created_at = $created_at; }

	/**
	 * @param User $super_admin
	 */
	public function setSuperAdmin($super_admin){ $this->super_admin = $super_admin; }

	/**
	 * @param DateTime $last_change
	 */
	public function setLastChange($last_change){ $this->last_change = $last_change; }

	/**
	 * @param User $changed_by
	 */
	public function setChangedBy($changed_by){ $this->changed_by = $changed_by; }

	/**
	 * @param boolean $is_downloadable
	 */
	public function setIsDownloadable($is_downloadable){ $this->is_downloadable = $is_downloadable; }

	/**
	 * @param boolean $is_listed
	 */
	public function setIsListed($is_listed){ $this->is_listed = $is_downloadable; }

	/**
	 * @param boolean $is_accessable
	 */
	public function setIsAccessable($is_accessable){ $this->is_accessable = $is_accessable; }

	/**
	 * @param string $access_type
	 */
	public function setAccessType($access_type){ $this->access_type = $access_type; }

	/**
	 * @param string $responsible_text
	 */
	public function setResponsibleText($responsible_text){ $this->responsible_text = $responsible_text; }

	/**
	 * @param string $username
	 */
	public function setUsername($username){ $this->username = $username; }

	/**
	 * @param string $password
	 */
	public function setPassword($password){ $this->password = $password; }

	/**
	 * @param string $thumbnail_image
	 */
	public function setThumbnailImage($thumbnail_image){ $this->thumbnail_image = $thumbnail_image; }

	
	/**
	 * Populate from an array.
	 *
	 * @param array $data
	 */
	public function populate($data = array()){
		if(!empty($data['id']))
			$this->setId($data['id']);
		$this->setAlias($data['alias']);
		$this->setTitle($data['title']);
		$this->setDescription($data['description']);
		$this->setInternalComment($data['internal_comment']);
		$this->setSemester($data['semester']);
		$this->setCreatedBy($data['created_by']);
		$this->setCreatedAt($data['created_at']);
		$this->setSuperAdmin($data['super_admin']);
		$this->setLastChange($data['last_change']);
		$this->setChangedBy($data['changed_by']);
		$this->setIsDownloadable($data['is_downloadable']);
		$this->setIsListed($data['is_accessable']);
		$this->setIsAccessable($data['is_listed']);
		$this->setAccessType($data['access_type']);
		$this->setResponsibleText($data['responsible_text']);
		$this->setUsername($data['username']);
		$this->setPassword($data['password']);
		$this->setThumbnailImage($data['thumbnail_image']);
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
				'name'       => 'alias',
				'required'   => true,
				'filters' => array(
	                array('name' => 'StripTags'),
	                array('name' => 'StringTrim'),
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
				'name'       => 'description',
				'required'   => false,
				'filters' => array(
		            array('name' => 'StripTags'),
		            array('name' => 'StringTrim'),
				),
			)));

			$inputFilter->add($factory->createInput(array(
				'name'       => 'internal_comment',
				'required'   => false,
				'filters' => array(
			        array('name' => 'StripTags'),
			        array('name' => 'StringTrim'),
				),
			)));

			$inputFilter->add($factory->createInput(array(
				'name'       => 'semester',
				'required'   => true,
				'filters' => array(
			        array('name' => 'StripTags'),
			        array('name' => 'StringTrim'),
				),
			)));

			$inputFilter->add($factory->createInput(array(
				'name'       => 'access_type',
				'required'   => true,
				'filters' => array(
			        array('name' => 'StripTags'),
			        array('name' => 'StringTrim'),
				),
			)));

			$inputFilter->add($factory->createInput(array(
				'name'       => 'responsible_text',
				'required'   => true,
				'filters' => array(
			        array('name' => 'StripTags'),
			        array('name' => 'StringTrim'),
				),
			)));

			$inputFilter->add($factory->createInput(array(
				'name'       => 'is_downloadable',
				'required'   => true,
				'filters' => array(
			        array('name' => 'Boolean'),
				),
			)));

			$inputFilter->add($factory->createInput(array(
				'name'       => 'is_listed',
				'required'   => true,
				'filters' => array(
			        array('name' => 'Boolean'),
				),
			)));
		
			$inputFilter->add($factory->createInput(array(
				'name'       => 'is_accessable',
				'required'   => true,
				'filters' => array(
			        array('name' => 'Boolean'),
				),
			)));
			
			$inputFilter->add($factory->createInput(array(
				'name'       => 'username',
				'required'   => true,
				'filters' => array(
			        array('name' => 'StripTags'),
			        array('name' => 'StringTrim'),
				),
			)));

			$inputFilter->add($factory->createInput(array(
				'name'       => 'password',
				'required'   => true,
				'filters' => array(
			        array('name' => 'StripTags'),
			        array('name' => 'StringTrim'),
				),
			)));

			$inputFilter->add($factory->createInput(array(
				'name'       => 'thumbnail_image',
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
			"alias" => $this->getAlias(),
			"title" => $this->getTitle(),
			"description" => $this->getDescription(),
			"internal_comment" => $this->getInternalComment(),
			"semester" => $this->getSemester(),
			"created_by" => $this->getCreatedBy(),
			"created_at" => $this->getCreatedAt(),
			"super_admin" => $this->getSuperAdmin(),
			"last_change" => $this->getLastChange(),
			"changed_by" => $this->getChangedBy(),
			"is_downloadable" => $this->getIsDownloadable(),
			"is_listed" => $this->getIsListed(),
			"is_accessable" => $this->getIsAccessable(),
			"access_type" => $this->getAccessType(),
			"responsible_users" => $this->getResponsibleUsers(),
			"responsible_text" => $this->getResponsibleText(),
			"username" => $this->getUsername(),
			"password" => $this->getPassword(),
			"thumbnail_image" => $this->getThumbnailImage()
		);
		return $data;
	}
}
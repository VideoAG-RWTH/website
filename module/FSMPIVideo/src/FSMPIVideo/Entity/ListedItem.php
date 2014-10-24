<?php
namespace FSMPIVideo\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface; 
use Zend\Json\Json;

use Doctrine\Common\Collections\ArrayCollection;

use JsonSerializable;
use DateTime;

/**
 * A Listed Item.
 *
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\Table(name="listed_item")
 * @ORM\HasLifecycleCallbacks
 * @property int $id
 * @property string $alias
 * @property string $title
 * @property string $description
 * @property string $internalComment
 * @property string $semester
 * @property User $createdBy
 * @property DateTime $createdAt
 * @property User $superAdmin
 * @property DateTime $lastChange
 * @property User $changedBy
 * @property boolean $isDownloadable
 * @property boolean $isListed
 * @property boolean $isAccessable
 * @property string $accessType
 * @property array $responsibleUsers
 * @property string $responsibleText
 * @property string $username
 * @property string $password
 * @property string $thumbnailImage
 */
class ListedItem implements InputFilterAwareInterface, JsonSerializable
{
	protected $inputFilter;
 	
	public static function getAccessTypes(){
		return array('public' => 'Public', 'intern' => 'Intern', 'password' => 'Password');
	} 
	
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
	protected $internalComment;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $semester;
	
	/**
     * @ORM\ManyToOne(targetEntity="User")
	 * @ORM\JoinColumn(name="created_by_id", referencedColumnName="user_id")
	 */
	protected $createdBy;
	
	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $createdAt;
	
	/**
     * @ORM\ManyToOne(targetEntity="User")
	 * @ORM\JoinColumn(name="super_admin_id", referencedColumnName="user_id")
	 */
	protected $superAdmin;
	
	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $lastChange;
	
	/**
     * @ORM\ManyToOne(targetEntity="User")
	 * @ORM\JoinColumn(name="changed_by_id", referencedColumnName="user_id")
	 */
	protected $changedBy;
	
	/**
	 * @ORM\Column(type="boolean")
	 */
	protected $isDownloadable;
	
	/**
	 * @ORM\Column(type="boolean")
	 */
	protected $isListed;
	
	/**
	 * @ORM\Column(type="boolean")
	 */
	protected $isAccessable;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $accessType;
	
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
	protected $responsibleUsers;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $responsibleText;
	
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
	protected $thumbnailImage;
	
	
	public function __construct(){
		$this->responsibleUsers = new ArrayCollection;
	}
	
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
	public function getInternalComment(){ return $this->internalComment; }

	/**
	 * @return string
	 */
	public function getSemester(){ return $this->semester; }

	/**
	 * @return User
	 */
	public function getCreatedBy(){ return $this->createdBy; }

	/**
	 * @return DateTime
	 */
	public function getCreatedAt(){ return $this->createdAt; }

	/**
	 * @return User
	 */
	public function getSuperAdmin(){ return $this->superAdmin; }

	/**
	 * @return DateTime
	 */
	public function getLastChange(){ return $this->lastChange; }

	/**
	 * @return User
	 */
	public function getChangedBy(){ return $this->changedBy; }

	/**
	 * @return boolean
	 */
	public function getIsDownloadable(){ return $this->isDownloadable; }

	/**
	 * @return boolean
	 */
	public function getIsListed(){ return $this->isListed; }

	/**
	 * @return boolean
	 */
	public function getIsAccessable(){ return $this->isAccessable; }

	/**
	 * @return string
	 */
	public function getAccessType(){ return $this->accessType; }

	/**
	 * @return array
	 */
	public function getResponsibleUsers(){ return $this->responsibleUsers; }

	/**
	 * @return string
	 */
	public function getResponsibleText(){ return $this->responsibleText; }

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
	public function getThumbnailImage(){ return $this->thumbnailImage; }
	
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
	 * @param string $internalComment
	 */
	public function setInternalComment($internalComment){ $this->internalComment = $internalComment; }

	/**
	 * @param string $semester
	 */
	public function setSemester($semester){ $this->semester = $semester; }

	/**
	 * @param User $createdBy
	 */
	public function setCreatedBy($createdBy){ $this->createdBy =  $createdBy; }

	/**
	 * @param DateTime $createdAt
	 */
	public function setCreatedAt($createdAt){ $this->createdAt = $createdAt; }

	/**
	 * @param User $superAdmin
	 */
	public function setSuperAdmin($superAdmin){ $this->superAdmin = $superAdmin; }

	/**
	 * @param DateTime $lastChange
	 */
	public function setLastChange($lastChange){ $this->lastChange = $lastChange; }

	/**
	 * @param User $changedBy
	 */
	public function setChangedBy($changedBy){ $this->changedBy = $changedBy; }

	/**
	 * @param boolean $isDownloadable
	 */
	public function setIsDownloadable($isDownloadable){ $this->isDownloadable = $isDownloadable; }

	/**
	 * @param boolean $isListed
	 */
	public function setIsListed($isListed){ $this->isListed = $isListed; }

	/**
	 * @param boolean $isAccessable
	 */
	public function setIsAccessable($isAccessable){ $this->isAccessable = $isAccessable; }

	/**
	 * @param string $accessType
	 */
	public function setAccessType($accessType){ $this->accessType = $accessType; }

	/**
	 * @param string $responsibleText
	 */
	public function setResponsibleText($responsibleText){ $this->responsibleText = $responsibleText; }

	/**
	 * @param string $username
	 */
	public function setUsername($username){ $this->username = $username; }

	/**
	 * @param string $password
	 */
	public function setPassword($password){ $this->password = $password; }

	/**
	 * @param string $thumbnailImage
	 */
	public function setThumbnailImage($thumbnailImage){ $this->thumbnailImage = $thumbnailImage; }
	
	public function addResponsibleUsers($users){
		foreach($users as $user)
			$this->responsibleUsers->add($user);
	}

	public function removeResponsibleUsers($users){
		foreach($users as $user)
			$this->responsibleUsers->removeElement($user);
	}
	
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
		$this->setInternalComment($data['internalComment']);
		$this->setSemester($data['semester']);
		$this->setCreatedBy($data['createdBy']);
		$this->setCreatedAt($data['createdAt']);
		$this->setSuperAdmin($data['superAdmin']);
		$this->setLastChange($data['lastChange']);
		$this->setChangedBy($data['changedBy']);
		$this->setIsDownloadable($data['isDownloadable']);
		$this->setIsListed($data['isAccessable']);
		$this->setIsAccessable($data['isListed']);
		$this->setAccessType($data['accessType']);
		$this->setResponsibleText($data['responsibleText']);
		$this->setUsername($data['username']);
		$this->setPassword($data['password']);
		$this->setThumbnailImage($data['thumbnailImage']);
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
				'name'       => 'alias',
				'required'   => false,
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
				'name'       => 'internalComment',
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
				'name'       => 'accessType',
				'required'   => true,
				'filters' => array(
			        array('name' => 'StripTags'),
			        array('name' => 'StringTrim'),
				),
			)));

			$inputFilter->add($factory->createInput(array(
				'name'       => 'createdAt',
				'required'   => false,
			)));
			
			$inputFilter->add($factory->createInput(array(
				'name'       => 'responsibleUsers',
				'required'   => false,
			)));
		
			$inputFilter->add($factory->createInput(array(
				'name'       => 'createdBy',
				'required'   => false,
			)));

			$inputFilter->add($factory->createInput(array(
				'name'       => 'lastChange',
				'required'   => false,
			)));

			$inputFilter->add($factory->createInput(array(
				'name'       => 'changedBy',
				'required'   => false,
			)));

			$inputFilter->add($factory->createInput(array(
				'name'       => 'responsibleText',
				'required'   => false,
				'filters' => array(
			        array('name' => 'StripTags'),
			        array('name' => 'StringTrim'),
				),
			)));

			$inputFilter->add($factory->createInput(array(
				'name'       => 'isDownloadable',
				'required'   => true,
				'filters' => array(
			        array('name' => 'Boolean'),
				),
			)));

			$inputFilter->add($factory->createInput(array(
				'name'       => 'isListed',
				'required'   => true,
				'filters' => array(
			        array('name' => 'Boolean'),
				),
			)));
		
			$inputFilter->add($factory->createInput(array(
				'name'       => 'isAccessable',
				'required'   => true,
				'filters' => array(
			        array('name' => 'Boolean'),
				),
			)));
			
			$inputFilter->add($factory->createInput(array(
				'name'       => 'accessType',
				'required'   => true,
				'filters' => array(
			        array('name' => 'StripTags'),
			        array('name' => 'StringTrim'),
				),
				'validators' => array(
					array(
						'name' => 'InArray',
						'options' => array(
							'haystack' => array_keys(self::getAccessTypes()),
							'strict' => 'false'
						)
					),
				),
			)));
			
			$inputFilter->add($factory->createInput(array(
				'name'       => 'username',
				'required'   => false,
				'filters' => array(
			        array('name' => 'StripTags'),
			        array('name' => 'StringTrim'),
				),
			)));

			$inputFilter->add($factory->createInput(array(
				'name'       => 'password',
				'required'   => false,
				'filters' => array(
			        array('name' => 'StripTags'),
			        array('name' => 'StringTrim'),
				),
			)));

			$inputFilter->add($factory->createInput(array(
				'name'       => 'thumbnailImage',
				'required'   => false,
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
	 * @ORM\PrePersist
	 */
	public function prePersist(){
		if(empty($this->getAlias()))
			$this->setAlias($this->_generateAlias($this->getTitle()));
		
		$this->setCreatedAt(new DateTime());
		$this->setLastChange(new DateTime());
	}

	/**
	 * @ORM\PreUpdate
	 */
	public function preUpdate(){
		if(empty($this->getAlias()))
			$this->setAlias($this->_generateAlias($this->getTitle()));
		$this->setLastChange(new DateTime());
		
		if(!$this->zfcUserAuthentication()->hasIdentity()){
			return;
		}
		
		$identity = $this->zfcUserAuthentication()->getIdentity();
		
		$this->setChangedBy($identity);
	}
	
	protected static function _generateAlias($title){
		$res = strtolower($title);
		$res = preg_replace("/\s/", "-", $res);
		$res = iconv('UTF-8', 'ASCII//TRANSLIT', $res);
		return $res;
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
			"internalComment" => $this->getInternalComment(),
			"semester" => $this->getSemester(),
			"createdBy" => $this->getCreatedBy(),
			"createdAt" => $this->getCreatedAt(),
			"superAdmin" => $this->getSuperAdmin(),
			"lastChange" => $this->getLastChange(),
			"changedBy" => $this->getChangedBy(),
			"isDownloadable" => $this->getIsDownloadable(),
			"isListed" => $this->getIsListed(),
			"isAccessable" => $this->getIsAccessable(),
			"accessType" => $this->getAccessType(),
			"responsibleUsers" => $this->getResponsibleUsers(),
			"responsibleText" => $this->getResponsibleText(),
			"username" => $this->getUsername(),
			"password" => $this->getPassword(),
			"thumbnailImage" => $this->getThumbnailImage()
		);
		return $data;
	}
}
<?php
namespace FSMPIVideo\Entity;

use ZfcUser\Entity\User as ZfcUserEntity;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Zend\Json\Json;

/**
 * A User.
 *
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends ZfcUserEntity implements JsonSerializable
{
	const ROLE_ADMIN = 10;
	const ROLE_MODERATOR = 20;
	const ROLE_REPORTER = 30;
	
	public static function getAllowedRoles(){
		return self::$allowedRoles;
	}
	
	protected static $allowedRoles = array(
		self::ROLE_ADMIN => 'Admin', 
		self::ROLE_MODERATOR => 'Moderator', 
		self::ROLE_REPORTER => 'Reporter'
	);

	/**
	 * @ORM\Column(type="integer")
	 */
	public $role;

	/**
	 * @ORM\Column(type="string")
	 */
	public $jabber;

	/**
	 * @ORM\Column(type="string")
	 */
	public $phone;

	/**
	 * @ORM\Column(type="string")
	 */
	public $codedDirectory;

    /**
     * @var int
     */
    protected $state;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="FSMPIVideo\Entity\Role")
     * @ORM\JoinTable(name="user_role_linker",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="user_id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     * )
     */
    protected $roles;
	
    /**
     * Initialies the roles variable.
     */
    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }

    /**
     * Get role.
     *
     * @return int
     */
	public function getRole(){ return $this->role; }

    /**
     * Get role name.
     *
     * @return string
     */
	public function getRoleName(){ 
		if(array_key_exists($this->role, self::$allowedRoles)) 
			return self::$allowedRoles[$this->role]; 
		return "";
	}

    /**
     * Get jabber.
     *
     * @return string
     */
	public function getJabber(){ return $this->jabber; }

    /**
     * Get phone.
     *
     * @return string
     */
	public function getPhone(){ return $this->phone; }

    /**
     * Get coded directory.
     *
     * @return string
     */
	public function getCodedDirectory(){ return $this->codedDirectory; }

    /**
     * Set role.
     *
     * @param int $role
     * @return UserInterface
     */
	public function setRole($role){ $this->role = $role; return $this; }

    /**
     * Set jabber.
     *
     * @param string $jabber
     * @return UserInterface
     */
	public function setJabber($jabber){ $this->jabber = $jabber; return $this; }

    /**
     * Set phone.
     *
     * @param string $phone
     * @return UserInterface
     */
	public function setPhone($phone){ $this->phone = $phone; return $this; }

    /**
     * Set coded directory.
     *
     * @param string $codedDirectory
     * @return UserInterface
     */
	public function setCodedDirectory($codedDirectory){ $this->codedDirectory = $codedDirectory; return $this; }

    /**
     * Get state.
     *
     * @return int
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set state.
     *
     * @param int $state
     *
     * @return void
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * Get role.
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->roles->getValues();
    }

    /**
     * Add a role to the user.
     *
     * @param Role $role
     *
     * @return void
     */
    public function addRole($role)
    {
        $this->roles[] = $role;
    }
	
	
	public function getArrayCopy(){
		return $this->jsonSerialize();
	}
	
	public function __toString(){
		return $this->getDisplayName();
	}
	
	public function toJson(){
		$data = $this->jsonSerialize();
		return Json::encode($data, true, array('silenceCyclicalExceptions' => true));
	}
	
	public function jsonSerialize(){
		$data = array(
			'user_id' => $this->getId(),
			'username' => $this->getUsername(),
			'email' => $this->getEmail(),
			'displayname' => $this->getDisplayName(),
			'state' => $this->getState(),
			'role' => $this->getRole(),
			'jabber' => $this->getJabber(),
			'phone' => $this->getPhone(),
			'codedDirectory' => $this->getCodedDirectory(),
		);
		return $data;
	}
}

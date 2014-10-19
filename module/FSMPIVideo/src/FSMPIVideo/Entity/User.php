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
	private $roles = array('Reporter', 'Moderator', 'Admin');

	/**
	 * @ORM\Column(type="string")
	 */
	public $role;
	

    /**
     * Get role.
     *
     * @return string
     */
    public function getRole(){
        return $this->role;
    }

    /**
     * Set role.
     *
     * @param string $role
     * @return UserInterface
     */
    public function setRole($role){
        $this->role = $role;
        return $this;
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
		);
		return $data;
	}
}

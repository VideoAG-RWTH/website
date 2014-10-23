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
 * A Video.
 *
 * @ORM\Entity
 * @ORM\Table(name="video")
 * @property int $id
 * @property Event $event
 * @property User $sourceUser
 * @property float $lengthSeconds
 * @property int $height
 * @property int $width
 * @property float $aspectRatio
 * @property float $framerate
 * @property string $codecs
 * @property VideoQuality $quality
 * @property float $speed
 * @property string $hash
 * @property User $assignedBy
 * @property DateTime $assignedAt
 * @property string $filename
 * @property string $titleThumbnail
 * @property string $modaicFile
 * @property string $webvttFile
 */
class Video implements InputFilterAwareInterface, JsonSerializable
{
	protected $inputFilter;
 	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer");
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
     * @ORM\ManyToOne(targetEntity="Event")
	 * @ORM\JoinColumn(name="event_id", referencedColumnName="id")
	 */
	protected $event;

	/**
     * @ORM\ManyToOne(targetEntity="User")
	 * @ORM\JoinColumn(name="sourceUser_id", referencedColumnName="user_id")
	 */
	protected $sourceUser;

	/**
	 * @ORM\Column(type="float");
	 */
	protected $lengthSeconds;

	/**
	 * @ORM\Column(type="integer");
	 */
	protected $height;

	/**
	 * @ORM\Column(type="integer");
	 */
	protected $width;

	/**
	 * @ORM\Column(type="float");
	 */
	protected $aspectRatio;

	/**
	 * @ORM\Column(type="float");
	 */
	protected $framerate;

	/**
	 * @ORM\Column(type="text");
	 */
	protected $codecs;

	/**
     * @ORM\ManyToOne(targetEntity="VideoQuality")
	 * @ORM\JoinColumn(name="quality_id", referencedColumnName="id")
	 */
	protected $quality;

	/**
	 * @ORM\Column(type="float");
	 */
	protected $speed;

	/**
	 * @ORM\Column(type="text");
	 */
	protected $hash;

	/**
     * @ORM\ManyToOne(targetEntity="User")
	 * @ORM\JoinColumn(name="assignedBy_id", referencedColumnName="user_id")
	 */
	protected $assignedBy;

	/**
	 * @ORM\Column(type="datetime");
	 */
	protected $assignedAt;
 
	/**
	 * @ORM\Column(type="text");
	 */
	protected $filename;
 
	/**
	 * @ORM\Column(type="text");
	 */
	protected $titleThumbnail;
 
	/**
	 * @ORM\Column(type="text");
	 */
	protected $mosaic_file;
 
	/**
	 * @ORM\Column(type="text");
	 */
	protected $webvttFile;
 
	/**
	 * Getter for ID
	 * @return int
	 */
	public function getId(){ return $this->id; }

	/**
	 * Getter for Event
	 * @return Event
	 */
	public function getEvent(){ return $this->event; }

	/**
	 * Getter for SourceUser
	 * @return User
	 */
	public function getSourceUser(){ return $this->sourceUser; }

	/**
	 * Getter for LengthSeconds
	 * @return int
	 */
	public function getLengthSeconds(){ return $this->lengthSeconds; }

	/**
	 * Getter for Height
	 * @return int
	 */
	public function getHeight(){ return $this->height; }

	/**
	 * Getter for Width
	 * @return int
	 */
	public function getWidth(){ return $this->width; }

	/**
	 * Getter for AspectRatio
	 * @return float
	 */
	public function getAspectRatio(){ return $this->aspectRatio; }

	/**
	 * Getter for Framerate
	 * @return float
	 */
	public function getFramerate(){ return $this->framerate; }

	/**
	 * Getter for Codecs
	 * @return string
	 */
	public function getCodecs(){ return $this->codecs; }

	/**
	 * Getter for Quality
	 * @return VideoQuality
	 */
	public function getQuality(){ return $this->quality; }

	/**
	 * Getter for Speed
	 * @return float
	 */
	public function getSpeed(){ return $this->speed; }

	/**
	 * Getter for Hash
	 * @return string
	 */
	public function getHash(){ return $this->hash; }

	/**
	 * Getter for AssignedBy
	 * @return User
	 */
	public function getAssignedBy(){ return $this->assignedBy; }

	/**
	 * Getter for AssignedAt
	 * @return DateTime
	 */
	public function getAssignedAt(){ return $this->assignedAt; }

	/**
	 * Getter for Filename
	 * @return string
	 */
	public function getFilename(){ return $this->filename; }

	/**
	 * Getter for TitleThumbnail
	 * @return string
	 */
	public function getTitleThumbnail(){ return $this->titleThumbnail; }

	/**
	 * Getter for MosaicFile
	 * @return string
	 */
	public function getMosaicFile(){ return $this->mosaic_file; }

	/**
	 * Getter for WebVTTFile
	 * @return string
	 */
	public function getWebVTTFile(){ return $this->webvttFile; }
	
	
	
	
	
	
	/** 
	 * Setter for ID
	 * @param int $id
	 */
	public function setId($id){ $this->id = $id; }
	
	/** 
	 * Setter for Event
	 * @param Event $event
	 */
	public function setEvent($event){ $this->event = $event; }
	
	/** 
	 * Setter for SourceUser
	 * @param User $sourceUser
	 */
	public function setSourceUser($sourceUser){ $this->sourceUser = $sourceUser; }
	
	/** 
	 * Setter for LengthSeconds
	 * @param float $lengthSeconds
	 */
	public function setLengthSeconds($lengthSeconds){ $this->lengthSeconds = $lengthSeconds; }
	
	/** 
	 * Setter for Height
	 * @param int $height
	 */
	public function setHeight($height){ $this->height = $height; }
	
	/** 
	 * Setter for Width
	 * @param int $width
	 */
	public function setWidth($width){ $this->width = $width; }
	
	/** 
	 * Setter for AspectRatio
	 * @param float $aspectRatio
	 */
	public function setAspectRatio($aspectRatio){ $this->aspectRatio = $aspectRatio; }
	
	/** 
	 * Setter for Framerate
	 * @param float $framerate
	 */
	public function setFramerate($framerate){ $this->framerate = $framerate; }
	
	/** 
	 * Setter for Codecs
	 * @param string $codecs
	 */
	public function setCodecs($codecs){ $this->codecs = $codecs; }
	
	/** 
	 * Setter for Quality
	 * @param VideoQuality $quality
	 */
	public function setQuality($quality){ $this->quality = $quality; }
	
	/** 
	 * Setter for Speed
	 * @param float $speed
	 */
	public function setSpeed($speed){ $this->speed = $speed; }
	
	/** 
	 * Setter for Hash
	 * @param string $hash
	 */
	public function setHash($hash){ $this->hash = $hash; }
	
	/** 
	 * Setter for AssignedBy
	 * @param User $assignedBy
	 */
	public function setAssignedBy($assignedBy){ $this->assignedBy = $assignedBy; }
	
	/** 
	 * Setter for AssignedAt
	 * @param DateTime $assignedAt
	 */
	public function setAssignedAt($assignedAt){ $this->assignedAt = $assignedAt; }
	
	/** 
	 * Setter for Filename
	 * @param string $filename
	 */
	public function setFilename($filename){ $this->filename = $filename; }
	
	/** 
	 * Setter for TitleThumbnail
	 * @param string $titleThumbnail
	 */
	public function setTitleThumbnail($titleThumbnail){ $this->titleThumbnail = $titleThumbnail; }
	
	/** 
	 * Setter for MosaicFile
	 * @param string $mosaic_file
	 */
	public function setMosaicFile($mosaic_file){ $this->mosaic_file = $mosaic_file; }
	
	/** 
	 * Setter for WebVTTFile
	 * @param string $webvttFile
	 */
	public function setWebVTTFile($webvttFile){ $this->webvttFile = $webvttFile; }
	
	/**
	 * Populate from an array.
	 *
	 * @param array $data
	 */
	public function populate($data = array()){
		if(!empty($data['id']))
			$this->setId($data['id']);
		$this->setId($data['event']);
		$this->setSourceUser($data['sourceUser']);
		$this->setLengthSeconds($data['lengthSeconds']);
		$this->setHeight($data['height']);
		$this->setWidth($data['width']);
		$this->setAspectRatio($data['aspectRatio']);
		$this->setFramerate($data['framerate']);
		$this->setCodecs($data['codecs']);
		$this->setQuality($data['quality']);
		$this->setSpeed($data['speed']);
		$this->setHash($data['hash']);
		$this->setAssignedBy($data['assignedBy']);
		$this->setAssignedAt($data['assignedAt']);
		$this->setFilename($data['filename']);
		$this->setTitleThumbnail($data['titleThumbnail']);
		$this->setMosaicFile($data['modaicFile']);
		$this->setWebVTTFile($data['webvttFile']);
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
				'name'       => 'lengthSeconds',
				'required'   => true,
				'validators' => array(
					array('name'    => 'Float'),
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
				'name'       => 'width',
				'required'   => true,
				'filters' => array(
					array('name'    => 'Int'),
				),
			)));

			$inputFilter->add($factory->createInput(array(
				'name'       => 'aspectRatio',
				'required'   => true,
				'validators' => array(
					array('name'    => 'Float'),
				),
			)));

			$inputFilter->add($factory->createInput(array(
				'name'       => 'framerate',
				'required'   => true,
				'validators' => array(
					array('name'    => 'Float'),
				),
			)));

			$inputFilter->add($factory->createInput(array(
				'name'       => 'speed',
				'required'   => true,
				'validators' => array(
					array('name'    => 'Float'),
				),
			)));

			$inputFilter->add($factory->createInput(array(
				'name'       => 'codecs',
				'required'   => true,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
			)));

			$inputFilter->add($factory->createInput(array(
				'name'       => 'hash',
				'required'   => true,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
			)));

			$inputFilter->add($factory->createInput(array(
				'name'       => 'filename',
				'required'   => true,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
			)));

			$inputFilter->add($factory->createInput(array(
				'name'       => 'titleThumbnail',
				'required'   => true,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
			)));

			$inputFilter->add($factory->createInput(array(
				'name'       => 'modaicFile',
				'required'   => true,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
			)));

			$inputFilter->add($factory->createInput(array(
				'name'       => 'webvttFile',
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
			"event" => $this->getEvent(),
			"sourceUser" => $this->getSourceUser(),
			"lengthSeconds" => $this->getLengthSeconds(),
			"height" => $this->getHeight(),
			"width" => $this->getWidth(),
			"aspectRatio" => $this->getAspectRatio(),
			"framerate" => $this->getFramerate(),
			"codecs" => $this->getCodecs(),
			"quality" => $this->getQuality(),
			"speed" => $this->getSpeed(),
			"hash" => $this->getHash(),
			"assignedBy" => $this->getAssignedBy(),
			"assignedAt" => $this->getAssignedAt(),
			"filename" => $this->getFilename(),
			"titleThumbnail" => $this->getTitleThumbnail(),
			"modaicFile" => $this->getMosaicFile(),
			"webvttFile" => $this->getWebVTTFile(),
		);
		return $data;
	}
}
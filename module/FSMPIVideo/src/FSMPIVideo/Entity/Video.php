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
 * @property User $source_user
 * @property float $length_seconds
 * @property int $height
 * @property int $width
 * @property float $aspect_ratio
 * @property float $framerate
 * @property string $codecs
 * @property VideoQuality $quality
 * @property float $speed
 * @property string $hash
 * @property User $assigned_by
 * @property DateTime $assigned_at
 * @property string $filename
 * @property string $title_thumbnail
 * @property string $modaic_file
 * @property string $webvtt_file
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
	 * @ORM\JoinColumn(name="source_user_id", referencedColumnName="user_id")
	 */
	protected $source_user;

	/**
	 * @ORM\Column(type="float");
	 */
	protected $length_seconds;

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
	protected $aspect_ratio;

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
	 * @ORM\JoinColumn(name="assigned_by_id", referencedColumnName="user_id")
	 */
	protected $assigned_by;

	/**
	 * @ORM\Column(type="datetime");
	 */
	protected $assigned_at;
 
	/**
	 * @ORM\Column(type="text");
	 */
	protected $filename;
 
	/**
	 * @ORM\Column(type="text");
	 */
	protected $title_thumbnail;
 
	/**
	 * @ORM\Column(type="text");
	 */
	protected $mosaic_file;
 
	/**
	 * @ORM\Column(type="text");
	 */
	protected $webvtt_file;
 
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
	public function getSourceUser(){ return $this->source_user; }

	/**
	 * Getter for LengthSeconds
	 * @return int
	 */
	public function getLengthSeconds(){ return $this->length_seconds; }

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
	public function getAspectRatio(){ return $this->aspect_ratio; }

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
	public function getAssignedBy(){ return $this->assigned_by; }

	/**
	 * Getter for AssignedAt
	 * @return DateTime
	 */
	public function getAssignedAt(){ return $this->assigned_at; }

	/**
	 * Getter for Filename
	 * @return string
	 */
	public function getFilename(){ return $this->filename; }

	/**
	 * Getter for TitleThumbnail
	 * @return string
	 */
	public function getTitleThumbnail(){ return $this->title_thumbnail; }

	/**
	 * Getter for MosaicFile
	 * @return string
	 */
	public function getMosaicFile(){ return $this->mosaic_file; }

	/**
	 * Getter for WebVTTFile
	 * @return string
	 */
	public function getWebVTTFile(){ return $this->webvtt_file; }
	
	
	
	
	
	
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
	 * @param User $source_user
	 */
	public function setSourceUser($source_user){ $this->source_user = $source_user; }
	
	/** 
	 * Setter for LengthSeconds
	 * @param float $length_seconds
	 */
	public function setLengthSeconds($length_seconds){ $this->length_seconds = $length_seconds; }
	
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
	 * @param float $aspect_ratio
	 */
	public function setAspectRatio($aspect_ratio){ $this->aspect_ratio = $aspect_ratio; }
	
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
	 * @param User $assigned_by
	 */
	public function setAssignedBy($assigned_by){ $this->assigned_by = $assigned_by; }
	
	/** 
	 * Setter for AssignedAt
	 * @param DateTime $assigned_at
	 */
	public function setAssignedAt($assigned_at){ $this->assigned_at = $assigned_at; }
	
	/** 
	 * Setter for Filename
	 * @param string $filename
	 */
	public function setFilename($filename){ $this->filename = $filename; }
	
	/** 
	 * Setter for TitleThumbnail
	 * @param string $title_thumbnail
	 */
	public function setTitleThumbnail($title_thumbnail){ $this->title_thumbnail = $title_thumbnail; }
	
	/** 
	 * Setter for MosaicFile
	 * @param string $mosaic_file
	 */
	public function setMosaicFile($mosaic_file){ $this->mosaic_file = $mosaic_file; }
	
	/** 
	 * Setter for WebVTTFile
	 * @param string $webvtt_file
	 */
	public function setWebVTTFile($webvtt_file){ $this->webvtt_file = $webvtt_file; }
	
	/**
	 * Populate from an array.
	 *
	 * @param array $data
	 */
	public function populate($data = array()){
		if(!empty($data['id']))
			$this->setId($data['id']);
		$this->setId($data['event']);
		$this->setSourceUser($data['source_user']);
		$this->setLengthSeconds($data['length_seconds']);
		$this->setHeight($data['height']);
		$this->setWidth($data['width']);
		$this->setAspectRatio($data['aspect_ratio']);
		$this->setFramerate($data['framerate']);
		$this->setCodecs($data['codecs']);
		$this->setQuality($data['quality']);
		$this->setSpeed($data['speed']);
		$this->setHash($data['hash']);
		$this->setAssignedBy($data['assigned_by']);
		$this->setAssignedAt($data['assigned_at']);
		$this->setFilename($data['filename']);
		$this->setTitleThumbnail($data['title_thumbnail']);
		$this->setMosaicFile($data['modaic_file']);
		$this->setWebVTTFile($data['webvtt_file']);
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
				'name'       => 'length_seconds',
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
				'name'       => 'aspect_ratio',
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
				'name'       => 'title_thumbnail',
				'required'   => true,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
			)));

			$inputFilter->add($factory->createInput(array(
				'name'       => 'modaic_file',
				'required'   => true,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
			)));

			$inputFilter->add($factory->createInput(array(
				'name'       => 'webvtt_file',
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
			"source_user" => $this->getSourceUser(),
			"length_seconds" => $this->getLengthSeconds(),
			"height" => $this->getHeight(),
			"width" => $this->getWidth(),
			"aspect_ratio" => $this->getAspectRatio(),
			"framerate" => $this->getFramerate(),
			"codecs" => $this->getCodecs(),
			"quality" => $this->getQuality(),
			"speed" => $this->getSpeed(),
			"hash" => $this->getHash(),
			"assigned_by" => $this->getAssignedBy(),
			"assigned_at" => $this->getAssignedAt(),
			"filename" => $this->getFilename(),
			"title_thumbnail" => $this->getTitleThumbnail(),
			"modaic_file" => $this->getMosaicFile(),
			"webvtt_file" => $this->getWebVTTFile(),
		);
		return $data;
	}
}
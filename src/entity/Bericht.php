<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bericht
 *
 * @ORM\Table(name="berichten")
 * @ORM\Entity
 */
class Bericht
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="berichten_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="old_id", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $oldId;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="text", precision=0, scale=0, nullable=true, unique=false)
     */
    private $body;

    /**
     * @var string
     *
     * @ORM\Column(name="advice", type="text", precision=0, scale=0, nullable=true, unique=false)
     */
    private $advice;

    /**
     * @var string
     *
     * @ORM\Column(name="title_en", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $title_en;

    /**
     * @var string
     *
     * @ORM\Column(name="body_en", type="text", precision=0, scale=0, nullable=true, unique=false)
     */
    private $body_en;

    /**
     * @var string
     *
     * @ORM\Column(name="advice_en", type="text", precision=0, scale=0, nullable=true, unique=false)
     */
    private $advice_en;

    /**
     * @var string
     *
     * @ORM\Column(name="title_fr", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $title_fr;

    /**
     * @var string
     *
     * @ORM\Column(name="body_fr", type="text", precision=0, scale=0, nullable=true, unique=false)
     */
    private $body_fr;

    /**
     * @var string
     *
     * @ORM\Column(name="advice_fr", type="text", precision=0, scale=0, nullable=true, unique=false)
     */
    private $advice_fr;

    /**
     * @var string
     *
     * @ORM\Column(name="title_de", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $title_de;

    /**
     * @var string
     *
     * @ORM\Column(name="body_de", type="text", precision=0, scale=0, nullable=true, unique=false)
     */
    private $body_de;

    /**
     * @var string
     *
     * @ORM\Column(name="advice_de", type="text", precision=0, scale=0, nullable=true, unique=false)
     */
    private $advice_de;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startdate", type="date", precision=0, scale=0, nullable=false, unique=false)
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="enddate", type="date", precision=0, scale=0, nullable=false, unique=false)
     */
    private $endDdate;

    /**
     * @var string
     *
     * @ORM\Column(name="category", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $link;

    /**
     * @var string
     *
     * @ORM\Column(name="image_url", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $imageUrl;

    /**
     * @var boolean
     *
     * @ORM\Column(name="important", type="boolean", precision=0, scale=0, nullable=false, unique=false)
     */
    private $important;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_live", type="boolean", precision=0, scale=0, nullable=false, unique=false)
     */
    private $isLive;

    /**
     * @var boolean
     *
     * @ORM\Column(name="include_map", type="boolean", precision=0, scale=0, nullable=false, unique=false)
     */
    private $includeMap;

    /**
     * @var string
     *
     * @ORM\Column(name="location_lat", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $locationLat;

    /**
     * @var string
     *
     * @ORM\Column(name="location_lng", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $locationLng;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Bericht
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set oldId
     *
     * @param string $oldId
     *
     * @return Bericht
     */
    public function setOldId($oldId)
    {
        $this->oldId = $oldId;

        return $this;
    }

    /**
     * Get oldId
     *
     * @return string
     */
    public function getOldId()
    {
        return $this->oldId;
    }

    /**
     * Set body
     *
     * @param string $body
     *
     * @return Bericht
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set advice
     *
     * @param string $advice
     *
     * @return Bericht
     */
    public function setAdvice($advice)
    {
        $this->advice = $advice;

        return $this;
    }

    /**
     * Get advice
     *
     * @return string
     */
    public function getAdvice()
    {
        return $this->advice;
    }

    /**
     * Set titleEn
     *
     * @param string $titleEn
     *
     * @return Bericht
     */
    public function setTitleEn($titleEn)
    {
        $this->title_en = $titleEn;

        return $this;
    }

    /**
     * Get titleEn
     *
     * @return string
     */
    public function getTitleEn()
    {
        return $this->title_en;
    }

    /**
     * Set bodyEn
     *
     * @param string $bodyEn
     *
     * @return Bericht
     */
    public function setBodyEn($bodyEn)
    {
        $this->body_en = $bodyEn;

        return $this;
    }

    /**
     * Get bodyEn
     *
     * @return string
     */
    public function getBodyEn()
    {
        return $this->body_en;
    }

    /**
     * Set adviceEn
     *
     * @param string $adviceEn
     *
     * @return Bericht
     */
    public function setAdviceEn($adviceEn)
    {
        $this->advice_en = $adviceEn;

        return $this;
    }

    /**
     * Get adviceEn
     *
     * @return string
     */
    public function getAdviceEn()
    {
        return $this->advice_en;
    }

    /**
     * Set titleFr
     *
     * @param string $titleFr
     *
     * @return Bericht
     */
    public function setTitleFr($titleFr)
    {
        $this->title_fr = $titleFr;

        return $this;
    }

    /**
     * Get titleFr
     *
     * @return string
     */
    public function getTitleFr()
    {
        return $this->title_fr;
    }

    /**
     * Set bodyFr
     *
     * @param string $bodyFr
     *
     * @return Bericht
     */
    public function setBodyFr($bodyFr)
    {
        $this->body_fr = $bodyFr;

        return $this;
    }

    /**
     * Get bodyFr
     *
     * @return string
     */
    public function getBodyFr()
    {
        return $this->body_fr;
    }

    /**
     * Set adviceFr
     *
     * @param string $adviceFr
     *
     * @return Bericht
     */
    public function setAdviceFr($adviceFr)
    {
        $this->advice_fr = $adviceFr;

        return $this;
    }

    /**
     * Get adviceFr
     *
     * @return string
     */
    public function getAdviceFr()
    {
        return $this->advice_fr;
    }

    /**
     * Set titleDe
     *
     * @param string $titleDe
     *
     * @return Bericht
     */
    public function setTitleDe($titleDe)
    {
        $this->title_de = $titleDe;

        return $this;
    }

    /**
     * Get titleDe
     *
     * @return string
     */
    public function getTitleDe()
    {
        return $this->title_de;
    }

    /**
     * Set bodyDe
     *
     * @param string $bodyDe
     *
     * @return Bericht
     */
    public function setBodyDe($bodyDe)
    {
        $this->body_de = $bodyDe;

        return $this;
    }

    /**
     * Get bodyDe
     *
     * @return string
     */
    public function getBodyDe()
    {
        return $this->body_de;
    }

    /**
     * Set adviceDe
     *
     * @param string $adviceDe
     *
     * @return Bericht
     */
    public function setAdviceDe($adviceDe)
    {
        $this->advice_de = $adviceDe;

        return $this;
    }

    /**
     * Get adviceDe
     *
     * @return string
     */
    public function getAdviceDe()
    {
        return $this->advice_de;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return Bericht
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDdate
     *
     * @param \DateTime $endDdate
     *
     * @return Bericht
     */
    public function setEndDdate($endDdate)
    {
        $this->endDdate = $endDdate;

        return $this;
    }

    /**
     * Get endDdate
     *
     * @return \DateTime
     */
    public function getEndDdate()
    {
        return $this->endDdate;
    }

    /**
     * Set category
     *
     * @param string $category
     *
     * @return Bericht
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set link
     *
     * @param string $link
     *
     * @return Bericht
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set imageUrl
     *
     * @param string $imageUrl
     *
     * @return Bericht
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    /**
     * Get imageUrl
     *
     * @return string
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * Set important
     *
     * @param boolean $important
     *
     * @return Bericht
     */
    public function setImportant($important)
    {
        $this->important = $important;

        return $this;
    }

    /**
     * Get important
     *
     * @return boolean
     */
    public function getImportant()
    {
        return $this->important;
    }

    /**
     * Set isLive
     *
     * @param boolean $isLive
     *
     * @return Bericht
     */
    public function setIsLive($isLive)
    {
        $this->isLive = $isLive;

        return $this;
    }

    /**
     * Get isLive
     *
     * @return boolean
     */
    public function getIsLive()
    {
        return $this->isLive;
    }

    /**
     * Set includeMap
     *
     * @param boolean $includeMap
     *
     * @return Bericht
     */
    public function setIncludeMap($includeMap)
    {
        $this->includeMap = $includeMap;

        return $this;
    }

    /**
     * Get includeMap
     *
     * @return boolean
     */
    public function getIncludeMap()
    {
        return $this->includeMap;
    }

    /**
     * Set locationLat
     *
     * @param string $locationLat
     *
     * @return Bericht
     */
    public function setLocationLat($locationLat)
    {
        $this->locationLat = $locationLat;

        return $this;
    }

    /**
     * Get locationLat
     *
     * @return string
     */
    public function getLocationLat()
    {
        return $this->locationLat;
    }

    /**
     * Set locationLng
     *
     * @param string $locationLng
     *
     * @return Bericht
     */
    public function setLocationLng($locationLng)
    {
        $this->locationLng = $locationLng;

        return $this;
    }

    /**
     * Get locationLng
     *
     * @return string
     */
    public function getLocationLng()
    {
        return $this->locationLng;
    }
}
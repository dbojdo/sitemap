<?php
namespace Webit\Sitemap\Model;

use JMS\Serializer\Annotation as JMS;
use JMS\Serializer\EventDispatcher\PreSerializeEvent;

/**
 * 
 * @author dbojdo
 * @JMS\XmlRoot("url")
 */
class Url
{
    const DEFAULT_PRIORITY = 0.5;

    const FREQ_ALWAYS  = 'always';
    const FREQ_HOURLY  = 'hourly';
    const FREQ_DAILY   = 'daily';
    const FREQ_WEEKLY  = 'weekly';
    const FREQ_MONTHLY = 'monthly';
    const FREQ_YEARLY  = 'yearly';
    const FREQ_NEVER   = 'never';
    
    /**
     *
     * @var string
     * 
     * @JMS\SerializedName("loc")
     * @JMS\Type("string")
     */
    protected $location;

    /**
     *
     * @var \DateTime
     * @JMS\SerializedName("lastmod")
     * @JMS\Type("DateTime<c>")
     */
    protected $lastModified;

    /**
     *
     * @var string
     * @JMS\SerializedName("changefreq")
     * @JMS\Type("string")
     */
    protected $changeFrequency;

    /**
     *
     * @var float
     * @JMS\SerializedName("priority")
     * @JMS\Type("float")
     */
    protected $priority = self::DEFAULT_PRIORITY;

    /**
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     *
     * @param string $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     *
     * @return \DateTime
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }

    /**
     *
     * @param \DateTime $lastModified            
     */
    public function setLastModified(\DateTime $lastModified)
    {
        $this->lastModified = $lastModified;
    }

    /**
     *
     * @return string
     */
    public function getChangeFrequency()
    {
        return $this->changeFrequency;
    }

    /**
     *
     * @param string $changeFrequency
     */
    public function setChangeFrequency($changeFrequency)
    {
        $this->changeFrequency = $changeFrequency;
    }

    /**
     *
     * @return float
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     *
     * @param float $priority
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }
}

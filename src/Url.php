<?php
/**
 * Url.php
 *
 * @author dbojdo - Daniel Bojdo <daniel.bojdo@8x8.com>
 * Created on 10 06, 2015, 16:45
 * Copyright (C) 8x8
 */

namespace Webit\Sitemap;

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
     * @JMS\XmlElement(cdata=false)
     */
    protected $location;

    /**
     *
     * @var \DateTime
     * @JMS\SerializedName("lastmod")
     * @JMS\Type("DateTime<c>")
     * @JMS\XmlElement(cdata=false)
     */
    protected $lastModified;

    /**
     *
     * @var string
     * @JMS\SerializedName("changefreq")
     * @JMS\Type("string")
     * @JMS\XmlElement(cdata=false)
     */
    protected $changeFrequency;

    /**
     *
     * @var float
     * @JMS\SerializedName("priority")
     * @JMS\Type("float")
     * @JMS\XmlElement(cdata=false)
     */
    protected $priority = self::DEFAULT_PRIORITY;

    /**
     * @param string|null $location
     * @param \DateTime|null $lastModified
     * @param string|null $changeFrequency
     * @param float|null $priority
     */
    public function __construct($location = null, \DateTime $lastModified = null, $changeFrequency = null, $priority = null)
    {
        $this->setLocation($location);
        if ($lastModified) {
            $this->setLastModified($lastModified);
        }

        $this->setChangeFrequency($changeFrequency);
        $this->setPriority($priority);

    }

    /**
     * @param $location
     * @param \DateTime $lastModified
     * @param string|null $changeFrequency
     * @param float|null $priority
     * @return \Webit\Sitemap\Url
     */
    public static function create($location, \DateTime $lastModified = null, $changeFrequency = null, $priority = null)
    {
        return new static($location, $lastModified, $changeFrequency, $priority);
    }

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
        $this->priority = (float) $priority;
    }
}

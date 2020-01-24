<?php

namespace Webit\Sitemap;

use JMS\Serializer\Annotation as JMS;

/**
 * @JMS\XmlRoot("urlset")
 */
final class UrlSet
{
    const VERSION_09 = '0.9';

    /**
     *
     * @var string
     * @JMS\XmlAttribute
     * @JMS\Type("string")
     * @JMS\SerializedName("xmlns")
     */
    private $xmlns;

    /**
     * @var array
     * @JMS\Exclude
     */
    private static $versionNs = array(
        self::VERSION_09 => 'http://www.sitemaps.org/schemas/sitemap/0.9',
    );

    /**
     *
     * @var string
     * @JMS\Exclude
     */
    private $version = self::VERSION_09;

    /**
     *
     * @var Url[]
     * @JMS\XmlList(inline = true, entry = "url")
     * @JMS\Type("array<Webit\Sitemap\Url>")
     */
    private $urls = [];

    public function __construct($version = self::VERSION_09)
    {
        $this->setVersion($version);
    }

    /**
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    private function setVersion($version)
    {
        if (array_key_exists($version, self::$versionNs) == false) {
            throw new \RuntimeException(sprintf('Unsupported SiteMap version: "%s"', $version));
        }

        $this->xmlns = self::$versionNs[$version];
    }

    /**
     * @return array
     */
    public function getUrls()
    {
        return $this->urls;
    }

    /**
     *
     * @param array<Url> $urls
     */
    public function setUrls(array $urls)
    {
        $this->urls = $urls;
    }

    /**
     *
     * @param Url $url
     */
    public function addUrl(Url $url)
    {
        $key = $this->getUrlKey($url);
        $this->urls[$key] = $url;
    }

    /**
     *
     * @param Url $url
     */
    public function removeUrl(Url $url)
    {
        $key = $this->getUrlKey($url);
        if (array_key_exists($key, $this->urls)) {
            unset($this->urls[$key]);
        }
    }

    /**
     *
     * @param Url $url
     * @return string
     */
    private function getUrlKey(Url $url)
    {
        return md5($url->getLocation());
    }

    /**
     * @param UrlSet $urlSet
     */
    public function merge(UrlSet $urlSet)
    {
        if ($urlSet->getVersion() != $this->getVersion()) {
            throw new \InvalidArgumentException('Cannot merge Url sets with different versions.');
        }

        $this->urls = array_merge($this->urls, $urlSet->getUrls());
    }
}

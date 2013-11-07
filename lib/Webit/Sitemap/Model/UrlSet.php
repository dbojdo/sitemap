<?php
namespace Webit\Sitemap\Model;
use JMS\Serializer\Annotation as JMS;

/**
 * 
 * @author dbojdo
 * @JMS\XmlRoot("urlset")
 */
class UrlSet {
    const VERSION_09 = '0.9';
    
    /**
     * 
     * @var array
     */
    private static $versionNs = array(
    	self::VERSION_09 => 'http://www.sitemaps.org/schemas/sitemap/0.9'
    );
    
    /**
     * 
     * @var string
     * @JMS\Exclude
     */
    protected $version = self::VERSION_09;
    
    /**
     * 
     * @var string
     * @JMS\@XmlAttribute
     * @JMS\Type("string")
     */
    protected $xmlns;
    
    /**
     * 
     * @var array<Url>
     * @JMS\XmlList(inline = true, entry = "url")
     * @JMS\Type("array<Webit\Sitemap\Model\Url>")
     */
    protected $urls = array();
    
    public function __construct($version = self::VERSION_09) {
        $this->setVersion($version);
    }
    
    /**
     * 
     * @return string
     */
    public function getVersion() {
        return $this->version;
    }
    
    private function setVersion($version) {
        if(key_exists($version, self::$versionNs) == false) {
            throw new \RuntimeException(sprintf('Unsupported Sitemap version: "%s"',$version));
        }
        
        $this->xmlns = self::$versionNs[$version];
    }
    
    /**
     * @return array
     */
    public function getUrls() {
        return $this->urls;
    }
    
    /**
     * 
     * @param array<Url> $urls
     */
    public function setUrls(array $urls) {
        $this->urls = $urls;
    }
    
    /**
     * 
     * @param Url $url
     */
    public function addUrl(Url $url) {
        $key = $this->getUrlKey($url);
        $this->urls[$key] = $url;
    }
    
    /**
     * 
     * @param Url $url
     */
    public function removeUrl(Url $url) {
        $key = $this->getUrlKey($url);
        if(key_exists($key, $this->urls)) {
            unset($this->urls[$key]);
        }
    }
    
    /**
     * 
     * @param Url $url
     * @return string
     */
    private function getUrlKey(Url $url) {
        return md5($url->getLocation());
    }
    
    public function merge(UrlSet $urlset) {
        if($urlset->getVersion() != $this->getVersion()) {
            throw new \InvalidArgumentException('Cannot merge Url sets with different versions.');
        }
        
        $this->urls = array_merge($this->urls, $urlset->getUrls());
    }
}

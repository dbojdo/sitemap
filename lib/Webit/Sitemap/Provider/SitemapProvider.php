<?php
namespace Webit\Sitemap\Generator;

use Webit\Sitemap\Exposer\UrlExposerInterface;
use Webit\Sitemap\Writer\UrlSetWriterInterface;

class SitemapProvider implements SitemapProviderInterface {
    /**
     * 
     * @var UrlExposerInterface
     */
    private $exposer;
    
    /**
     * 
     * @var UrlSetWriterInterface
     */
    private $writer;
    
    /**
     * 
     * @var int
     */
    private $interval;
    
    /**
     * 
     * @var \SplFileInfo
     */
    private $sitemapFile;
    
    public function __construct(UrlExposerInterface $exposer, UrlSetWriterInterface $writer, $interval, $webRoot, $sitemapFilename = 'sitemap.xml') {
        $this->exposer = $exposer;
        $this->writer = $writer;
        $this->interval = $interval;
        $this->sitemapFile = new \SplFileInfo($webRoot .'/'.$sitemapFilename);
    }
    
    /**
     * 
     * @return \SplFileInfo
     */
    public function getSitemap($forceGeneration = false) {
        if($this->needsGenerate($forceGeneratrion)) {
            $urlSet = $this->exposer->getUrlSet();
            $this->writer->writeUrlSet($urlSet, new \SplFileInfo($this->sitemapFile));
        }
        
        return $this->sitemapFile;
    }
    
    private function needsGenerate($forceGeneratrion) {
        if($forceGeneratrion || $this->sitemapFile->isFile() == false) {
            return true;
        }
        
        $ctime = new \DateTime($this->sitemapFile->getMTime());
        $expirationTime = $ctime->add(new \DateInterval('P'.$this->interval .'D'));
        
        return new \DateTime() > $expirationTime;
    }
}

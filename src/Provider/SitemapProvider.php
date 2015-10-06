<?php
namespace Webit\Sitemap\Provider;

use Webit\Sitemap\Exposer\UrlExposerInterface;
use Webit\Sitemap\Writer\UrlSetWriterInterface;

class SitemapProvider implements SitemapProviderInterface
{
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

    /**
     * @param UrlExposerInterface $exposer
     * @param UrlSetWriterInterface $writer
     * @param $interval
     * @param $targetDir
     * @param string $sitemapFilename
     */
    public function __construct(
        UrlExposerInterface $exposer,
        UrlSetWriterInterface $writer,
        $interval,
        $targetDir,
        $sitemapFilename = 'sitemap.xml'
    ) {
        $this->exposer = $exposer;
        $this->writer = $writer;
        $this->interval = $interval;
        $this->sitemapFile = new \SplFileInfo($targetDir . '/' . $sitemapFilename);
    }
    
    /**
     * 
     * @return \SplFileInfo
     */
    public function getSitemap($forceGeneration = false)
    {
        if ($this->needsGenerate($forceGeneration)) {
        	if (is_dir($this->sitemapFile->getPath()) == false) {
        		@mkdir($this->sitemapFile->getPath(), 0755, true);
        	}
        	
            $urlSet = $this->exposer->getUrlSet();
            $this->writer->writeUrlSet($urlSet, new \SplFileInfo($this->sitemapFile));
        }
        
        return $this->sitemapFile;
    }
    
    private function needsGenerate($forceGeneration)
    {
        if ($forceGeneration || $this->sitemapFile->isFile() == false) {
            return true;
        }
        
        $cTime = \DateTime::createFromFormat('U', $this->sitemapFile->getMTime());
        $expirationTime = $cTime->add(new \DateInterval('P' . $this->interval . 'D'));
        
        return new \DateTime() > $expirationTime;
    }
}

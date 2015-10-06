<?php
namespace Webit\Sitemap\Writer;

use Webit\Sitemap\UrlSet;
use JMS\Serializer\SerializerInterface;

class SerializerUrlSetWriter implements UrlSetWriterInterface
{
    /**
     * 
     * @var SerializerInterface
     */
    protected $serializer;
    
    /**
     * 
     * @var string
     */
    protected $tmpDir;
    
    public function __construct(SerializerInterface $serializer, $tmpDir)
    {
        $this->serializer = $serializer;
        $this->setTmpDir($tmpDir);
    }
    
    /**
     * 
     * @param string $tmpDir
     */
    private function setTmpDir($tmpDir)
    {
        if (is_dir($tmpDir) == false) {
            @mkdir($tmpDir, 0755, true);
        }
        $this->tmpDir = $tmpDir;
    }

    /**
     *
     * @param UrlSet $urlSet
     * @param \SplFileInfo $file
     * @return \SplFileInfo
     */
    public function writeUrlSet(UrlSet $urlSet, \SplFileInfo $file = null)
    {
    	if (empty($file)) {
    	    $file = $this->generateTmpFile();
    	}
    	
    	file_put_contents($file->getPathname(), $this->serializer->serialize($urlSet, 'xml'));
    	
    	return $file;
    }
    
    /**
     * 
     * @return \SplFileInfo
     */
    private function generateTmpFile() {
        $tmpFile = md5(time() . mt_rand(0, 10000)) . '.xml';
        return new \SplFileInfo($this->tmpDir . '/' . $tmpFile);
    }
}

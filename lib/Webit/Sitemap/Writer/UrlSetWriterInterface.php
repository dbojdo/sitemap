<?php
namespace Webit\Sitemap\Writer;

use Webit\Sitemap\Model\UrlSet;

interface UrlSetWriterInterface {
    /**
     * 
     * @param UrlSet $urlSet
     * @return \SplFileInfo
     */
    public function writeUrlSet(UrlSet $urlSet, \SplFileInfo $file = null);
}

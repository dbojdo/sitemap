<?php
namespace Webit\Sitemap\Writer;

use Webit\Sitemap\UrlSet;

interface UrlSetWriterInterface
{
    /**
     *
     * @param UrlSet $urlSet
     * @param \SplFileInfo|null $file
     * @return \SplFileInfo
     */
    public function writeUrlSet(UrlSet $urlSet, \SplFileInfo $file = null);
}

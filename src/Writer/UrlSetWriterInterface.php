<?php

namespace Webit\Sitemap\Writer;

use Webit\Sitemap\UrlSet;

interface UrlSetWriterInterface
{
    /**
     * @param UrlSet $urlSet
     * @param \SplFileInfo $file
     */
    public function writeUrlSet(UrlSet $urlSet, \SplFileInfo $file);
}

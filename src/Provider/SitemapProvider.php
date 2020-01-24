<?php

namespace Webit\Sitemap\Provider;

use Webit\Sitemap\Exposer\UrlExposerInterface;
use Webit\Sitemap\Writer\UrlSetWriterInterface;

final class SitemapProvider implements SitemapProviderInterface
{
    /** @var UrlExposerInterface */
    private $exposer;

    /** @var UrlSetWriterInterface */
    private $writer;

    /** @var int */
    private $interval;

    /** @var \SplFileInfo */
    private $sitemapFile;

    /**
     * @param UrlExposerInterface $exposer
     * @param UrlSetWriterInterface $writer
     * @param int $interval number of days the sitemap is valid
     * @param string $targetDir
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
     * @inheritDoc
     */
    public function getSitemap($forceGeneration = false)
    {
        if (!$this->needsGenerate($forceGeneration)) {
            return $this->sitemapFile;
        }

        if (!is_dir($this->sitemapFile->getPath())) {
            @mkdir($this->sitemapFile->getPath(), 0755, true);
        }

        $this->writer->writeUrlSet($this->exposer->getUrlSet(), $this->sitemapFile);

        return $this->sitemapFile;
    }

    /**
     * @param bool $forceGeneration
     * @return bool
     */
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

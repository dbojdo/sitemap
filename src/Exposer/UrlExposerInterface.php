<?php
namespace Webit\Sitemap\Exposer;

use Webit\Sitemap\UrlSet;

interface UrlExposerInterface
{
    /**
     * @return UrlSet
     */
    public function getUrlSet();
}

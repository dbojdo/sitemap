<?php
namespace Webit\Sitemap\Exposer;

use Webit\Sitemap\Model\UrlSet;

interface UrlExposerInterface {
    /**
     * @return UrlSet
     */
    public function getUrlSet();
}

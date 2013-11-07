<?php
namespace Webit\Sitemap\Generator;

use Webit\Sitemap\Exposer\UrlExposerInterface;
interface SitemapProviderInterface {
    public function getSitemap(UrlExposerInterface $exposer, $generate = false);
}

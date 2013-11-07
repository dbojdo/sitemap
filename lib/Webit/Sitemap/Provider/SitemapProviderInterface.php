<?php
namespace Webit\Sitemap\Provider;

use Webit\Sitemap\Exposer\UrlExposerInterface;
interface SitemapProviderInterface {
    public function getSitemap($forceGeneration = false);
}

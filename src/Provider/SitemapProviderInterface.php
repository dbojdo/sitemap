<?php
namespace Webit\Sitemap\Provider;

interface SitemapProviderInterface
{
    public function getSitemap($forceGeneration = false);
}

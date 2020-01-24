<?php

namespace Webit\Sitemap\Exposer;

interface UrlExposerChainInterface extends UrlExposerInterface
{
    /**
     * @param UrlExposerInterface $exposer
     */
    public function registerExposer(UrlExposerInterface $exposer);
}

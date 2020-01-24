<?php

namespace Webit\Sitemap\Exposer;

use Webit\Sitemap\UrlSet;

final class UrlExposerChain implements UrlExposerChainInterface
{
    /** @var UrlExposerInterface[] */
    private $exposers = [];

    /**
     * @inheritDoc
     */
    public function getUrlSet()
    {
        $urlSet = new UrlSet();
        if (!$this->exposers) {
            return $urlSet;
        }

        foreach ($this->exposers as $exposer) {
            $urlSet->merge($exposer->getUrlSet());
        }

        return $urlSet;
    }

    /**
     * @inheritDoc
     */
    public function registerExposer(UrlExposerInterface $exposer)
    {
        $this->exposers[] = $exposer;
    }
}

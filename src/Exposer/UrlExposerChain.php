<?php
namespace Webit\Sitemap\Exposer;

use Webit\Sitemap\UrlSet;

class UrlExposerChain implements UrlExposerChainInterface
{

    /**
     * @var array
     */
    protected $exposers = array();
    
    /**
     * @return UrlSet
     */
    public function getUrlSet()
    {
        if (count($this->exposers) == 0) {
            return new UrlSet();
        }
        
        $urlSet = null;
        foreach($this->exposers as $exposer) {
            if ($urlSet == null) {
                $urlSet = $exposer->getUrlSet();
            } else {
                $urlSet->merge($exposer->getUrlSet());
            }
        }
        
        return $urlSet;
    }
    
    /**
     * 
     * @param UrlExposerInterface $exposer
     */
    public function registerExposer(UrlExposerInterface $exposer)
    {
        $this->exposers[] = $exposer;
    }
}

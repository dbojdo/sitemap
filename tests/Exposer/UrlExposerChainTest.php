<?php

namespace Webit\Sitemap\Exposer;

use PHPUnit\Framework\TestCase;
use Webit\Sitemap\Url;
use Webit\Sitemap\UrlSet;

class UrlExposerChainTest extends TestCase
{
    /**
     * @test
     */
    public function itRegistersExposers()
    {
        $chainExposer = new UrlExposerChain();
        $chainExposer->registerExposer($this->prophesize(UrlExposerInterface::class)->reveal());
    }

    /**
     * @test
     */
    public function itReturnsEmptyUrlSetIfNoExposersRegistered()
    {
        $chainExposer = new UrlExposerChain();
        $this->assertEquals(new UrlSet(), $chainExposer->getUrlSet());
    }

    /**
     * @test
     */
    public function itMergesUrlSetsFromRegisteredExposers()
    {
        $chainExposer = new UrlExposerChain();
        $exposer1 = $this->prophesize(UrlExposerInterface::class);
        $exposer2 = $this->prophesize(UrlExposerInterface::class);

        $chainExposer->registerExposer($exposer1->reveal());
        $chainExposer->registerExposer($exposer2->reveal());

        $exposer1UrlSet = new UrlSet();
        $exposer1UrlSet->addUrl(Url::create('location 1'));
        $exposer1->getUrlSet()->willReturn($exposer1UrlSet);

        $exposer2UrlSet = new UrlSet();
        $exposer2UrlSet->addUrl(Url::create('location 2'));
        $exposer2UrlSet->addUrl(Url::create('location 3'));
        $exposer2->getUrlSet()->willReturn($exposer2UrlSet);

        $expectedUrlSet = new UrlSet();
        $expectedUrlSet->addUrl(Url::create('location 1'));
        $expectedUrlSet->addUrl(Url::create('location 2'));
        $expectedUrlSet->addUrl(Url::create('location 3'));

        $this->assertEquals($expectedUrlSet, $chainExposer->getUrlSet());
    }
}

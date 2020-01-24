<?php

namespace Webit\Sitemap\Writer;

use JMS\Serializer\SerializerBuilder;
use PHPUnit\Framework\TestCase;
use Webit\Sitemap\Url;
use Webit\Sitemap\UrlSet;

class SerializerUrlSetWriterTest extends TestCase
{
    /** @var SerializerUrlSetWriter */
    private $writer;

    /** @var string */
    private $outputFile;

    public function setUp()
    {
        $serializer = SerializerBuilder::create()
            ->addDefaultSerializationVisitors()
            ->addDefaultHandlers()
            ->addDefaultListeners()
            ->build();

        $this->outputFile = new \SplFileInfo(sprintf('%s/sitemap_%s.xml', sys_get_temp_dir(), md5(mt_rand(0, PHP_INT_MAX))));

        $this->writer = new SerializerUrlSetWriter(
            $serializer
        );
    }

    public function tearDown()
    {
        if ($this->outputFile && $this->outputFile->isFile()) {
            @unlink($this->outputFile->getPathname());
        }
    }

    /**
     * @test
     */
    public function itWritesUrlSet()
    {
        $urlSet = new UrlSet();
        $urlSet->addUrl(Url::create('http://test.location/location-1', date_create('2019-02-21 23:22:31'), Url::FREQ_DAILY, 0.8));

        $this->writer->writeUrlSet($urlSet, $this->outputFile);

        $this->assertEquals($this->expectedXml(), file_get_contents($this->outputFile->getPathname()));
    }

    private function expectedXml()
    {
        $xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <url>
    <loc>http://test.location/location-1</loc>
    <lastmod>2019-02-21T23:22:31+00:00</lastmod>
    <changefreq>daily</changefreq>
    <priority>0.8</priority>
  </url>
</urlset>

XML;

        return $xml;
    }
}

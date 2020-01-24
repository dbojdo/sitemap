<?php

namespace Webit\Sitemap\Writer;

use Webit\Sitemap\UrlSet;
use JMS\Serializer\SerializerInterface;

final class SerializerUrlSetWriter implements UrlSetWriterInterface
{
    /** @var SerializerInterface */
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @inheritDoc
     */
    public function writeUrlSet(UrlSet $urlSet, \SplFileInfo $file)
    {
        file_put_contents($file->getPathname(), $this->serializer->serialize($urlSet, 'xml'));
    }
}

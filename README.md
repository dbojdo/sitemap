# Web-IT Site Map Generator

This library provides components to generate ***sitemap.xml*** file according to http://www.sitemaps.org

## Installation

### Composer: add the **webit/sitemap** into **composer.json**

```json
{
    "require": {
        "php": ">=5.6.0",
        "webit/sitemap": "^2.0.0"
    }
}
```

## Usage

Prepare your implementation of a ***\Webit\Sitemap\Exposer\UrlExposerInterface***.
Its method **getUrlSet** must return instance of a ***\Webit\Sitemap\UrlSet*** object (which is a container for ***\Webit\Sitemap\Url*** objects).

```php
namespace MyProject;

use Webit\Sitemap\Exposer\UrlExposerInterface;
use Webit\Sitemap\UrlSet;
use Webit\Sitemap\Url;

class MyExposer implements UrlExposerInterface
{
    /**
     * @return UrlSet
     */
    public function getUrlSet()
    {
        $urlSet = new UrlSet();
        
        $urlSet->addUrl(Url::create('http://my-project.domain/url-1'));
        $urlSet->addUrl(Url::create('http://my-project.domain/url-2'));
        $urlSet->addUrl(Url::create('http://my-project.domain/url-3'));
        // add urls you need
         
        return $urlSet;
    }
}
```

Configure a ***SitemapProvider*** and generate a Site Map

```php
use Webit\Sitemap\Writer\SerializerUrlSetWriter;
use Webit\Sitemap\Provider\SitemapProvider;

/** @var \JMS\Serializer\SerializerInterface $serializer **/

$writer = new SerializerUrlSetWriter($serializer, sys_get_temp_dir());

$exposer = new MyProject\MyExposer();

$provider = new SitemapProvider($exposer, $writer, 7, '/dir/inside/your/project/can/be/webroot');

/**
 * Generate XML file (\SplFileInfo instance)
 */
$sitemapFile = $provider->getSitemap();

// if you need to force regeneration use
$sitemapFile = $provider->getSitemap(true);

```

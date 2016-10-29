#ElasticsearchExplorerBundle
Elasticsearch status and search functionality as a Symfony3 bundle. This bundle uses the official elasticsearch-php client and the front-end framework ZURB Foundation.

##Installation
Add the following snippet to your local projects composer.json file:
```
{
  "require": {
    "dan-lyn/elasticsearch-explorer-bundle": "dev-master"
  },
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/dan-lyn/ElasticsearchExplorerBundle.git"
    }
  ]
}
```

Add the ElasticsearchExplorerBundle to the bundles array in your local AppKernel.php file:
```
$bundles = array(
  // ...

  new DanLyn\ElasticsearchExplorerBundle\DanLynElasticsearchExplorerBundle(),
);
```

Add the following snippet to your local config/routing file:
```
dan_lyn_elasticsearch_explorer:
    resource: "@DanLynElasticsearchExplorerBundle/Resources/config/routing.yml"
    prefix:   /
```

Add DanLynElasticsearchExplorerBundle and Foundation assets to the assetic configuration in your local config file:
```
assetic:
    # ...

    bundles: ['DanLynElasticsearchExplorerBundle']

    # ...

    assets:
        fontawesome_font_otf:
            inputs:
                - '../src/DanLyn/ElasticsearchExplorerBundle/Resources/public/fonts/FontAwesome.otf'
            output: Resources/public/fonts/FontAwesome.otf
        fontawesome_font_woff:
            inputs:
                - '../src/DanLyn/ElasticsearchExplorerBundle/Resources/public/fonts/fontawesome-webfont.woff'
            output: Resources/public/fonts/fontawesome-webfont.woff
        fontawesome_font_woff2:
            inputs:
                - '../src/DanLyn/ElasticsearchExplorerBundle/Resources/public/fonts/fontawesome-webfont.woff2'
            output: Resources/public/fonts/fontawesome-webfont.woff2
        fontawesome_font_ttf:
            inputs:
                - '../src/DanLyn/ElasticsearchExplorerBundle/Resources/public/fonts/fontawesome-webfont.ttf'
            output: Resources/public/fonts/fontawesome-webfont.ttf
        fontawesome_font_svg:
            inputs:
                - '../src/DanLyn/ElasticsearchExplorerBundle/Resources/public/fonts/fontawesome-webfont.svg'
            output: Resources/public/fonts/fontawesome-webfont.svg
        fontawesome_font_eot:
            inputs:
                - '../src/DanLyn/ElasticsearchExplorerBundle/Resources/public/fonts/fontawesome-webfont.eot'
            output: Resources/public/fonts/fontawesome-webfont.eot
```

Setup language by adding to following snippet to your local config file:
```
framework:
    # ...
    translator: { fallbacks: [en] }
    '...
```

##Configuration

In Resources/config/elasticsearch.yml it is possible to configure to hostname of the Elasticsearch instance:
```
hosts: "localhost:9200"
```

##Testing
Run PHPUnit from the root of your Symfony application using the following command:
```
phpunit src/DanLyn/ElasticsearchExplorerBundle/Tests/
```

##License

ElasticsearchExplorerBundle is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

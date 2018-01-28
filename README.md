# ElasticsearchExplorerBundle
Elasticsearch status and search functionality as a Symfony 4 bundle. This bundle uses the official elasticsearch-php client and the front-end framework Bootstrap.

## Installation
Add the following snippet to your local projects composer.json file:
```json
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

Add the ElasticsearchExplorerBundle to the bundles array in your local config/bundles.php file:
```
return [
  // ...

  DanLyn\ElasticsearchExplorerBundle\DanLynElasticsearchExplorerBundle::class => ['all' => true],
];
```

Add the following snippet to your local config/routes.yaml file:
```
dan_lyn_elasticsearch_explorer:
    resource: "@DanLynElasticsearchExplorerBundle/Resources/config/routing.yml"
    prefix:   /
```

Link to bundle assets to your Symfony installation by installing the assets using the following command:
```
php bin/console assets:install
```

Setup language by adding to following snippet to your local config/packages/framework.yaml file (or change the locale in translation.yaml):
```
framework:
    # ...
    translator: { fallbacks: [en] }
    '...
```

## Configuration

In Resources/config/elasticsearch.yml it is possible to configure to hostname of the Elasticsearch instance:
```
hosts: "localhost:9200"
```

## Testing
Run PHPUnit from the root of your Symfony application using the following command:
```
phpunit src/DanLyn/ElasticsearchExplorerBundle/Tests/
```

## License

ElasticsearchExplorerBundle is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

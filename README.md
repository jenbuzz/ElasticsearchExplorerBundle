#ElasticsearchExplorerBundle
Elasticsearch status and search functionality in a Symfony2 bundle.

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

Add DanLynElasticsearchExplorerBundle to the assetic bundles in your local config file:
```
assetic:
    # ...

    bundles: ['DanLynElasticsearchExplorerBundle']
```

##License

ElasticsearchExplorerBundle is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

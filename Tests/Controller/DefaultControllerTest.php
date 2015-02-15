<?php

namespace DanLyn\ElasticsearchExplorerBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    /**
     * Test Index Page Routing.
     */
    public function testIndex()
    {
        $client = static::createClient();
        $client->request('GET', '/elasticsearchexplorer/');

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    /**
     * Test Search Page Routing.
     */
    public function testSearch()
    {
        $client = static::createClient();
        $client->request('GET', '/elasticsearchexplorer/search/');

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    /**
     * Test Config Page Routing.
     */
    public function testConfig()
    {
        $client = static::createClient();
        $client->request('GET', '/elasticsearchexplorer/config/');

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    /**
     * Test Plugins Page Routing.
     */
    public function testPlugins()
    {
        $client = static::createClient();
        $client->request('GET', '/elasticsearchexplorer/plugins/');

        $this->assertTrue($client->getResponse()->isSuccessful());
    }
}

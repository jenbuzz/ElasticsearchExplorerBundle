<?php

namespace Jenbuzz\ElasticsearchExplorerBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class DefaultControllerTest extends WebTestCase
{
    /**
     * Test Index Page Routing.
     */
    public function testIndex()
    {
        $client = static::createClient();
        $client->request('GET', '/elasticsearchexplorer/');

        $this->assertTrue($client->getResponse()->isSuccessful(), 'Response HTTP status is 2xx');
        
        $this->assertEquals(
            Response::HTTP_OK,
            $client->getResponse()->getStatusCode()
        );
    }

    /**
     * Test Search Page Routing.
     */
    public function testSearch()
    {
        $client = static::createClient();
        $client->request('GET', '/elasticsearchexplorer/search/');

        $this->assertTrue($client->getResponse()->isSuccessful(), 'Response HTTP status is 2xx');
        
        $this->assertEquals(
            Response::HTTP_OK,
            $client->getResponse()->getStatusCode()
        );
    }

    /**
     * Test Config Page Routing.
     */
    public function testConfig()
    {
        $client = static::createClient();
        $client->request('GET', '/elasticsearchexplorer/config/');

        $this->assertTrue($client->getResponse()->isSuccessful(), 'Response HTTP status is 2xx');
        
        $this->assertEquals(
            Response::HTTP_OK,
            $client->getResponse()->getStatusCode()
        );
    }

    /**
     * Test Plugins Page Routing.
     */
    public function testPlugins()
    {
        $client = static::createClient();
        $client->request('GET', '/elasticsearchexplorer/plugins/');

        $this->assertTrue($client->getResponse()->isSuccessful(), 'Response HTTP status is 2xx');
        
        $this->assertEquals(
            Response::HTTP_OK,
            $client->getResponse()->getStatusCode()
        );
    }
}

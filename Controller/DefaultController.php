<?php

namespace DanLyn\ElasticsearchExplorerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $client = new \Elasticsearch\Client();

        return $this->render('DanLynElasticsearchExplorerBundle:Default:index.html.twig');
    }

    public function searchAction($searchterm = false)
    {
        $client = new \Elasticsearch\Client();

        return $this->render('DanLynElasticsearchExplorerBundle:Default:search.html.twig', array('searchterm' => $searchterm));
    }
}

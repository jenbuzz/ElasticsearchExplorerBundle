<?php

namespace DanLyn\ElasticsearchExplorerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $client = new \Elasticsearch\Client();
        $objIndexes = $client->indices();
        $arrStats = $objIndexes->stats();
        $arrIndexesStats = $arrStats['indices'];
        
        $arrIndexes = array();
        foreach ($arrIndexesStats AS $indexKey => $indexValues) {
          $arrIndexes[] = array(
            'name' => $indexKey,
            'total_docs' => $indexValues['total']['docs']['count'],
            'total_size' => $indexValues['total']['store']['size_in_bytes'],
          );
        }

        return $this->render('DanLynElasticsearchExplorerBundle:Default:index.html.twig', array(
          'indexes' => $arrIndexes,
        ));
    }

    public function searchAction($index = false, $searchterm = false)
    {
        $client = new \Elasticsearch\Client();

        return $this->render('DanLynElasticsearchExplorerBundle:Default:search.html.twig', array('index' => $index, 'searchterm' => $searchterm));
    }
}

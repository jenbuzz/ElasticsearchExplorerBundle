<?php

namespace DanLyn\ElasticsearchExplorerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $objElasticsearchManager = $this->get('elasticsearch_manager');
        $arrIndexes = $objElasticsearchManager->getIndexStats();

        return $this->render('DanLynElasticsearchExplorerBundle:Default:index.html.twig', array(
            'indexes' => $arrIndexes,
        ));
    }

    public function searchAction($index = false, $searchterm = false)
    {
        $objElasticsearchManager = $this->get('elasticsearch_manager');
        $arrIndexes = $objElasticsearchManager->getIndexStats();

        $arrTypes = array();
        if ($index) {
            $arrTypes = $objElasticsearchManager->getIndexMappingTypes($index);
        }

        return $this->render('DanLynElasticsearchExplorerBundle:Default:search.html.twig', array(
            'searchindex' => $index,
            'searchtype' => '', 
            'searchterm' => $searchterm,
            'indexes' => $arrIndexes,
            'types' => $arrTypes,
        ));
    }
}

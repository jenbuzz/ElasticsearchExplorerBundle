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

    public function searchAction($index = false, $type = false, $searchterm = false)
    {
        if (!empty($this->get('request')->query->get('searchterm'))) {
            $url = $this->generateUrl('dan_lyn_elasticsearch_explorer_search_term', array(
                'index' => $index,
                'type' => '2013',
                'searchterm' => $this->get('request')->query->get('searchterm'),
            ));

            return $this->redirect($url);
        }

        $objElasticsearchManager = $this->get('elasticsearch_manager');
        $arrIndexes = $objElasticsearchManager->getIndexStats();

        $arrTypes = array();
        if ($index) {
            $arrTypes = $objElasticsearchManager->getIndexMappingTypes($index);
        }

        return $this->render('DanLynElasticsearchExplorerBundle:Default:search.html.twig', array(
            'searchindex' => $index,
            'searchtype' => $type, 
            'searchterm' => $searchterm,
            'indexes' => $arrIndexes,
            'types' => $arrTypes,
        ));
    }
}

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

    public function searchAction($searchindex = false, $searchtype = false, $searchterm = false)
    {
        if (!empty($this->get('request')->query->get('searchterm'))) {
            $url = $this->generateUrl('dan_lyn_elasticsearch_explorer_search_term', array(
                'searchindex' => $searchindex,
                'searchtype' => $searchtype,
                'searchterm' => $this->get('request')->query->get('searchterm'),
            ));

            return $this->redirect($url);
        }

        $objElasticsearchManager = $this->get('elasticsearch_manager');
        $arrIndexes = $objElasticsearchManager->getIndexStats();

        $arrTypes = array();
        if ($searchindex) {
            $arrTypes = $objElasticsearchManager->getIndexMappingTypes($searchindex);
        }

        return $this->render('DanLynElasticsearchExplorerBundle:Default:search.html.twig', array(
            'searchindex' => $searchindex,
            'searchtype' => $searchtype, 
            'searchterm' => $searchterm,
            'indexes' => $arrIndexes,
            'types' => $arrTypes,
        ));
    }
}

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

    public function searchAction($searchindex = false, $searchtype = false, $searchfield = false, $searchterm = false)
    {
        if ($searchindex && $searchtype && !empty($this->get('request')->query->get('searchterm'))) {
            $url = $this->generateUrl('dan_lyn_elasticsearch_explorer_search_term', array(
                'searchindex' => $searchindex,
                'searchtype' => $searchtype,
                'searchfield'=> $this->get('request')->query->get('searchfield'),
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

        $arrFields = array();
        if ($searchindex && $searchtype) {
            $arrFields = $objElasticsearchManager->getFieldsInIndexType($searchindex, $searchtype);
        }

        $arrResults = array();
        if ($searchindex && $searchtype && $searchterm) {
            $arrResults = $objElasticsearchManager->search($searchindex, $searchtype, $searchterm);
        }

        return $this->render('DanLynElasticsearchExplorerBundle:Default:search.html.twig', array(
            'searchindex' => $searchindex,
            'searchtype' => $searchtype, 
            'searchterm' => $searchterm,
            'indexes' => $arrIndexes,
            'types' => $arrTypes,
            'fields' => $arrFields,
            'results' => $arrResults,
        ));
    }
}

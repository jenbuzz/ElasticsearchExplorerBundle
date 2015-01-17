<?php

namespace DanLyn\ElasticsearchExplorerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * Home.
     */
    public function indexAction()
    {
        $objElasticsearchManager = $this->get('elasticsearch_manager');
        $arrIndexes = $objElasticsearchManager->getIndexStats();

        return $this->render('DanLynElasticsearchExplorerBundle:Default:index.html.twig', array(
            'indexes' => $arrIndexes,
        ));
    }

    /**
     * Search.
     */
    public function searchAction($searchindex = false, $searchtype = false, $searchfield = false, $searchterm = false)
    {
        // Redirect to a pretty url after search submit.
        if ($searchindex && $searchtype && !empty($this->get('request')->query->get('searchfield'))  && !empty($this->get('request')->query->get('searchterm'))) {
            $strSearchfield = "";
            foreach ($this->get('request')->query->get('searchfield') as $field) {
                $strSearchfield .= $field.',';
            }
            $strSearchfield = rtrim($strSearchfield, ',');

            $url = $this->generateUrl('dan_lyn_elasticsearch_explorer_search_term', array(
                'searchindex' => $searchindex,
                'searchtype' => $searchtype,
                'searchfield' => $strSearchfield,
                'searchterm' => $this->get('request')->query->get('searchterm'),
            ));

            return $this->redirect($url);
        }

        // Get indexes.
        $objElasticsearchManager = $this->get('elasticsearch_manager');
        $arrIndexes = $objElasticsearchManager->getIndexStats();

        // Get types.
        $arrTypes = array();
        if ($searchindex) {
            $arrTypes = $objElasticsearchManager->getIndexMappingTypes($searchindex);
        }

        // Get fields.
        $arrFields = array();
        if ($searchindex && $searchtype) {
            $arrFields = $objElasticsearchManager->getFieldsInIndexType($searchindex, $searchtype);
        }

        // Get results.
        $arrResults = array();
        if ($searchindex && $searchtype && $searchfield && $searchterm) {
            $arrResults = $objElasticsearchManager->search($searchindex, $searchtype, $searchfield, $searchterm);

            if (strpos($searchfield, ',') !== false) {
                $searchfield = explode(',', $searchfield);
            } else {
                $searchfield = array($searchfield);
            }
        }

        return $this->render('DanLynElasticsearchExplorerBundle:Default:search.html.twig', array(
            'searchindex' => $searchindex,
            'searchtype' => $searchtype,
            'searchfield' => $searchfield,
            'searchterm' => $searchterm,
            'indexes' => $arrIndexes,
            'types' => $arrTypes,
            'fields' => $arrFields,
            'results' => $arrResults,
        ));
    }

    /**
     * Configuration.
     */
    public function configAction()
    {
        $objElasticsearchManager = $this->get('elasticsearch_manager');
        $arrConfiguration = $objElasticsearchManager->getConfiguration();

        return $this->render('DanLynElasticsearchExplorerBundle:Default:config.html.twig', array(
            'hosts' => $arrConfiguration['hosts'],
        ));
    }
}

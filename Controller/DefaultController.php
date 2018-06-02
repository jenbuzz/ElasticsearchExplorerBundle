<?php

namespace Jenbuzz\ElasticsearchExplorerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Jenbuzz\ElasticsearchExplorerBundle\Elasticsearch\ElasticsearchManager;

class DefaultController extends Controller
{
    /**
     * Home.
     */
    public function index(ElasticsearchManager $elasticsearchManager)
    {
        $arrIndexes = $elasticsearchManager->getIndexStats();

        return $this->render('@JenbuzzElasticsearchExplorer/Default/index.html.twig', [
            'indexes' => $arrIndexes,
        ]);
    }

    /**
     * Search.
     */
    public function search(ElasticsearchManager $elasticsearchManager, $searchindex = false, $searchtype = false, $searchfield = false, $searchterm = false)
    {
        $request = Request::createFromGlobals();

        // Redirect to a pretty url after search submit.
        if ($searchindex && $searchtype && !empty($request->query->get('searchfield'))  && !empty($request->query->get('searchterm'))) {
            $strSearchfield = "";
            foreach ($request->query->get('searchfield') as $field) {
                $strSearchfield .= $field.',';
            }
            $strSearchfield = rtrim($strSearchfield, ',');

            // Generate redirect url.
            $url = $this->generateUrl('jenbuzz_elasticsearch_explorer_search_term', [
                'searchindex' => $searchindex,
                'searchtype' => $searchtype,
                'searchfield' => $strSearchfield,
                'searchterm' => $request->query->get('searchterm'),
            ]);

            return $this->redirect($url);
        }

        // Get indexes.
        $arrIndexes = $elasticsearchManager->getIndexStats();

        // Get types.
        $arrTypes = [];
        if ($searchindex) {
            $arrTypes = $elasticsearchManager->getIndexMappingTypes($searchindex);
        }

        // Get fields.
        $arrFields = [];
        if ($searchindex && $searchtype) {
            $arrFields = $elasticsearchManager->getFieldsInIndexType($searchindex, $searchtype);
        }

        // Get results.
        $arrResults = [];
        if ($searchindex && $searchtype && $searchfield && $searchterm) {
            $arrResults = $elasticsearchManager->search($searchindex, $searchtype, $searchfield, $searchterm);

            // Create array of searchfields.
            $searchfield = $elasticsearchManager->convertSearchfieldsToArray($searchfield);
        }

        return $this->render('@JenbuzzElasticsearchExplorer/Default/search.html.twig', [
            'searchindex' => $searchindex,
            'searchtype' => $searchtype,
            'searchfield' => $searchfield,
            'searchterm' => $searchterm,
            'indexes' => $arrIndexes,
            'types' => $arrTypes,
            'fields' => $arrFields,
            'results' => $arrResults,
        ]);
    }

    /**
     * Configuration.
     */
    public function config(ElasticsearchManager $elasticsearchManager)
    {
        $arrConfiguration = $elasticsearchManager->getConfiguration();

        return $this->render('@JenbuzzElasticsearchExplorer/Default/config.html.twig', [
            'hosts' => $arrConfiguration['hosts'],
        ]);
    }

    /**
     * Plugins.
     */
    public function plugins(ElasticsearchManager $elasticsearchManager)
    {
        $arrPlugins = $elasticsearchManager->getPlugins();

        // Get the elasticsearch host to enable plugins linking.
        $host = '';
        $arrConfiguration = $elasticsearchManager->getConfiguration();
        if (is_array($arrConfiguration) && isset($arrConfiguration['hosts']) && !empty($arrConfiguration['hosts'])) {
            $host = $arrConfiguration['hosts'][0];
        }

        return $this->render('@JenbuzzElasticsearchExplorer/Default/plugins.html.twig', [
            'plugins' => $arrPlugins,
            'hosts' => $host,
        ]);
    }
}

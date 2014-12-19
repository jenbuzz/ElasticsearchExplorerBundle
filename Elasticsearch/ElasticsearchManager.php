<?php

namespace DanLyn\ElasticsearchExplorerBundle\Elasticsearch; 

class ElasticsearchManager
{
    public function getIndexStats()
    {
        try {
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

            return $arrIndexes;

        } catch (\Elasticsearch\Common\Exceptions\Curl\CouldNotConnectToHost $e) {
            return array();
        }
    }

    public function getIndexMappingTypes($index)
    {
        try {
            $client = new \Elasticsearch\Client();
            $objIndexes = $client->indices();
            $arrMappings = $objIndexes->getMapping(array('index'=>$index));

            $arrMappingTypes = array();
            if (isset($arrMappings[$index]['mappings']) && !empty($arrMappings[$index]['mappings'])) {
                foreach ($arrMappings[$index]['mappings'] AS $typeKey => $typeValue) {
                    $arrMappingTypes[] = array(
                        'name' => $typeKey,
                    );
                }
            }

            return $arrMappingTypes;

        } catch (\Elasticsearch\Common\Exceptions\Curl\CouldNotConnectToHost $e) {
            return array();
        }
    }

    public function search($index, $type, $term)
    {
        $client = new \Elasticsearch\Client();

        $params = array(
            'index' => $index,
            'type' => $type,
            'body' => array(
                'query' => array(
                    'bool' => array(
                        'should' => array(
                            'multi_match' => array(
                                'query' => $term,
                                'operator' => 'or',
                                'fields' => array('off'),
                            ),
                        ),
                    ),
                ),
            ),
        );

        $results = $client->search($params);
        
        return $results;
    }
}

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

    public function getFieldsInIndexType($index, $type)
    {
        try {
            $client = new \Elasticsearch\Client();
            $objIndexes = $client->indices();
            $arrMappings = $objIndexes->getMapping(array('index'=>$index));

            $arrFields = array();
            if (isset($arrMappings[$index]['mappings'][$type]['properties']) && !empty($arrMappings[$index]['mappings'][$type]['properties'])) {
                foreach ($arrMappings[$index]['mappings'][$type]['properties'] AS $typeKey => $typeValue) {
                    $arrFields[] = array(
                        'name' => $typeKey,
                    );
                }
            }

            return $arrFields;

        } catch (\Elasticsearch\Common\Exceptions\Curl\CouldNotConnectToHost $e) {
            return array();
        }
    }

    public function search($index, $type, $field, $term)
    {
        try {
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
                                    'fields' => array($field),
                                ),
                            ),
                        ),
                    ),
                ),
            );

            $results = $client->search($params);
            if (isset($results['hits']) && isset($results['hits']['hits']) && !empty($results['hits']['hits'])) {
                return $results['hits']['hits'];
            } else {
                return array();
            }
        } catch (\Elasticsearch\Common\Exceptions\BadRequest400Exception $e) {
            return array();
        }
    }
}

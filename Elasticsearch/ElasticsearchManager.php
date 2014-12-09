<?php

namespace DanLyn\ElasticsearchExplorerBundle\Elasticsearch; 

class ElasticsearchManager
{
    public function getIndexStats()
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

        return $arrIndexes;
    }

    public function getIndexMappingTypes($index)
    {
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
    }
}

<?php

namespace DanLyn\ElasticsearchExplorerBundle\Elasticsearch;

use Symfony\Component\Yaml\Parser;

class ElasticsearchManager
{
    protected $client = false;
    protected $isConnected = false;

    public function __construct()
    {
        try {
            $configuration = $this->getConfiguration();

            $clientBuilder = \Elasticsearch\ClientBuilder::create();
            $clientBuilder->setHosts($configuration['hosts']);
            $this->client = $clientBuilder->build();

            try {
                if ($this->client->ping()) {
                    $this->isConnected = true;
                }
            } catch (\Elasticsearch\Common\Exceptions\Missing404Exception $e) {
            }
        } catch (\Elasticsearch\Common\Exceptions\NoNodesAvailableException $e) {
        }
    }

    /**
     * Get the configuration set in elasticsearch.yml as an array.
     *
     * @return array arrConfiguration
     */
    public function getConfiguration()
    {
        $arrDefaultConfiguration = [
            'hosts' => '',
        ];

        try {
            $yamlParser = new Parser();

            $arrConfiguration = $yamlParser->parse(file_get_contents(dirname(__FILE__).'/../Resources/config/elasticsearch.yml'));
            if (!empty($arrConfiguration)) {
                if (isset($arrConfiguration['hosts'])) {
                    $arrConfiguration['hosts'] = [
                        $arrConfiguration['hosts'],
                    ];
                }

                return $arrConfiguration;
            }

            return $arrDefaultConfiguration;
        } catch (\Exception $e) {
            return $arrDefaultConfiguration;
        }
    }

    /**
     * Get the current indexes on the host with some statistics.
     *
     * @return array arrIndexes
     */
    public function getIndexStats()
    {
        $arrIndexes = [];
        
        if ($this->isConnected) {
            $objIndexes = $this->client->indices();
            $arrStats = $objIndexes->stats();
            $arrIndexesStats = $arrStats['indices'];

            foreach ($arrIndexesStats as $indexKey => $indexValues) {
                $arrIndexes[] = [
                    'name' => $indexKey,
                    'total_docs' => $indexValues['total']['docs']['count'],
                    'total_size' => $indexValues['total']['store']['size_in_bytes'],
                ];
            }
        }
        
        return $arrIndexes;
    }

    /**
     * Get the types in the specified index.
     *
     * @param string $index
     *
     * @return array $arrMappingTypes
     */
    public function getIndexMappingTypes($index)
    {
        $arrMappingTypes = [];
        
        if ($this->isConnected) {
            $objIndexes = $this->client->indices();
            $arrMappings = $objIndexes->getMapping([
                'index' => $index,
            ]);

            if (isset($arrMappings[$index]['mappings']) && !empty($arrMappings[$index]['mappings'])) {
                foreach ($arrMappings[$index]['mappings'] as $typeKey => $typeValue) {
                    $arrMappingTypes[] = [
                        'name' => $typeKey,
                    ];
                }
            }
        }
        
        return $arrMappingTypes;
    }

    /**
     * Get the fields in the specified type.
     *
     * @param string $index
     * @param string $type
     *
     * @return array $arrFields
     */
    public function getFieldsInIndexType($index, $type)
    {
        $arrFields = [];
        
        if ($this->isConnected) {
            $objIndexes = $this->client->indices();
            $arrMappings = $objIndexes->getMapping([
                'index' => $index,
            ]);

            if (isset($arrMappings[$index]['mappings'][$type]['properties']) && !empty($arrMappings[$index]['mappings'][$type]['properties'])) {
                foreach ($arrMappings[$index]['mappings'][$type]['properties'] as $typeKey => $typeValue) {
                    $arrFields[] = [
                        'name' => $typeKey,
                        'type' => $typeValue['type'],
                        'index' => isset($typeValue['index']) ? $typeValue['index'] : '',
                    ];
                }
            }
        }
        
        return $arrFields;
    }

    /**
     * Execute a search for a term in the specified fields, index, and type.
     *
     * @param string $index
     * @param string $type
     * @param string $fields
     * @param string $term
     *
     * @return array $results
     */
    public function search($index, $type, $fields, $term)
    {
        if ($this->isConnected) {
            try {
                $arrFields = $this->convertSearchfieldsToArray($fields);

                $params = [
                    'index' => $index,
                    'type' => $type,
                    'body' => [
                        'query' => [
                            'bool' => [
                                'should' => [
                                    'multi_match' => [
                                        'query' => $term,
                                        'operator' => 'or',
                                        'fields' => $arrFields,
                                    ],
                                ],
                            ],
                        ],
                    ],
                ];

                $results = $this->client->search($params);
                if (isset($results['hits']) && isset($results['hits']['hits']) && !empty($results['hits']['hits'])) {
                    return $results['hits']['hits'];
                }
            } catch (\Elasticsearch\Common\Exceptions\BadRequest400Exception $e) {
                return [];
            }
        }
        
        return [];
    }

    /**
     * Get plugins installed on specified elasticsearch node.
     *
     * @return array $arrPlugins
     */
    public function getPlugins()
    {
        if ($this->isConnected) {
            $arrStatsCluster = $this->client->cluster()->stats();
            $arrPlugins = $arrStatsCluster['nodes']['plugins'];

            return $arrPlugins;
        }
        
        return [];
    }

    /**
     * Convert a string of searchfields to an array as expected by the elasticsearch client.
     *
     * @param string $searchfields
     *
     * @return array $arrFields
     */
    public function convertSearchfieldsToArray($searchfields)
    {
        if (strpos($searchfields, ',') !== false) {
            $arrFields = explode(',', $searchfields);
        } else {
            $arrFields = [
                $searchfields,
            ];
        }

        return $arrFields;
    }
}

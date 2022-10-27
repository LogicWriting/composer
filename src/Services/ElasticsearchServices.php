<?php
/**
 * 作者：本
 * 创建时间：2022/10/27 20:39
 * 格言：如果你是这个房间中最聪明的，那么你走错房间了
 */

namespace Zhangzheng\Composer\Services;

class ElasticsearchServices
{
    /**
     * @Desc:
     * 由 PhpStorm 创建
     * @author: 章政
     * @Date Time: 2022/10/27 20:44
     * 描述：初始化创建索引
     */
    public function Init()
    {
        $hosts = [
            '127.0.0.1:9200'
        ];
        $client = \Elasticsearch\ClientBuilder::create()->setHosts($hosts)->build();
        // 创建索引
        $params = [
            'index' => 'goods',
            'body' => [
                'settings' => [
                    'number_of_shards' => 5,
                    'number_of_replicas' => 1
                ],
                'mappings' => [
                    '_doc' => [
                        '_source' => [
                            'enabled' => true
                        ],
                        'properties' => [
                            'title' => [
                                'type' => 'keyword'
                            ],
                            'desn' => [
                                'type' => 'text',
                                'analyzer' => 'ik_max_word',
                                'search_analyzer' => 'ik_max_word'
                            ]
                        ]
                    ]
                ]
            ]
        ];
        $response = $client->indices()->create($params);
    }

    /**
     * @Desc:
     * 由 PhpStorm 创建
     * @author: 章政
     * @Date Time: 2022/10/27 20:44
     * 描述：写入文档
     */
    public function SaveDoc()
    {
        $hosts = [
            '127.0.0.1:9200',
        ];
        $client = \Elasticsearch\ClientBuilder::create()->setHosts($hosts)->build();
        // 写文档
        $params = [
            'index' => 'goods',
            'type' => '_doc',
            'id' => $model->id,
            'body' => [
                'title' => $model->title,
                'desn' => $model->desn,
            ],
        ];
        $response = $client->index($params);
    }

    /**
     * @Desc:
     * @param $indexName
     * @param $field
     * @param $queryVal
     * @return mixed
     * 由 PhpStorm 创建
     * @author: 章政
     * @Date Time: 2022/10/27 20:44
     * 描述：搜索
     */
    public function Search($indexName, $field = '', $queryVal = '')
    {
        $hosts = [
            '127.0.0.1:9200',
        ];
        $client = \Elasticsearch\ClientBuilder::create()->setHosts($hosts)->build();
        $params = [
            'index' => $indexName,
            'type' => '_doc',
            'body' => [
                'query' => [
                    'match' => [
                        $field => [
                            'query' => $queryVal
                        ]
                    ]
                ], 'highlight' => [
                    'pre_tags' => [""],
                    'post_tags' => [''],
                    'fields' => [
                        'fang_name' => new \stdClass()
                    ]
                ]
            ]
        ];
        $results = $client->search($params);
        return $results;
    }




}
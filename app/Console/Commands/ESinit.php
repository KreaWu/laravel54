<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;

class ESinit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'es:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'es init for post';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        //创建template
        $client = new Client();
        $url = config('scout.elasticsearch.hosts')[0].'/template/tmp';
        $client->delete($url);
        $param = [
            'json'=>[
                'template'=>config('scout.elasticsearch.index'),
                'mappings'=>[
                    '_default_'=>[
                        'dynamic_templates'=>[
                            [
                                'strings'=>[
                                    'match_mapping_type'=>'string',
                                    'mapping'=>[
                                        'type'=>'text',
                                        'analyzer'=>'ik_max_word',
                                        'fields'=>[
                                            'keyword'=>[
                                                'type'=>'keyword'
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
            ],
        ];
        $client->put($url,$param);
        $this->info("=========Template Successful!=========");
        // 创建index
        $url = config('scout.elasticsearch.hosts')[0].'/'.config('scout.elasticsearch.index');
        //$client->delete($url);
        $param = [
            'json'=>[
                'settings'=>[
                    'refresh_interval'=>'5s',//更新时间
                    'number_of_shards'=>1,
                    'number_of_replicas'=>0
                ],
                'mappings'=>[
                    '_default_'=>[
                        '_all'=>[
                            'enabled'=>true//是否显示
                        ]
                    ]
                ]
            ]
        ];

        $client->put($url,$param);
        $this->info("=========Index Successful!=========");
        /*//创建template
        $client = new Client();
        $url = config('scout.elasticsearch.hosts')[0].'/_template/tmp';
        //$client->delete($url);

        $param = [
          'json'=>[
              'template'=>config('scout.elasticsearch.index'),
              'mappings'=>[
                  '_default_'=>[
                      'dynamic_templates'=>[
                          [
                              'strings'=>[
                                  'match_mapping_type'=>'string',
                                  'mapping'=>[
                                      'type'=>'text',
                                      'analyzer'=>'ik_smart',
                                      'fields'=>[
                                          'keyword'=>[
                                              'type'=>'keyword'
                                          ]
                                      ]
                                  ]
                              ]
                          ]

                      ]
                  ]
              ],
          ],
        ];
        $client->post($url, $param);
        $this->info("======成功创建模板=====");

        //创建index
        $url = config('scout.elasticsearch.hosts')[0].'/'.config('scout.elasticsearch.index');
        //$client->delete($url);
        $param = [
            'json'=>[
                'settings'=>[
                    'refresh_interval'=>'5s',
                    'number_of_shards'=>1,
                    'number_of_replicas'=>0,
                ],
                'mappings'=>[
                    '_default_'=>[
                        '_all'=>[
                            'enable'=>false
                        ]
                    ]
                ]
            ]
        ];
        $client->put($url,$param);
        $this->info("=====成功创建索引====");*/
    }
}

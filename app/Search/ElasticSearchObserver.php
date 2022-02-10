<?php

namespace App\Search;

use Elasticsearch\Client;

class ElasticSearchObserver
{
    /**
     * @var \Elasticsearch\Client
     */
    private $elasticSearch;

    public function __construct(Client $elasticSearch)
    {
        $this->elasticSearch = $elasticSearch;
    }

    /**
     * Save resource in ElasticSearch when is saved in database
     * 
     * @param mixed $model
     * 
     * @return void
     */
    public function saved($model)
    {
        $this->elasticSearch->index([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'id' => $model->getKey(),
            'body' => $model->toSearchArray(),
        ]);
    }

    /**
     * Deletes resource in ElasticSearch when is deleted in database
     * 
     * @param mixed $model
     * 
     * @return void
     */
    public function deleted($model)
    {
        $this->elasticSearch->delete([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'id' => $model->getKey(),
        ]);
    }
}
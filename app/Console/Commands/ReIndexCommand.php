<?php

namespace App\Console\Commands;

use App\Models\Locale;
use Elasticsearch\ClientBuilder;
use Illuminate\Console\Command;

class ReIndexCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elastic-search:re-index';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Indexes all articles to Elastic Search';

    /**
     * ElasticSearch Client Resource
     *  
     * @var \Elasticsearch\Client
     */
    private $elasticSearch;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->elasticSearch = ClientBuilder::create()
            ->setHosts(config('services.search.hosts'))
            ->build();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info('Indexing all locales. This might take a while...');

        foreach (Locale::cursor() as $locale) {
            $this->elasticSearch->index([
                'index' => $locale->getSearchIndex(),
                'type' => $locale->getSearchType(),
                'id' => $locale->getKey(),
                'body' => $locale->toSearchArray(),
            ]);

            // PHPUnit-style feedback
            $this->output->write('.');
        }

        $this->output->writeln('');
        $this->info("Done!");
    }
}

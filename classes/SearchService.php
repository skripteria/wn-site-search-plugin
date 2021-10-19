<?php

namespace Skripteria\Sitesearch\Classes;


use Cms\Classes\Controller;
use Event;
use Illuminate\Support\Collection;
use LogicException;

// Uncomment your required Providers here
// use Skripteria\Sitesearch\Classes\Providers\ArrizalaminPortfolioResultsProvider;
use Skripteria\Sitesearch\Classes\Providers\CmsPagesResultsProvider;
// use Skripteria\Sitesearch\Classes\Providers\FeeglewebOctoshopProductsResultsProvider;
use Skripteria\Sitesearch\Classes\Providers\GenericResultsProvider;
// use Skripteria\Sitesearch\Classes\Providers\GrakerPhotoAlbumsResultsProvider;
// use Skripteria\Sitesearch\Classes\Providers\IndikatorNewsResultsProvider;
// use Skripteria\Sitesearch\Classes\Providers\JiriJKShopResultsProvider;
// use Skripteria\Sitesearch\Classes\Providers\OfflineSnipcartShopResultsProvider;
// use Skripteria\Sitesearch\Classes\Providers\RadiantWebProBlogResultsProvider;
use Skripteria\Sitesearch\Classes\Providers\WinterBlogResultsProvider;
use Skripteria\Sitesearch\Classes\Providers\WinterPagesResultsProvider;
use Skripteria\Sitesearch\Classes\Providers\ResponsivShowcaseResultsProvider;
use Skripteria\Sitesearch\Classes\Providers\ResultsProvider;
// use Skripteria\Sitesearch\Classes\Providers\VojtaSvobodaBrandsResultsProvider;
use Skripteria\Sitesearch\Models\QueryLog;
use Skripteria\Sitesearch\Models\Settings;

class SearchService
{
    /**
     * @var string
     */
    public $query;
    /**
     * @var Controller
     */
    public $controller;
    /**
     * @var bool
     */
    public $logQueries;

    public function __construct($query, $controller = null)
    {
        $this->query      = $query;
        $this->controller = $controller ?: new Controller();
        $this->logQueries = Settings::get('log_queries', false);
    }

    /**
     * Fetch all available results for the provided query
     *
     * @return ResultCollection
     * @throws \DomainException
     */
    public function results()
    {
        $this->logQuery($this->query);

        $resultsCollection = new ResultCollection();
        $resultsCollection->setQuery($this->query);

        if (trim($this->query) === '') {
            return $resultsCollection;
        }

        $results = $this->resultsProviders();

        $results = $results->map(function (ResultsProvider $provider) {
            $provider->setQuery($this->query);
            $provider->search();

            return $provider->results();
        });

        $resultsCollection->addMany($results->toArray());

        $modified = Event::fire('skripteria.sitesearch.results', $resultsCollection);

        $modified = array_filter($modified);

        return count($modified) > 0 ? $modified[0] : $resultsCollection->sortByDesc('relevance');
    }

    /**
     * Returns all native and the additional results providers.
     *
     * @return Collection
     */
    protected function resultsProviders()
    {
        return collect($this->nativeResultsProviders())
            ->merge($this->additionalResultsProviders());
    }

    /**
     * Return all natively supported results providers.
     *
     * @return ResultsProvider[]
     */
    protected function nativeResultsProviders()
    {
        return [
            // Uncomment the required Provider here

            // new OfflineSnipcartShopResultsProvider(),
            // new RadiantWebProBlogResultsProvider($this->query, $this->controller),
            // new FeeglewebOctoshopProductsResultsProvider(),
            // new JiriJKShopResultsProvider(),
            // new IndikatorNewsResultsProvider(),
            // new ArrizalaminPortfolioResultsProvider(),
            new ResponsivShowcaseResultsProvider(),
            new WinterBlogResultsProvider($this->query, $this->controller),
            new WinterPagesResultsProvider(),
            new CmsPagesResultsProvider(),
            new GenericResultsProvider(),
            // new VojtaSvobodaBrandsResultsProvider(),
            // new GrakerPhotoAlbumsResultsProvider($this->query, $this->controller),
        ];
    }

    /**
     * Gather all additional ResultsProviders that
     * are registered by other plugins.
     *
     * @return ResultsProvider[]
     * @throws \LogicException
     */
    protected function additionalResultsProviders()
    {
        $returns = collect(Event::fire('skripteria.sitesearch.extend'))->filter()->flatten();

        $returns->each(function ($return) {
            if ( ! $return instanceof ResultsProvider) {
                throw new LogicException('The skripteria.sitesearch.extend listener needs to return a ResultsProvider instance.');
            }
        });

        return $returns->toArray();
    }

    /**
     * Log the current query.
     *
     * @return void
     */
    protected function logQuery($query)
    {
        if ( ! $this->logQueries || ! $query) {
            return;
        }

        QueryLog::cleanup();
        QueryLog::create([
            'query' => $query
        ]);
    }
}

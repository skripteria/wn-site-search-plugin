<?php

namespace Winter\SiteSearch\Classes;


use Cms\Classes\Controller;
use Event;
use Illuminate\Support\Collection;
use LogicException;

// Uncomment your required Providers here
// use Winter\SiteSearch\Classes\Providers\ArrizalaminPortfolioResultsProvider;
use Winter\SiteSearch\Classes\Providers\CmsPagesResultsProvider;
// use Winter\SiteSearch\Classes\Providers\FeeglewebOctoshopProductsResultsProvider;
use Winter\SiteSearch\Classes\Providers\GenericResultsProvider;
// use Winter\SiteSearch\Classes\Providers\GrakerPhotoAlbumsResultsProvider;
// use Winter\SiteSearch\Classes\Providers\IndikatorNewsResultsProvider;
// use Winter\SiteSearch\Classes\Providers\JiriJKShopResultsProvider;
// use Winter\SiteSearch\Classes\Providers\OfflineSnipcartShopResultsProvider;
// use Winter\SiteSearch\Classes\Providers\RadiantWebProBlogResultsProvider;
use Winter\SiteSearch\Classes\Providers\WinterBlogResultsProvider;
use Winter\SiteSearch\Classes\Providers\WinterPagesResultsProvider;
use Winter\SiteSearch\Classes\Providers\ResponsivShowcaseResultsProvider;
use Winter\SiteSearch\Classes\Providers\ResultsProvider;
// use Winter\SiteSearch\Classes\Providers\VojtaSvobodaBrandsResultsProvider;
use Winter\SiteSearch\Models\QueryLog;
use Winter\SiteSearch\Models\Settings;

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

        $modified = Event::fire('winter.sitesearch.results', $resultsCollection);

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
        $returns = collect(Event::fire('winter.sitesearch.extend'))->filter()->flatten();

        $returns->each(function ($return) {
            if ( ! $return instanceof ResultsProvider) {
                throw new LogicException('The winter.sitesearch.extend listener needs to return a ResultsProvider instance.');
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

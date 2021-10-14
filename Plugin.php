<?php namespace Winter\SiteSearch;

use Winter\SiteSearch\Models\Settings;
use System\Classes\PluginBase;

/**
 * SiteSearch Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name' => 'winter.sitesearch::lang.plugin.name',
            'description' => 'winter.sitesearch::lang.plugin.description',
            'author' => 'winter.sitesearch::lang.plugin.author',
            'icon' => 'icon-search',
            'homepage' => 'https://github.com/wintercms/wn-site-search-plugin',
        ];
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            'Winter\SiteSearch\Components\SearchResults' => 'searchResults',
            'Winter\SiteSearch\Components\SearchInput' => 'searchInput',
            'Winter\SiteSearch\Components\SiteSearchInclude' => 'siteSearchInclude',
        ];
    }

    /**
     * Registers any back-end permissions.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return [
            'winter.sitesearch.manage_settings' => [
                'tab' => 'winter.sitesearch::lang.plugin.name',
                'label' => 'winter.sitesearch::lang.plugin.manage_settings_permission',
            ],
            'winter.sitesearch.view_log' => [
                'tab' => 'winter.sitesearch::lang.plugin.name',
                'label' => 'winter.sitesearch::lang.plugin.view_log_permission',
            ],
        ];
    }

    /**
     * Registers any back-end settings.
     *
     * @return array
     */
    public function registerSettings()
    {
        $settings = [
            'config' => [
                'label' => 'winter.sitesearch::lang.plugin.name',
                'description' => 'winter.sitesearch::lang.plugin.manage_settings',
                'category' => 'system::lang.system.categories.cms',
                'icon' => 'icon-search',
                'class' => 'Winter\SiteSearch\Models\Settings',
                'order' => 100,
                'keywords' => 'search',
                'permissions' => ['winter.sitesearch.manage_settings'],
            ],
        ];

        if ((bool)Settings::get('log_queries', false) === false) {
            return $settings;
        }

        $settings['querylogs'] = [
            'label' => 'winter.sitesearch::lang.log.title',
            'description' => 'winter.sitesearch::lang.log.description',
            'category' => 'system::lang.system.categories.cms',
            'url' => \Backend::url('winter/sitesearch/querylogs'),
            'keywords' => 'search log query queries',
            'icon' => 'icon-search',
            'permissions' => ['winter.sitesearch.*'],
            'order' => 99,
        ];

        return $settings;
    }
}

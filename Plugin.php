<?php namespace Skripteria\Sitesearch;

use Skripteria\Sitesearch\Models\Settings;
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
            'name' => 'skripteria.sitesearch::lang.plugin.name',
            'description' => 'skripteria.sitesearch::lang.plugin.description',
            'author' => 'skripteria.sitesearch::lang.plugin.author',
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
            'Skripteria\Sitesearch\Components\SearchResults' => 'searchResults',
            'Skripteria\Sitesearch\Components\SearchInput' => 'searchInput',
            'Skripteria\Sitesearch\Components\SiteSearchInclude' => 'siteSearchInclude',
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
            'skripteria.sitesearch.manage_settings' => [
                'tab' => 'skripteria.sitesearch::lang.plugin.name',
                'label' => 'skripteria.sitesearch::lang.plugin.manage_settings_permission',
            ],
            'skripteria.sitesearch.view_log' => [
                'tab' => 'skripteria.sitesearch::lang.plugin.name',
                'label' => 'skripteria.sitesearch::lang.plugin.view_log_permission',
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
                'label' => 'skripteria.sitesearch::lang.plugin.name',
                'description' => 'skripteria.sitesearch::lang.plugin.manage_settings',
                'category' => 'system::lang.system.categories.cms',
                'icon' => 'icon-search',
                'class' => 'Skripteria\Sitesearch\Models\Settings',
                'order' => 100,
                'keywords' => 'search',
                'permissions' => ['skripteria.sitesearch.manage_settings'],
            ],
        ];

        if ((bool)Settings::get('log_queries', false) === false) {
            return $settings;
        }

        $settings['querylogs'] = [
            'label' => 'skripteria.sitesearch::lang.log.title',
            'description' => 'skripteria.sitesearch::lang.log.description',
            'category' => 'system::lang.system.categories.cms',
            'url' => \Backend::url('skripteria/sitesearch/querylogs'),
            'keywords' => 'search log query queries',
            'icon' => 'icon-search',
            'permissions' => ['skripteria.sitesearch.*'],
            'order' => 99,
        ];

        return $settings;
    }
}

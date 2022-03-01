<?php namespace TheFehr\Lighthouse;

use Backend;
use Backend\Models\UserRole;
use System\Classes\PluginBase;
use App;
use Event;
use TheFehr\Lighthouse\Models\Schema;
use TheFehr\Lighthouse\Models\Settings;

/**
 * Lighthouse Plugin Information File
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
            'name'        => 'Lighthouse',
            'description' => 'Implementation of nuwave/lighthouse for WinterCMS',
            'author'      => 'TheFehr',
            'icon'        => 'icon-share-alt'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
        App::register('\TheFehr\Lighthouse\Provider\LighthouseServiceProvider');

        Event::listen(\Nuwave\Lighthouse\Events\BuildSchemaString::class, function ($event) {
            $schemes = Schema::published()->get();
            $schemesBody = Settings::get('base_schema') . "\n" . $schemes->implode("schema", "\n");

            \Log::info(var_export($event, true));
            \Log::info($schemesBody);
            return $schemesBody;
        });
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'GraphQL',
                'description' => 'Manage GraphQL Server.',
                'category'    => 'GraphQL',
                'icon'        => 'icon-globe',
                'class'       => 'TheFehr\Lighthouse\Models\Settings',
                'order'       => 500
            ]
        ];
    }
}

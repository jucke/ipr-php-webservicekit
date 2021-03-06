<?php

namespace BBC\iPlayerRadio\WebserviceKit;

use BBC\iPlayerRadio\WebserviceKit\DataCollector\FixturesDataCollector;
use BBC\iPlayerRadio\WebserviceKit\DataCollector\GuzzleDataCollector;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ProfilerCollectorsServiceProvider implements ServiceProviderInterface
{
    /**
     * @param Container $app A container instance
     */
    public function register(Container $app)
    {
        // Set up the collector:
        $guzzleCollector        = GuzzleDataCollector::instance();
        $fixtureCollector       = FixturesDataCollector::instance();

        $app->extend(
            'data_collectors',
            function ($collectors) use (
                $guzzleCollector,
                $fixtureCollector
            ) {
                $collectors['guzzle'] = function () use ($guzzleCollector) {
                    return $guzzleCollector;
                };
                $collectors['fixtures'] = function () use ($fixtureCollector) {
                    return $fixtureCollector;
                };
                return $collectors;
            }
        );

        /* @var     \Twig_Loader_Filesystem $loader */
        $app->extend('twig.loader.filesystem', function (\Twig_Loader_Filesystem $loader) {
            $loader->addPath(__DIR__.'/../views', 'webservicekit');
            return $loader;
        });

        $app->extend('data_collector.templates', function ($templates) {
            $templates[] = ['guzzle', '@webservicekit/guzzle'];
            $templates[] = ['fixtures', '@webservicekit/fixtures'];
            return $templates;
        });
    }
}

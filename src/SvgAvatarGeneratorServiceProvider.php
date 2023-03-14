<?php

namespace Sowren\SvgAvatarGenerator;

use Sowren\SvgAvatarGenerator\Extractors\Extractor;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class SvgAvatarGeneratorServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('svg-avatar-generator')
            ->hasConfigFile('svg-avatar')
            ->hasRoute('web');
    }

    public function bootingPackage()
    {
        // We are not going to publish these views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'svg');
    }

    public function registeringPackage()
    {
        $this->app->singleton(Extractor::class, fn () => new (config('svg-avatar.extractor')));
    }
}

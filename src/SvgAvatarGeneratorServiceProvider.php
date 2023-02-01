<?php

namespace Sowren\SvgAvatarGenerator;

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
            ->hasRoute('svg-avatar');
    }
}

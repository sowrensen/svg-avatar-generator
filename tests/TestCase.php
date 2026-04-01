<?php

namespace Sowren\SvgAvatarGenerator\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Testing\TestResponse;
use Orchestra\Testbench\TestCase as Orchestra;
use Sowren\SvgAvatarGenerator\SvgAvatarGeneratorServiceProvider;

class TestCase extends Orchestra
{
    // Declared here so that testbench-core's setUp() can reset it via static::$latestResponse.
    // Old testbench-core (9.0.1) calls this but never declared the property; PHP 8.2+ made
    // undeclared static property access a fatal error.
    protected static ?TestResponse $latestResponse = null;

    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Sowren\\SvgAvatarGenerator\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            SvgAvatarGeneratorServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_svg-avatar-generator_table.php.stub';
        $migration->up();
        */
    }
}

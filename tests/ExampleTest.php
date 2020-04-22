<?php

namespace Torosegon\LaravelIcons\Tests;

use Orchestra\Testbench\TestCase;
use Torosegon\LaravelIcons\LaravelIconsServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [LaravelIconsServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}

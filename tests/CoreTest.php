<?php

namespace Akizor\Scaffold\Tests;

use Akizor\Scaffold\Facades\Scaffold;
use Akizor\Scaffold\ServiceProvider;
use Orchestra\Testbench\TestCase;

class ScaffoldTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [
            'scaffold' => Scaffold::class,
        ];
    }

    public function testExample()
    {
        $this->assertEquals(1, 1);
    }
}

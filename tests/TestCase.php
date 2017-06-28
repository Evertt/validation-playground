<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp()
    {
        parent::setUp();

        $this->setUpDatabaseTransaction();
        $this->setUpDatabaseSchema();
    }

    public function setUpDatabaseTransaction()
    {
        $this->app['em']->getConnection()->beginTransaction();

        $this->beforeApplicationDestroyed(function() {
            $this->app['em']->getConnection()->rollBack();
        });
    }

    public function setUpDatabaseSchema($drop = false)
    {
        $this->artisan('doctrine:schema:create');

        $this->app[Kernel::class]->setArtisan(null);
    }
}

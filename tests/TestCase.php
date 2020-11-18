<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public static $setupDatabase = true;

    public function setUp():void
    {
        parent::setUp();

        if(self::$setupDatabase)
        {
            $this->setupDatabase();
        }
    }

    public function setupDatabase()
    {
        Artisan::call('migrate');
        Artisan::call('db:seed');
        self::$setupDatabase = false;
    }
}

<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase
    {
        migrateFreshUsing as traitMigrateFreshUsing;
    }

    protected function migrateFreshUsing()
    {
        return array_merge(
            [
                '--schema-path' => 'database/schema/mysql-schema.dump'
            ],
            $this->traitMigrateFreshUsing()
        );
    }
}

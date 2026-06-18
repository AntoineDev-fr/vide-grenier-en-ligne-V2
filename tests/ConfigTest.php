<?php

use PHPUnit\Framework\TestCase;
use App\Config;

class ConfigTest extends TestCase
{
    public function testDbHostIsNotEmpty()
    {
        $this->assertNotEmpty(Config::getDbHost());
    }

    public function testDbNameIsNotEmpty()
    {
        $this->assertNotEmpty(Config::getDbName());
    }

    public function testDbUserIsNotEmpty()
    {
        $this->assertNotEmpty(Config::getDbUser());
    }
}
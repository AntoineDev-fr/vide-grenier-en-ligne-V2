<?php

namespace App;

class Config
{
    const SHOW_ERRORS = true;

    public static function getDbHost()
    {
        return getenv('DB_HOST');
    }

    public static function getDbName()
    {
        return getenv('DB_NAME');
    }

    public static function getDbUser()
    {
        return getenv('DB_USER');
    }

    public static function getDbPassword()
    {
        return getenv('DB_PASSWORD');
    }
    
    public static function getEnvironment()
    {
        return getenv('APP_ENV');
    }
}
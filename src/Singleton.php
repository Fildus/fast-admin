<?php

namespace DG\InstantAdminBundle;

trait Singleton
{
    private static $instance;

    private static function setInstance($instance)
    {
        self::$instance = $instance;
    }

    public static function getInstance()
    {
        return self::$instance;
    }
}

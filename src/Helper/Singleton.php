<?php

namespace Chetkov\VCSStatisticsCounter\Helper;

/**
 * Trait Singleton
 * @package Chetkov\VCSStatisticsCounter\Helper
 */
trait Singleton
{
    /** @var static */
    private static $instance;

    private function __construct()
    {
    }

    /**
     * @return static
     */
    public static function getInstance()
    {
        if (!static::$instance) {
            static::$instance = new static();
        }
        return static::$instance;
    }
}

<?php

namespace Chetkov\VCSStatisticsCounter\Model;

/**
 * Class AbstractStatistics
 * @package Chetkov\VCSStatisticsCounter\Model
 */
abstract class AbstractStatistics implements Statistics
{
    /** @var static[] */
    private static $instances;

    /** @var string */
    private $name;

    /**
     * AbstractStatistics constructor.
     * @param string $name
     */
    protected function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @param string $name
     * @return static
     */
    public static function getByName(string $name)
    {
        if (!isset(self::$instances[$name])) {
            self::$instances[$name] = new static($name);
        }
        return self::$instances[$name];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}

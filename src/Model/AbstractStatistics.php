<?php

namespace VCSStatisticsCounter\Model;

/**
 * Class AbstractStatistics
 * @package VCSStatisticsCounter\Model
 */
abstract class AbstractStatistics
{
    /** @var static[] */
    private static $instances;

    /** @var string */
    private $uniqueKey;

    /**
     * FactoryMethod constructor.
     * @param string $uniqueKey
     */
    protected function __construct(string $uniqueKey)
    {
        $this->uniqueKey = $uniqueKey;
    }

    /**
     * @param string $uniqueKey
     * @return static
     */
    public static function getByUniqueKey(string $uniqueKey)
    {
        if (!isset(self::$instances[$uniqueKey])) {
            self::$instances[$uniqueKey] = new static($uniqueKey);
        }
        return self::$instances[$uniqueKey];
    }

    /**
     * @return string
     */
    public function getUniqueKey(): string
    {
        return $this->uniqueKey;
    }
}

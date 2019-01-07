<?php

namespace VCSStatisticsCounter\Model;

/**
 * Class StatisticsCollection
 * @package VCSStatisticsCounter\Model
 */
class StatisticsCollection implements \Iterator
{
    /** @var Statistics[] */
    private $statisticsList;

    /** @var int */
    private $position;

    /**
     * StatisticsCollection constructor.
     * @param Statistics[] $statisticsList
     * @throws \RuntimeException
     */
    public function __construct(array $statisticsList = [])
    {
        foreach ($statisticsList as $statistics) {
            if (!$statistics instanceof Statistics) {
                throw new \RuntimeException('One of objects is not Statistics');
            }
        }

        $this->position = 0;
        $this->statisticsList = $statisticsList;
    }

    /**
     * @param Statistics $statistics
     * @param bool $isStrict
     * @return bool
     */
    public function contains(Statistics $statistics, bool $isStrict = true): bool
    {
        return in_array($statistics, $this->statisticsList, $isStrict);
    }

    /**
     * @param Statistics $statistics
     * @return StatisticsCollection
     */
    public function add(Statistics $statistics): self
    {
        $this->statisticsList[] = $statistics;
        return $this;
    }

    /**
     * @param Statistics $statistics
     * @return StatisticsCollection
     */
    public function addOnce(Statistics $statistics): self
    {
        if (!$this->contains($statistics)) {
            $this->add($statistics);
        }
        return $this;
    }

    /**
     * @param string $sortType
     * @param string $sortDirection
     * @return StatisticsCollection
     * @throws \RuntimeException
     */
    public function getSorted(
        string $sortType = Statistics::SORT_TYPE_CHANGED_LINES,
        string $sortDirection = Statistics::SORT_DIRECTION_DESC
    ): self {
        $statisticsList = $this->statisticsList;
        uasort($statisticsList, function (Statistics $a, Statistics $b) use ($sortType, $sortDirection) {
            switch ($sortType) {
                case Statistics::SORT_TYPE_CHANGED_LINES:
                    $aResult = $a->getNumChangedLines();
                    $bResult = $b->getNumChangedLines();
                    break;
                case Statistics::SORT_TYPE_CREATED_LINES:
                    $aResult = $a->getNumCreatedLines();
                    $bResult = $b->getNumCreatedLines();
                    break;
                case Statistics::SORT_TYPE_DELETED_LINES:
                    $aResult = $a->getNumDeletedLines();
                    $bResult = $b->getNumDeletedLines();
                    break;
                case Statistics::SORT_TYPE_CHANGED_FILES:
                    $aResult = $a->getNumChangedFiles();
                    $bResult = $b->getNumChangedFiles();
                    break;
                default:
                    throw new \RuntimeException("Unsupported SORT_TYPE: $sortType");
            }

            $result = $aResult < $bResult ? -1 : 1;
            if ($sortDirection === Statistics::SORT_DIRECTION_DESC) {
                $result *= -1;
            }

            return $result;
        });

        return new self(array_values($statisticsList));
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return StatisticsCollection
     * @throws \RuntimeException
     */
    public function slice(int $limit, int $offset = 0): self
    {
        return new self(array_slice($this->statisticsList, $offset, $limit));
    }

    /**
     * @return Statistics[]
     */
    public function toArray(): array
    {
        return $this->statisticsList;
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    /**
     * @return Statistics
     */
    public function current(): Statistics
    {
        return $this->statisticsList[$this->position];
    }

    public function next(): void
    {
        ++$this->position;
    }

    /**
     * @return int
     */
    public function key(): int
    {
        return $this->position;
    }

    /**
     * @return bool
     */
    public function valid(): bool
    {
        return isset($this->statisticsList[$this->position]);
    }
}

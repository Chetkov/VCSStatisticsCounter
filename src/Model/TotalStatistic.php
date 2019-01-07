<?php

namespace Chetkov\VCSStatisticsCounter\Model;

/**
 * Class TotalStatistic
 * @package Chetkov\VCSStatisticsCounter\Model
 */
class TotalStatistic implements Statistics
{
    /** @var StatisticsCollection|AuthorStatistics[] */
    private $authorsStatistics;

    /** @var StatisticsCollection|RepositoryStatistics[] */
    private $repositoriesStatistics;

    /**
     * TotalStatistic constructor.
     * @throws \RuntimeException
     */
    public function __construct()
    {
        $this->authorsStatistics = new StatisticsCollection();
        $this->repositoriesStatistics = new StatisticsCollection();
    }

    /**
     * @param AuthorStatistics $authorStatistics
     * @return TotalStatistic
     */
    public function addAuthorStatistics(AuthorStatistics $authorStatistics): self
    {
        $this->authorsStatistics->addOnce($authorStatistics);
        return $this;
    }

    /**
     * @param RepositoryStatistics $repositoryStatistics
     * @return TotalStatistic
     */
    public function addRepositoryStatistics(RepositoryStatistics $repositoryStatistics): self
    {
        $this->repositoriesStatistics->addOnce($repositoryStatistics);
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'TotalStatistic';
    }

    /**
     * @return int
     */
    public function getNumChangedLines(): int
    {
        $numChangedLines = 0;
        foreach ($this->repositoriesStatistics as $repositoryStatistics) {
            $numChangedLines += $repositoryStatistics->getNumChangedLines();
        }
        return $numChangedLines;
    }

    /**
     * @return int
     */
    public function getNumCreatedLines(): int
    {
        $numCreatedLines = 0;
        foreach ($this->repositoriesStatistics as $repositoryStatistics) {
            $numCreatedLines += $repositoryStatistics->getNumCreatedLines();
        }
        return $numCreatedLines;
    }

    /**
     * @return int
     */
    public function getNumDeletedLines(): int
    {
        $numDeletedLines = 0;
        foreach ($this->repositoriesStatistics as $repositoryStatistics) {
            $numDeletedLines += $repositoryStatistics->getNumDeletedLines();
        }
        return $numDeletedLines;
    }

    /**
     * @return int
     */
    public function getNumChangedFiles(): int
    {
        $numChangedFiles = 0;
        foreach ($this->repositoriesStatistics as $repositoryStatistics) {
            $numChangedFiles += $repositoryStatistics->getNumChangedFiles();
        }
        return $numChangedFiles;
    }

    /**
     * @param int $limit
     * @param string $sortType
     * @param bool $isSortDirectionDESC
     * @return Statistics[]
     * @throws \RuntimeException
     */
    public function getTopAuthors(
        int $limit = 3,
        string $sortType = Statistics::TYPE_CHANGED_LINES,
        bool $isSortDirectionDESC = true
    ): array {
        return $this->authorsStatistics->getSorted($sortType, $isSortDirectionDESC)->slice($limit)->toArray();
    }

    /**
     * @param int $limit
     * @param string $sortType
     * @param bool $isSortDirectionDESC
     * @return Statistics[]
     * @throws \RuntimeException
     */
    public function getTopRepositories(
        int $limit = 3,
        string $sortType = Statistics::TYPE_CHANGED_LINES,
        bool $isSortDirectionDESC = true
    ): array {
        return $this->repositoriesStatistics->getSorted($sortType, $isSortDirectionDESC)->slice($limit)->toArray();
    }
}

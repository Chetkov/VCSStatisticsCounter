<?php

namespace VCSStatisticsCounter\Model;

/**
 * Class TotalStatistic
 * @package VCSStatisticsCounter\Model
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
     * @param string $sortDirection
     * @return array
     */
    public function getTopAuthors(
        int $limit = 3,
        string $sortType = Statistics::SORT_TYPE_CHANGED_LINES,
        string $sortDirection = Statistics::SORT_DIRECTION_DESC
    ): array {
        return $this->authorsStatistics->getSorted($sortType, $sortDirection)->slice($limit)->toArray();
    }

    /**
     * @param int $limit
     * @param string $sortType
     * @param string $sortDirection
     * @return array
     */
    public function getTopRepositories(
        int $limit = 3,
        string $sortType = Statistics::SORT_TYPE_CHANGED_LINES,
        string $sortDirection = Statistics::SORT_DIRECTION_DESC
    ): array {
        return $this->repositoriesStatistics->getSorted($sortType, $sortDirection)->slice($limit)->toArray();
    }
}

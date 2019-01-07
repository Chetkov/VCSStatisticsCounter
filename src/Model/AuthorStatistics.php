<?php

namespace VCSStatisticsCounter\Model;

/**
 * Class AuthorStatistics
 * @package VCSStatisticsCounter\Model
 */
class AuthorStatistics extends AbstractStatistics implements Statistics
{
    /** @var StatisticsCollection|RepositoryStatistics[] */
    private $repositoriesStatistics;

    /**
     * AuthorStatistics constructor.
     * @param string $author
     */
    protected function __construct(string $author)
    {
        parent::__construct($author);
        $this->repositoriesStatistics = new StatisticsCollection();
    }

    /**
     * @param RepositoryStatistics $repositoryStatistics
     * @return AuthorStatistics
     */
    public function addRepositoryStatistics(RepositoryStatistics $repositoryStatistics): self
    {
        $this->repositoriesStatistics->addOnce($repositoryStatistics);
        return $this;
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
}

<?php

namespace Chetkov\VCSStatisticsCounter\Model;

/**
 * Class RepositoryStatistics
 * @package Chetkov\VCSStatisticsCounter\Model
 */
class RepositoryStatistics extends AbstractStatistics
{
    /** @var StatisticsCollection|ChangedFileStatistics[] */
    private $changedFilesStatistics;

    /**
     * RepositoryStatistics constructor.
     * @param string $repository
     * @throws \RuntimeException
     */
    protected function __construct(string $repository)
    {
        parent::__construct($repository);
        $this->changedFilesStatistics = new StatisticsCollection();
    }

    /**
     * @param ChangedFileStatistics $changedFileStatistics
     * @return RepositoryStatistics
     */
    public function addChangedFileStatistics(ChangedFileStatistics $changedFileStatistics): self
    {
        $this->changedFilesStatistics->addOnce($changedFileStatistics);
        return $this;
    }

    /**
     * @return int
     */
    public function getNumChangedLines(): int
    {
        $numChangedLines = 0;
        foreach ($this->changedFilesStatistics as $changedFileStatistics) {
            $numChangedLines += $changedFileStatistics->getNumChangedLines();
        }
        return $numChangedLines;
    }

    /**
     * @return int
     */
    public function getNumCreatedLines(): int
    {
        $numCreatedLines = 0;
        foreach ($this->changedFilesStatistics as $changedFileStatistics) {
            $numCreatedLines += $changedFileStatistics->getNumCreatedLines();
        }
        return $numCreatedLines;
    }

    /**
     * @return int
     */
    public function getNumDeletedLines(): int
    {
        $numDeletedLines = 0;
        foreach ($this->changedFilesStatistics as $changedFileStatistics) {
            $numDeletedLines += $changedFileStatistics->getNumDeletedLines();
        }
        return $numDeletedLines;
    }

    /**
     * @return int
     */
    public function getNumChangedFiles(): int
    {
        $uniqueChangedFiles = [];
        foreach ($this->changedFilesStatistics as $changedFileStatistics) {
            $uniqueChangedFiles[$changedFileStatistics->getName()] = true;
        }
        return count($uniqueChangedFiles);
    }
}

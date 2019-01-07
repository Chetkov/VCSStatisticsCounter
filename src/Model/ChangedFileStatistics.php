<?php

namespace VCSStatisticsCounter\Model;

/**
 * Class ChangedFileStatistics
 * @package VCSStatisticsCounter\Model
 */
class ChangedFileStatistics implements Statistics
{
    /** @var string */
    private $changedFile;

    /** @var int */
    private $numCreatedLines;

    /** @var int */
    private $numDeletedLines;

    /**
     * Log constructor.
     * @param string $changedFile
     * @param int $numCreatedLines
     * @param int $numDeletedLines
     */
    public function __construct(string $changedFile, int $numCreatedLines, int $numDeletedLines)
    {
        $this->changedFile = $changedFile;
        $this->numCreatedLines = $numCreatedLines;
        $this->numDeletedLines = $numDeletedLines;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->changedFile;
    }

    /**
     * @return int
     */
    public function getNumChangedLines(): int
    {
        return $this->numCreatedLines + $this->numDeletedLines;
    }

    /**
     * @return int
     */
    public function getNumCreatedLines(): int
    {
        return $this->numCreatedLines;
    }

    /**
     * @return int
     */
    public function getNumDeletedLines(): int
    {
        return $this->numDeletedLines;
    }

    /**
     * @return int
     */
    public function getNumChangedFiles(): int
    {
        return 1;
    }

    /**
     * @param string $log
     * @return ChangedFileStatistics
     */
    public static function createByGitLogNumStatResult(string $log): self
    {
        [$numCreatedLines, $numDeletedLines, $changedFile] = explode("\t", $log);
        return new self($changedFile, $numCreatedLines, $numDeletedLines);
    }
}

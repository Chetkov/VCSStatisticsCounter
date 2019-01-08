<?php

namespace Chetkov\VCSStatisticsCounter\VCS\Git;

use Chetkov\VCSStatisticsCounter\Model\ChangedFileStatistics;
use Chetkov\VCSStatisticsCounter\VCS\BranchFilterStrategy;
use Chetkov\VCSStatisticsCounter\VCS\CommandExecutor;
use Chetkov\VCSStatisticsCounter\VCS\LogsRepository;

/**
 * Class GitLogsRepository
 * @package Chetkov\VCSStatisticsCounter\VCS\Git
 */
class GitLogsRepository implements LogsRepository
{
    /** @var CommandExecutor */
    private $commandExecutor;

    /** @var BranchFilterStrategy */
    private $branchesFilter;

    /**
     * GitLogsRepository constructor.
     * @param CommandExecutor $commandExecutor
     * @param BranchFilterStrategy $branchesFilter
     */
    public function __construct(CommandExecutor $commandExecutor, BranchFilterStrategy $branchesFilter)
    {
        $this->commandExecutor = $commandExecutor;
        $this->branchesFilter = $branchesFilter;
    }

    /**
     * @param string $directory
     */
    public function setDirectory(string $directory): void
    {
        $this->commandExecutor->setDirectory($directory);
        $this->branchesFilter->setDirectory($directory);
    }

    /**
     * @param string $author
     * @param \DateTime $startDateTime
     * @return ChangedFileStatistics[]
     */
    public function getLogs(string $author, \DateTime $startDateTime): array
    {
        $rows = $this->commandExecutor->execute(
            'git log ' .
            implode(' ', $this->branchesFilter->getFilteredBranches()) .
            ' --no-merges' .
            ' --pretty=tformat: --numstat' .
            " --after='{$startDateTime->format('Y-m-d H:i:s')}'" .
            " --author='$author'"
        );

        $changedFileLogs = [];
        foreach ($rows as $row) {
            $changedFileLogs[] = ChangedFileStatistics::createByGitLogNumStatResult($row);
        }

        return $changedFileLogs;
    }
}

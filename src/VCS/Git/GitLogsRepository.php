<?php

namespace VCSStatisticsCounter\VCS\Git;

use VCSStatisticsCounter\Model\ChangedFileStatistics;
use VCSStatisticsCounter\VCS\CommandExecutor;
use VCSStatisticsCounter\VCS\LogsRepository;

/**
 * Class GitLogsRepository
 * @package VCSStatisticsCounter\VCS\Git
 */
class GitLogsRepository implements LogsRepository
{
    /** @var CommandExecutor */
    private $commandExecutor;

    /** @var GitLogsRepositoryConfig */
    private $config;

    /** @var string[] */
    private $branchesForCheck;

    /**
     * GitLogsRepository constructor.
     * @param CommandExecutor $commandExecutor
     * @param GitLogsRepositoryConfig $config
     */
    public function __construct(CommandExecutor $commandExecutor, GitLogsRepositoryConfig $config)
    {
        $this->commandExecutor = $commandExecutor;
        $this->config = $config;
    }

    /**
     * @param string $directory
     */
    public function setDirectory(string $directory): void
    {
        $this->branchesForCheck = null;
        $this->commandExecutor->setDirectory($directory);
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
            implode(' ', $this->getBranchesForCheck()) .
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

    /**
     * @return string[]
     */
    private function getBranchesForCheck(): array
    {
        if (!$this->branchesForCheck) {
//            $this->execute('git fetch --all');
            $remoteBranches = $this->commandExecutor->execute('git branch -a -r');
            foreach ($remoteBranches as $remoteBranch) {
                $remoteBranch = trim($remoteBranch);
                foreach ($this->config->getBranchPrefixes() as $branchPrefix) {
                    if (strpos($remoteBranch, $this->config->getServerName() . DIRECTORY_SEPARATOR . $branchPrefix) === 0) {
                        $this->branchesForCheck[] = $remoteBranch;
                    }
                }
            }
        }
        return $this->branchesForCheck;
    }
}

<?php

namespace Chetkov\VCSStatisticsCounter\VCS\Git;

/**
 * Class GitLogsRepositoryConfig
 * @package Chetkov\VCSStatisticsCounter\VCS\Git
 */
class GitLogsRepositoryConfig
{
    /** @var string */
    private $serverName;

    /** @var string[] */
    private $branchPrefixes;

    /**
     * GitLogsRepositoryConfig constructor.
     * @param string $serverName
     * @param string[] $branchPrefixes
     */
    public function __construct(string $serverName, array $branchPrefixes)
    {
        $this->serverName = $serverName;
        $this->branchPrefixes = $branchPrefixes;
    }

    /**
     * @return string
     */
    public function getServerName(): string
    {
        return $this->serverName;
    }

    /**
     * @return string[]
     */
    public function getBranchPrefixes(): array
    {
        return $this->branchPrefixes;
    }
}

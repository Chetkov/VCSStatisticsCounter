<?php

namespace Chetkov\VCSStatisticsCounter\VCS\Git;

use Chetkov\VCSStatisticsCounter\VCS\BranchFilterStrategy;
use Chetkov\VCSStatisticsCounter\VCS\Git\BranchFilter\AllowablePrefixes\AllowablePrefixesStrategy;
use Chetkov\VCSStatisticsCounter\VCS\Git\BranchFilter\AllowablePrefixes\AllowablePrefixesStrategyFactory;

/**
 * Class GitLogsRepositoryFactory
 * @package Chetkov\VCSStatisticsCounter\VCS\Git
 */
class GitLogsRepositoryFactory
{
    /**
     * @param array $config
     * @return GitLogsRepository
     */
    public function create(array $config): GitLogsRepository
    {
        $commandExecutor = GitCommandExecutor::getInstance();
        $branchFilter = $this->createBranchFilterStrategy($config);
        return new GitLogsRepository($commandExecutor, $branchFilter);
    }

    /**
     * @param array $config
     * @return BranchFilterStrategy
     */
    public function createBranchFilterStrategy(array $config): BranchFilterStrategy
    {
        if (!isset($config['branchFilter']['strategy'])) {
            throw new \RuntimeException("Required parameter 'branchFilter->strategy' is not set in config");
        }

        switch ($config['branchFilter']['strategy']) {
            case AllowablePrefixesStrategy::class:
                $strategyFactory = new AllowablePrefixesStrategyFactory();
                break;
            default:
                throw new \RuntimeException("Unsupported branchFilterStrategy: {$config['branchFilter']['strategy']}");
        }

        return $strategyFactory->create($config['branchFilter']);
    }
}

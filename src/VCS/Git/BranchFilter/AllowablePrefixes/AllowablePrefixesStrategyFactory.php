<?php

namespace Chetkov\VCSStatisticsCounter\VCS\Git\BranchFilter\AllowablePrefixes;

use Chetkov\VCSStatisticsCounter\VCS\Git\GitCommandExecutor;

/**
 * Class AllowablePrefixesStrategyFactory
 * @package Chetkov\VCSStatisticsCounter\VCS\Git\BranchFilter\AllowablePrefixes
 */
class AllowablePrefixesStrategyFactory
{
    /**
     * @param array $config
     * @return AllowablePrefixesStrategy
     * @throws \RuntimeException
     */
    public function create(array $config): AllowablePrefixesStrategy
    {
        $commandExecutor = GitCommandExecutor::getInstance();
        $strategyConfig = $this->getMappedConfig($config);
        return new AllowablePrefixesStrategy($commandExecutor, $strategyConfig);
    }

    /**
     * @param array $config
     * @return AllowablePrefixesStrategyConfig
     * @throws \RuntimeException
     */
    private function getMappedConfig(array $config): AllowablePrefixesStrategyConfig
    {
        $this->validateConfig($config);
        return new AllowablePrefixesStrategyConfig($config['vcsRemoteServerName'], $config['branchPrefixes']);
    }

    /**
     * @param array $config
     * @throws \RuntimeException
     */
    private function validateConfig(array $config): void
    {
        if (!isset($config['vcsRemoteServerName'])) {
            throw new \RuntimeException("Required parameter 'branchFilter->vcsRemoteServerName' is not set in config");
        }

        if (!isset($config['branchPrefixes'])) {
            throw new \RuntimeException("Required parameter 'branchFilter->branchPrefixes' is not set in config");
        }
    }
}

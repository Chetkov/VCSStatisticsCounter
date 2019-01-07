<?php

namespace VCSStatisticsCounter\VCS\Git;

/**
 * Class GitLogsRepositoryFactory
 * @package VCSStatisticsCounter\VCS\Git
 */
class GitLogsRepositoryFactory
{
    /**
     * @param array $config
     * @return GitLogsRepository
     */
    public function create(array $config): GitLogsRepository
    {
        $commandExecutor = new GitCommandExecutor();
        $gitLogsRepositoryConfig = $this->getMappedConfig($config);
        return new GitLogsRepository($commandExecutor, $gitLogsRepositoryConfig);
    }

    /**
     * @param array $config
     * @return GitLogsRepositoryConfig
     */
    private function getMappedConfig(array $config): GitLogsRepositoryConfig
    {
        $this->validateConfig($config);
        return new GitLogsRepositoryConfig($config['vcsRemoteServerName'], $config['branchPrefixes']);
    }

    /**
     * @param array $config
     * @throws \RuntimeException
     */
    private function validateConfig(array $config): void
    {
        if (!isset($config['vcsRemoteServerName'])) {
            throw new \RuntimeException("Required parameter 'vcsRemoteServerName' is not set in config");
        }

        if (!isset($config['branchPrefixes'])) {
            throw new \RuntimeException("Required parameter 'branchPrefixes' is not set in config");
        }
    }
}

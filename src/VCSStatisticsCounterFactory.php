<?php

namespace VCSStatisticsCounter;

use VCSStatisticsCounter\VCS\Git\GitLogsRepositoryFactory;
use VCSStatisticsCounter\VCS\LogsRepository;

/**
 * Class VCSStatisticsCounterFactory
 * @package VCSStatisticsCounter
 */
class VCSStatisticsCounterFactory
{
    /**
     * @param array $config
     * @return VCSStatisticsCounter
     */
    public function create(array $config): VCSStatisticsCounter
    {
        $logsRepository = $this->createLogsRepository($config);
        $vcsTotalCounterConfig = $this->getMappedConfig($config);
        return new VCSStatisticsCounter($logsRepository, $vcsTotalCounterConfig);
    }

    /**
     * @param array $config
     * @return LogsRepository
     * @throws \RuntimeException
     */
    private function createLogsRepository(array $config): LogsRepository
    {
        if (!isset($config['vcs'])) {
            throw new \RuntimeException('Required parameter [vcs] is not set in config');
        }

        switch ($config['vcs']) {
            case LogsRepository::VCS_GIT:
                $logsRepositoryFactory = new GitLogsRepositoryFactory();
                break;
            case 'svn':
            case 'mercurial':
                throw new \RuntimeException("VCS [{$config['vcs']}] currently not supported");
            default:
                throw new \RuntimeException("VCS [{$config['vcs']}] is not supported");
        }

        return $logsRepositoryFactory->create($config);
    }

    /**
     * @param array $config
     * @return VCSStatisticsCounterConfig
     * @throws \RuntimeException
     */
    private function getMappedConfig(array $config): VCSStatisticsCounterConfig
    {
        $this->validateConfig($config);
        return new VCSStatisticsCounterConfig($config['rootDirectories'], $config['authors']);
    }

    /**
     * @param array $config
     * @throws \RuntimeException
     */
    private function validateConfig(array $config): void
    {
        if (!isset($config['rootDirectories'])) {
            throw new \RuntimeException("Required parameter 'rootDirectories' is not set in config");
        }

        if (!isset($config['authors'])) {
            throw new \RuntimeException("Required parameter 'authors' is not set in config");
        }
    }
}

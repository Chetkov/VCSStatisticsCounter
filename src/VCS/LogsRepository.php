<?php

namespace VCSStatisticsCounter\VCS;

use VCSStatisticsCounter\Model\ChangedFileStatistics;

/**
 * Interface LogsRepository
 * @package VCSStatisticsCounter\VCS
 */
interface LogsRepository extends SettableDirectory
{
    public const VCS_GIT = 'git';

    /**
     * @param string $author
     * @param \DateTime $startDateTime
     * @return ChangedFileStatistics[]
     */
    public function getLogs(string $author, \DateTime $startDateTime): array;
}

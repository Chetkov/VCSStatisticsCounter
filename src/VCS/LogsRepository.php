<?php

namespace Chetkov\VCSStatisticsCounter\VCS;

use Chetkov\VCSStatisticsCounter\Model\ChangedFileStatistics;

/**
 * Interface LogsRepository
 * @package Chetkov\VCSStatisticsCounter\VCS
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

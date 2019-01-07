<?php

namespace Chetkov\VCSStatisticsCounter;

use Chetkov\VCSStatisticsCounter\Model\AuthorStatistics;
use Chetkov\VCSStatisticsCounter\Model\RepositoryStatistics;
use Chetkov\VCSStatisticsCounter\Model\TotalStatistic;
use Chetkov\VCSStatisticsCounter\VCS\LogsRepository;

/**
 * Class VCSStatisticsCounter
 * @package Chetkov\VCSStatisticsCounter
 */
class VCSStatisticsCounter
{
    /** @var LogsRepository */
    private $logsRepository;

    /** @var VCSStatisticsCounterConfig */
    private $config;

    /**
     * VCSStatisticsCounter constructor.
     * @param LogsRepository $logsRepository
     * @param VCSStatisticsCounterConfig $config
     */
    public function __construct(LogsRepository $logsRepository, VCSStatisticsCounterConfig $config)
    {
        $this->logsRepository = $logsRepository;
        $this->config = $config;
    }

    /**
     * @param \DateTime $startDateTime
     * @return TotalStatistic
     * @throws \RuntimeException
     */
    public function getTotalStatistic(\DateTime $startDateTime): TotalStatistic
    {
        $counterTotalsResult = new TotalStatistic();
        foreach ($this->config->getVcsRootDirectories() as $directory) {
            $this->logsRepository->setDirectory($directory);

            $repositoryTotals = RepositoryStatistics::getByName($directory);
            foreach ($this->config->getAuthors() as $author) {
                $authorTotals = AuthorStatistics::getByName($author);
                $authorRepositoryTotals = RepositoryStatistics::getByName("$author:$directory");

                $changedFileLogs = $this->logsRepository->getLogs($author, $startDateTime);
                foreach ($changedFileLogs as $changedFileLog) {
                    $authorRepositoryTotals->addChangedFileStatistics($changedFileLog);
                    $repositoryTotals->addChangedFileStatistics($changedFileLog);
                }

                $authorTotals->addRepositoryStatistics($authorRepositoryTotals);
                $counterTotalsResult->addAuthorStatistics($authorTotals);
            }

            $counterTotalsResult->addRepositoryStatistics($repositoryTotals);
        }
        return $counterTotalsResult;
    }
}

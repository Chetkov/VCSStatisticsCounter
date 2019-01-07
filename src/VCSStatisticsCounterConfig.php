<?php

namespace Chetkov\VCSStatisticsCounter;

/**
 * Class VCSStatisticsCounterConfig
 * @package Chetkov\VCSStatisticsCounter
 */
class VCSStatisticsCounterConfig
{
    /** @var string[] */
    private $vcsRootDirectories;

    /** @var string[] */
    private $authors;

    /**
     * VCSStatisticsCounterConfig constructor.
     * @param string[] $vcsRootDirectories
     * @param string[] $authors
     */
    public function __construct(array $vcsRootDirectories, array $authors)
    {
        $this->vcsRootDirectories = $vcsRootDirectories;
        $this->authors = $authors;
    }

    /**
     * @return string[]
     */
    public function getVcsRootDirectories(): array
    {
        return $this->vcsRootDirectories;
    }

    /**
     * @return string[]
     */
    public function getAuthors(): array
    {
        return $this->authors;
    }
}

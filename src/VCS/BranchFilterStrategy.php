<?php

namespace Chetkov\VCSStatisticsCounter\VCS;

/**
 * Interface BranchFilterStrategy
 * @package Chetkov\VCSStatisticsCounter\VCS
 */
interface BranchFilterStrategy extends SettableDirectory
{
    /**
     * @return array
     */
    public function getFilteredBranches(): array;
}
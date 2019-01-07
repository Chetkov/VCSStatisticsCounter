<?php

namespace Chetkov\VCSStatisticsCounter\VCS;

/**
 * Interface SettableDirectory
 * @package Chetkov\VCSStatisticsCounter\VCS
 */
interface SettableDirectory
{
    /**
     * @param string $directory
     */
    public function setDirectory(string $directory): void;
}

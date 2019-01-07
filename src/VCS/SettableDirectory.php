<?php

namespace VCSStatisticsCounter\VCS;

/**
 * Interface SettableDirectory
 * @package VCSStatisticsCounter\VCS
 */
interface SettableDirectory
{
    /**
     * @param string $directory
     */
    public function setDirectory(string $directory): void;
}

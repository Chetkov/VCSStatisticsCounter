<?php

namespace Chetkov\VCSStatisticsCounter\VCS;

/**
 * Interface CommandExecutor
 * @package Chetkov\VCSStatisticsCounter\VCS
 */
interface CommandExecutor extends SettableDirectory
{
    /**
     * @param string $command
     * @return string[]
     */
    public function execute(string $command): array;
}

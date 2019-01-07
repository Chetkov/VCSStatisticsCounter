<?php

namespace VCSStatisticsCounter\VCS;

/**
 * Interface CommandExecutor
 * @package VCSStatisticsCounter\VCS
 */
interface CommandExecutor extends SettableDirectory
{
    /**
     * @param string $command
     * @return string[]
     */
    public function execute(string $command): array;
}

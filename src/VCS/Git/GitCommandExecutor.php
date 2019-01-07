<?php

namespace Chetkov\VCSStatisticsCounter\VCS\Git;

use Chetkov\VCSStatisticsCounter\VCS\CommandExecutor;

/**
 * Class GitCommandExecutor
 * @package Chetkov\VCSStatisticsCounter\VCS\Git
 */
class GitCommandExecutor implements CommandExecutor
{
    /** @var string */
    private $directory;

    /**
     * @param string $directory
     */
    public function setDirectory(string $directory): void
    {
        $this->validateDirectory($directory);
        $this->directory = $directory;
    }

    /**
     * @param string $command
     * @return string[]
     */
    public function execute(string $command): array
    {
        if (!$this->directory) {
            throw new \RuntimeException('Directory is not set');
        }

        $result = [];
        exec("cd $this->directory \n $command", $result);
        return $result;
    }

    /**
     * @param string $directory
     * @throws \RuntimeException
     */
    private function validateDirectory(string $directory): void
    {
        if (!file_exists($directory)) {
            throw new \RuntimeException('Directory was not found');
        }

//        if ($this->execute('git status') === 'fatal: Not a git repository (or any of the parent directories): .git') {
//            throw new \RuntimeException('Directory is not a GIT repository');
//        }
    }
}

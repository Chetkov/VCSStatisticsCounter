<?php

namespace Chetkov\VCSStatisticsCounter\VCS\Git\BranchFilter\AllowablePrefixes;

use Chetkov\VCSStatisticsCounter\VCS\CommandExecutor;
use Chetkov\VCSStatisticsCounter\VCS\BranchFilterStrategy;

/**
 * Class AllowablePrefixesStrategy
 * @package Chetkov\VCSStatisticsCounter\VCS\Git\BranchFilter\AllowablePrefixes
 */
class AllowablePrefixesStrategy implements BranchFilterStrategy
{
    /** @var CommandExecutor */
    private $commandExecutor;

    /** @var AllowablePrefixesStrategyConfig */
    private $config;

    /** @var string[] */
    private $filteredBranches = [];

    /**
     * AllowablePrefixesStrategy constructor.
     * @param CommandExecutor $commandExecutor
     * @param AllowablePrefixesStrategyConfig $config
     */
    public function __construct(CommandExecutor $commandExecutor, AllowablePrefixesStrategyConfig $config)
    {
        $this->commandExecutor = $commandExecutor;
        $this->config = $config;
    }

    /**
     * @return string[]
     */
    public function getFilteredBranches(): array
    {
        if (!$this->filteredBranches) {
            $this->commandExecutor->execute('git fetch --all');
            $remoteBranches = $this->commandExecutor->execute('git branch -a -r');
            foreach ($remoteBranches as $remoteBranch) {
                $remoteBranch = trim($remoteBranch);
                foreach ($this->config->getBranchPrefixes() as $branchPrefix) {
                    if (strpos($remoteBranch, $this->config->getServerName() . DIRECTORY_SEPARATOR . $branchPrefix) === 0) {
                        $this->filteredBranches[] = $remoteBranch;
                    }
                }
            }
        }
        return $this->filteredBranches;
    }

    /**
     * @param string $directory
     */
    public function setDirectory(string $directory): void
    {
        $this->commandExecutor->setDirectory($directory);
        $this->filteredBranches = [];
    }
}

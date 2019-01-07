<?php

namespace Chetkov\VCSStatisticsCounter\Model;

/**
 * Interface Statistics
 * @package Chetkov\VCSStatisticsCounter\Model
 */
interface Statistics
{
    public const TYPE_CHANGED_LINES = 'changed_lines';
    public const TYPE_CREATED_LINES = 'created_lines';
    public const TYPE_DELETED_LINES = 'deleted_lines';
    public const TYPE_CHANGED_FILES = 'changed_files';

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return int
     */
    public function getNumChangedLines(): int;

    /**
     * @return int
     */
    public function getNumCreatedLines(): int;

    /**
     * @return int
     */
    public function getNumDeletedLines(): int;

    /**
     * @return int
     */
    public function getNumChangedFiles(): int;
}

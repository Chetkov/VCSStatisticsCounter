<?php

namespace VCSStatisticsCounter\Model;

/**
 * Interface Statistics
 * @package VCSStatisticsCounter\Model
 */
interface Statistics
{
    public const SORT_TYPE_CHANGED_LINES = 'changed_lines';
    public const SORT_TYPE_CREATED_LINES = 'created_lines';
    public const SORT_TYPE_DELETED_LINES = 'deleted_lines';
    public const SORT_TYPE_CHANGED_FILES = 'changed_files';

    public const SORT_DIRECTION_ASC = 'ASC';
    public const SORT_DIRECTION_DESC = 'DESC';

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

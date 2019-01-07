<?php

use Chetkov\VCSStatisticsCounter\Model\Statistics;
use Chetkov\VCSStatisticsCounter\VCSStatisticsCounterFactory;

require_once 'vendor/autoload.php';

$vcsStatisticsCounterFactory = new VCSStatisticsCounterFactory();
$vcsStatisticsCounter = $vcsStatisticsCounterFactory->create(require __DIR__ . '/config/config.local.php');

$totalStatistic = $vcsStatisticsCounter->getTotalStatistic(new DateTime('2018-11-28'));

//==================== ТОПЫ АВТОРОВ ====================

//ТОП-3 авторов по кол-ву измененных строк
$topAuthorsByNumChangedLines = $totalStatistic->getTopAuthors(3, Statistics::TYPE_CHANGED_LINES);

//ТОП-3 авторов по кол-ву новых строк
$topAuthorsByNumCreatedLines = $totalStatistic->getTopAuthors(3, Statistics::TYPE_CREATED_LINES);

//ТОП-3 авторов по кол-ву удалённых строк
$topAuthorsByNumDeletedLines = $totalStatistic->getTopAuthors(3, Statistics::TYPE_DELETED_LINES);

//ТОП-3 авторов по кол-ву измененных файлов
$topAuthorsByNumChangedFiles = $totalStatistic->getTopAuthors(3, Statistics::TYPE_CHANGED_FILES);


//==================== ТОПЫ РЕПОЗИТОРИЕВ ====================

//ТОП-3 репозиториев по кол-ву измененных строк
$topRepositoriesByNumChangedLines = $totalStatistic->getTopRepositories(3, Statistics::TYPE_CHANGED_LINES);

//ТОП-3 репозиториев по кол-ву новых строк
$topRepositoriesByNumCreatedLines = $totalStatistic->getTopRepositories(3, Statistics::TYPE_CREATED_LINES);

//ТОП-3 репозиториев по кол-ву удалённых строк
$topRepositoriesByNumDeletedLines = $totalStatistic->getTopRepositories(3, Statistics::TYPE_DELETED_LINES);

//ТОП-3 репозиториев по кол-ву измененных файлов
$topRepositoriesByNumChangedFiles = $totalStatistic->getTopRepositories(3, Statistics::TYPE_CHANGED_FILES);
